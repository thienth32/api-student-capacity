<?php

namespace App\Imports;

use App\Models\Question;
use App\Services\Modules\MAnswer\MAnswerInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            $line = $key + 1;

            if ($row[0] != null  || trim($row[0]) != "") {
                $count = $count + 1;
                if ($count > 1) {
                    $this->storeQuestionAnswer($arr);
                };
                $arr = [];
                $arr['questions']['content'] = $this->catchError($row[1], "Thiếu câu hỏi dòng $line");
                $arr['questions']['type'] = $row[0] == config("util.EXCEL_QESTIONS")["TYPE"] ? 0 : 1;
                $rank = $this->catchError($row[5], "Thiếu mức độ dòng $line");
                $arr['questions']['rank'] = ($rank == config("util.EXCEL_QESTIONS")["RANKS"][0]) ? 0 : (($row[5] == config("util.EXCEL_QESTIONS")["RANKS"][1]) ? 1 : 2);
                $arr['skill']  = explode(",", $this->catchError($row[4], "Thiếu kỹ năng dòng $line"));
                $dataA = [
                    "content" => $this->catchError($row[2], "Thiếu câu trả lời dòng $line"),
                    "is_correct" => $row[3] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
                ];
                $arr['answers'] = [];
                array_push($arr['answers'], $dataA);
            } else {
                if (($row[2] == null || trim($row[2]) == "")) continue;
                $dataA = [
                    "content" => $row[2],
                    "is_correct" => $row[3] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
                ];
                array_push($arr['answers'], $dataA);
            }
        }
        $this->storeQuestionAnswer($arr);
    }

    public function catchError($data, $message)
    {
        if (($data == null || trim($data) == "")) {
            throw new \Exception($message);
        }
        return $data;
    }

    public function storeQuestionAnswer($data)
    {
        DB::transaction(function () use ($data) {
            $question = app(MQuestionInterface::class)->createQuestionsAndAttchSkill($data['questions'], $data['skill']);
            if (!$question) throw new \Exception("Error create question ");
            app(MAnswerInterface::class)->createAnswerByIdQuestion($data['answers'], $question->id);
        });
    }
}