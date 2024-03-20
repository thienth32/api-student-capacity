<?php

namespace App\Exports;

use App\Exports\Exam\ResultCapacityDetailExport;
use App\Exports\Exam\ResultCapacityExport;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MRound\MRoundInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExamExport implements WithMultipleSheets
{
    public function __construct(private $id)
    {
    }

    public function sheets(): array
    {
        $data = app(MRoundInterface::class)->getResult($this->id)->load([
            'user' => function ($query) {
                $query->select('id', 'name', 'email');
            },
            'resultCapacityDetail:result_capacity_id,question_id,answer_id',
            'examBelongTo' => function ($query) {
                $query
                    ->select('id', 'name', 'max_ponit', 'ponit', 'round_id', 'status', 'type', 'time', 'time_type')
                    ->with([
                        'questions:id,content,status,type,rank',
                        'questions.answers:id,question_id,content,is_correct'
                    ]);
            },
        ]);

        $sheets = [
            new ResultCapacityExport($data),
        ];

        foreach ($data as $item) {
            $sheets[] = new ResultCapacityDetailExport($item);
        }

        return $sheets;
    }
}
