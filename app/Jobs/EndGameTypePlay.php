<?php

namespace App\Jobs;

use App\Events\BeforNextGame;
use App\Events\EndGameEvent;
use App\Models\JobQueue;
use App\Services\Modules\MExam\MExamInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EndGameTypePlay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $code, public $exam_id, public $tokenQueue)
    {
    }

    public function handle()
    {
        broadcast(new BeforNextGame($this->code));
        app(MExamInterface::class)->updateCapacityPlay($this->exam_id, [
            "status" => 2
        ]);
        broadcast(new EndGameEvent($this->code));
        JobQueue::where('token_queue', $this->tokenQueue)->delete();
    }
}