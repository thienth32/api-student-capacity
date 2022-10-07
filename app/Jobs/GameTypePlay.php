<?php

namespace App\Jobs;

use App\Events\BeforNextGame;
use App\Events\NextGameEvent;
use App\Events\PlayGameEvent;
use App\Models\JobQueue;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use App\Services\Modules\MResultCapacity\MResultCapacityInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GameTypePlay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $examRepo;
    public $resultCapacityRepo;
    public $questionRepo;
    public function __construct(public $code, public $type, public $time, public $tokenQueue, public $next = false)
    {
        $this->examRepo = app(MExamInterface::class);
        $this->resultCapacityRepo = app(MResultCapacityInterface::class);
        $this->questionRepo = app(MQuestionInterface::class);
    }

    public function handle()
    {
        try {
            if ($this->type == "GAME_TYPE_1") $this->gameType1();
            if ($this->type == "GAME_TYPE_2") $this->gameType2();
        } catch (\Throwable $th) {
            JobQueue::where('token_queue', $this->tokenQueue)->update(['status' => 3, 'error' => 'Trò chơi có mã : ' . $this->code . ' lỗi ' . $th->getMessage() . $th->getLine() . $th->getFile()]);
        }
    }

    public function getExam()
    {
        return $this->examRepo->getExamBtyTokenRoom($this->code, ['questions' => function ($q) {
            return $q->with(['answers:id,question_id,content']);
        }], ['questions']);
    }


    public function gameType1()
    {
        broadcast(new BeforNextGame($this->code));
        $exam = $this->getExam();

        $ranks = $this->resultCapacityRepo->where([
            "exam_id" => $exam->id,
        ], ['user'], true, 5)->toArray();
        $questions = $exam->questions[0];

        $exam = $this->examRepo->updateCapacityPlay($exam->id, [
            "room_token" => MD5(uniqid() . time()),
        ]);

        broadcast(new PlayGameEvent($this->code, $exam->token, $questions->toArray(), $ranks));
        dispatch(new EndGameTypePlay($this->code, $exam->id, $this->tokenQueue))->delay(now()->addMinutes($this->time));
    }

    public function gameType2()
    {
        broadcast(new BeforNextGame($this->code));
        $exam = $this->getExam();

        $ranks = $this->resultCapacityRepo->where([
            "exam_id" => $exam->id,
        ], ['user'], true, 5)->toArray();

        if ($exam->room_token) {
            $PROGRESS = json_decode($exam->room_progress) ?? [];
            if ($exam->questions_count == count($PROGRESS)) {
                dispatch(new EndGameTypePlay($this->code, $exam->id, $this->tokenQueue));
                return;
            } else {

                $question = $this->questionRepo->findById($this->next, ['answers:id,question_id,content']);
                array_push($PROGRESS, $question->id);

                $next = false;
                foreach ($exam->questions as $question) {
                    if (!in_array($question->id, $PROGRESS)) {
                        $next = $question->id;
                        break;
                    }
                }

                $this->examRepo->updateCapacityPlay($exam->id, [
                    "room_progress" => json_encode($PROGRESS)
                ]);

                broadcast(new NextGameEvent($this->code, $exam->token, $question->toArray(), $ranks));
                dispatch(new GameTypePlay($this->code, "GAME_TYPE_2", $this->time, $this->tokenQueue, $next))
                    ->delay(now()->addSeconds($this->time));
            }
        } else {
            $question = $exam->questions[0];
            $next = $exam->questions[1]->id;
            $exam = $this->examRepo->updateCapacityPlay($exam->id, [
                "room_token" => MD5(uniqid() . time()),
                "room_progress" => json_encode([$question->id])
            ]);
            broadcast(new PlayGameEvent($this->code, $exam->token, $question->toArray(), $ranks));
            dispatch(new GameTypePlay($this->code, "GAME_TYPE_2", $this->time, $this->tokenQueue, $next))
                ->delay(now()->addSeconds($this->time));
        }
    }
}