<?php

namespace App\Services\Modules\MQuestion;

use App\Models\Question as ModelsQuestion;
use App\Services\Modules\MQuestion\MQuestionInterface;

class Question implements MQuestionInterface
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

    public function createQuestionsAndAttchSkill($question, $skill)
    {
        $question =  $this->model::create($question);
        if (count($skill) > 0)  $question->skills()->attach($skill);
        return $question;
    }
}