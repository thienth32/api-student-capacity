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
        $model = $this->model::whereId($id)->first();
        $model->update($data);
        return $model;
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function where($param = [], $with = [], $flagGet = false, $limit = 0)
    {
        $model = $this->model::hasRequest($param)->with($with);
        if ($flagGet)
            return $model->orderBy('true_answer', 'desc')->take($limit)->get();
        return $model->first();
    }

    // public function updateStatusEndRenderScores($data = [])
    // {
    //     $resultCapacity = $this->model::where("exam_id", $data['exam']->id)
    //         ->get();
    //     foreach ($resultCapacity as $result) {
    //         $cores = (int) $result->true_answer / (int) count(json_decode($data['exam']->room_progress) ?? []);
    //         $result->update([
    //             "status" => 1,
    //             "scores" => $cores * (int) $data['exam']->max_ponit
    //         ]);
    //     };
    // }
}