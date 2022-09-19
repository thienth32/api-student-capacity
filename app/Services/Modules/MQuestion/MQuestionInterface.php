<?php

namespace App\Services\Modules\MQuestion;

interface MQuestionInterface
{
    public function findById($id, $with = [], $select = []);

    public function createQuestionsAndAttchSkill($question, $skill);
}