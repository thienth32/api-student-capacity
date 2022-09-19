<?php

namespace App\Services\Modules\MAnswer;

interface MAnswerInterface
{
    public function findById($id, $param = [], $with = []);

    public function whereInId($id = [], $param = []);

    public function createAnswerByIdQuestion($data, $id);
}