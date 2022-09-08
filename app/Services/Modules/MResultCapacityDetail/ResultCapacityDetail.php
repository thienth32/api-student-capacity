<?php

namespace App\Services\Modules\MResultCapacityDetail;

use App\Models\Exam;
use App\Models\ResultCapacity;
use App\Models\ResultCapacityDetail as ModelsResultCapacityDetail;

class ResultCapacityDetail implements MResultCapacityDetailInterface
{
    public function __construct(
        private ModelsResultCapacityDetail $model,
        private ResultCapacity $resultCapacity,
        private Exam $exam
    ) {
    }

    public function create($data = [])
    {
        return $this->model::create($data);
    }

    public function getHistoryByResultCapacityId($id)
    {
        $resultCapacity =  $this->resultCapacity::find($id);
        $exam = $this->exam::find($resultCapacity->exam_id);

        $exam->load([
            'questions' => function ($q) use ($id) {
                return $q->with([
                    'answers' => function ($q) {
                        return $q->select(['id', 'content', 'question_id', 'is_correct']);
                    },
                    'resultCapacityDetail' => function ($q)  use ($id) {
                        return $q
                            ->where('result_capacity_id', $id);
                    }
                ]);
            },

        ]);

        return $exam;
    }
}