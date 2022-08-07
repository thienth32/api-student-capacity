<?php

namespace App\Services\Modules\MQuestion;

use App\Models\Question as ModelsQuestion;

class Question
{

    public function __construct(
        private ModelsQuestion $model
    ) {
    }
    public function findById($id, $with = [], $select = [])
    {
        if (count($select) > 0) {
            return $this->model::select($select)->whereId($id)->with($with)->first();
        } else {
            return $this->model::whereId($id)->with($with)->first();
        }
    }
}