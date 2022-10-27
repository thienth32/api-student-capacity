<?php

namespace App\Services\Modules\MExam;

interface MExamInterface
{
    public function findById($id, $with = [], $select = [], $countWith = true);

    public function find($id);

    public function whereGet($param = [], $with = []);

    public function where($param = []);

    public function getResult($id);

    public function getExamCapacityPlay($params = [], $with = []);

    public function storeCapacityPlay($data);

    public function updateCapacityPlay($id, $data);

    public function getExamBtyTokenRoom($code, $with = []);

    public function attachQuestion($id, $questionsId);

    public function getCapacityPlayGameOnline();
}