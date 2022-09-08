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
    public function find($id)
    {
    }

    public function where($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with)->first();
    }
}