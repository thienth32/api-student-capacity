<?php

namespace App\Services\Modules\MResultCapacity;

interface MResultCapacityInterface
{
    public function findByUserExam($user_id, $exam_id);
    public function whereInExamUser($examArr = [], $user_id);
    public function create($data = []);
    public function update($id, $data);
    public function find($id);
    public function where($param = [], $with = [], $flagGet = false, $limit = 0);
    // public function updateStatusEndRenderScores($data = []);
}