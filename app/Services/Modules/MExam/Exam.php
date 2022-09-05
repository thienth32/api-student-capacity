<?php

namespace App\Services\Modules\MExam;

use App\Models\Exam as ModelsExam;

class Exam implements MExamInterface
{

    public function __construct(
        private ModelsExam $model
    ) {
    }
    public function findById($id, $with = [], $select = [], $countWith = true)
    {
        if (count($select) > 0) {
            if ($countWith === true) {
                $data = $this->model::select($select)->whereId($id)->with($with)->withCount($with)->first();
            } else {
                $data = $this->model::select($select)->whereId($id)->withCount($with)->first();
            }
        } else {
            if ($countWith === true) {
                $data = $this->model::whereId($id)->with($with)->withCount($with)->first();
            } else {
                $data = $this->model::whereId($id)->withCount($with)->first();
            }
        }

        return $data;
    }
    public function find($id)
    {
        return $this->model::find($id);
    }
    public function whereGet($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with)->get();
    }
    public function where($param = [])
    {
        return $this->model::hasRequest($param);
    }
}