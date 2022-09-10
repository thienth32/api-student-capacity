<?php

namespace App\Imports;

use App\Models\Question;
use App\Services\Modules\MAnswer\MAnswerInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection
{
    public function collection(Collection  $rows)
    {
        $arr = [];
        $count = 0;
        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            if ($row[0] !== null) {
                $count = $count + 1;
                if ($count > 1) {
                    $this->storeQuestionAnswer([
                        'questions' => $arr['questions'],
                        'skill' => $arr['skill'],
                        'answers' => $arr['answers'],
                    ]);
                };

                $arr = [];
                $arr['questions']['content'] = $row[1];
                $arr['questions']['type'] = $row[0];
                $arr['questions']['rank'] = $row[5];
                $arr['skill']  = explode(",", $row[4]);
                $dataA = [
                    "content" => $row[2],
                    "is_correct" => $row[3] ?? 0,
                ];
                $arr['answers'] = [];
                array_push($arr['answers'], $dataA);
            } else {
                $dataA = [
                    "content" => $row[2],
                    "is_correct" => $row[3] ?? 0,
                ];
                array_push($arr['answers'], $dataA);
            }
        }

        $this->storeQuestionAnswer([
            'questions' => $arr['questions'],
            'skill' => $arr['skill'],
            'answers' => $arr['answers'],
        ]);
    }

    public function storeQuestionAnswer($data)
    {
        DB::beginTransaction();
        try {
            throw new \Exception("Error question");
            $question = app(MQuestionInterface::class)->createQuestionsAndAttchSkill($data['questions'], $data['skill']);
            if (!$question) throw new \Exception("Error question");
            app(MAnswerInterface::class)->createAnswerByIdQuestion($data['answers'], $question->id);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->withErrors(["error", $th->getMessage()]);
        }
    }
}