<?php

namespace App\Services\Modules\MResultCapacity;

use App\Models\ResultCapacity as ModelsResultCapacity;

class ResultCapacity implements MResultCapacityInterface
{

    public function __construct(
        private ModelsResultCapacity $model
    ) {
    }
    public function findByUserExam($user_id, $exam_id)
    {
        $data = $this->model::where('user_id', $user_id)
            ->where('exam_id', $exam_id)->first();
        return $data;
    }

    public function whereInExamUser($examArr = [], $user_id)
    {
        return $this->model::where('user_id', $user_id)
            ->whereIn('exam_id', $examArr)->first();
    }

    public function create($data = [])
    {
        return $this->model::create($data);
    }

    public function update($id, $data)
    {
        return $this->model::whereId($id)->update($data);
    }

    public function find($id)
    {
    }

    public function where($param = [], $with = [], $flagGet = false, $limit = 0)
    {
        $model = $this->model::hasRequest($param)->with($with);
        if ($flagGet)
            return $model->orderBy('true_answer', 'desc')->take($limit)->get();
        return $model->first();
    }

    public function updateStatusEndRenderScores($data = [])
    {
        $resultCapacity = $this->model::where("exam_id", $data['exam']->id)
            ->get();
        foreach ($resultCapacity as $key => $result) {
            $cores = ($result->true_answer / $data['exam']->questions_count) *  $data['exam']->max_ponit;
            $result->update([
                "status" => 1,
                "scores" => $cores
            ]);
        };
    }
}