<?php

namespace App\Services\Modules\MExam;

interface MExamInterface
{
    public function findById($id, $with = [], $select = [], $countWith = true);
    public function find($id);
    public function whereGet($param = [], $with = []);
    public function where($param = []);
}