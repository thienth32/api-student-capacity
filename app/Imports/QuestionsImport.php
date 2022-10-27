<?php

namespace App\Imports;

use App\Models\Question;
use App\Services\Modules\MAnswer\MAnswerInterface;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionsImport implements ToCollection
{
    public function __construct(public $exam_id = null)
    {
    }

    public function collection(Collection  $rows)
    {
        $arr = [];
        $count = 0;
        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            $line = $key + 1;

            if (
                $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']] != null
                || trim($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']]) != ""
            ) {
                $count = $count + 1;
                if ($count > 1) {
                    $this->storeQuestionAnswer($arr);
                };
                $arr = [];
                $arr['questions']['content'] = $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['QUESTION']], "Thiếu câu hỏi dòng $line");
                $arr['questions']['type'] = $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['TYPE']] == config("util.EXCEL_QESTIONS")["TYPE"] ? 0 : 1;
                $rank = $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['RANK']], "Thiếu mức độ dòng $line");
                $arr['questions']['rank'] = (($rank == config("util.EXCEL_QESTIONS")["RANKS"][0]) ? 0 : (($rank == config("util.EXCEL_QESTIONS")["RANKS"][1]) ? 1 : 2));
                $arr['skill'] = [];
                if (isset($row[config("util.EXCEL_QESTIONS")['KEY_COLUMNS']['SKILL']]))
                    $arr['skill'] = explode(",", $row[config("util.EXCEL_QESTIONS")['KEY_COLUMNS']['SKILL']] ?? "");

                $dataA = [
                    "content" => $this->catchError($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']], "Thiếu câu trả lời dòng $line"),
                    "is_correct" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']["IS_CORRECT"]] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
                ];
                $arr['answers'] = [];
                array_push($arr['answers'], $dataA);
            } else {
                if (($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']] == null || trim($row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']]) == "")) continue;
                $dataA = [
                    "content" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']['ANSWER']],
                    "is_correct" => $row[config('util.EXCEL_QESTIONS')['KEY_COLUMNS']["IS_CORRECT"]] == config("util.EXCEL_QESTIONS")["IS_CORRECT"] ? 1 : 0,
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
            if ($this->exam_id) app(MExamInterface::class)->attachQuestion($this->exam_id, $question->id);
            app(MAnswerInterface::class)->createAnswerByIdQuestion($data['answers'], $question->id);
        });
    }
}