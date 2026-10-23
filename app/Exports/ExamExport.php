<?php

namespace App\Exports;

use App\Exports\Exam\ResultCapacityDetailExport;
use App\Exports\Exam\ResultCapacityExport;
use App\Exports\Exam\QuestionAnalyticsExport;
use App\Models\Exam;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MRound\MRoundInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Question;
use App\Models\ResultCapacity;
use App\Models\ResultCapacityDetail;
use Illuminate\Support\Facades\DB;

class ExamExport implements WithMultipleSheets
{
    public function __construct(private $id)
    {
    }

    private function getQuestionAnalytics()
    {
        $examIdsInRound = Exam::where('round_id', $this->id)->pluck('id');
        $analytics = DB::table('questions')
            ->select(
                'questions.id as question_id',
                'questions.content as question_text',
                DB::raw('count(case when answers.is_correct = 1 then 1 else null end) as correct_answers'),
                DB::raw('count(result_capacity_detail.id) as total_answers')
            )
            ->leftJoin('result_capacity_detail', 'questions.id', '=', 'result_capacity_detail.question_id')
            ->leftJoin('result_capacity', 'result_capacity_detail.result_capacity_id', '=', 'result_capacity.id')
            ->leftJoin('answers', function ($join) {
                $join->on('result_capacity_detail.question_id', '=', 'answers.question_id')
                     ->whereColumn('result_capacity_detail.answer_id', '=', 'answers.id');
            })
            ->whereIn('result_capacity.exam_id', $examIdsInRound)
            ->groupBy('questions.id')
            ->get();

        return $analytics;
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

        $questionData = $this->getQuestionAnalytics();

        $sheets = [
            new ResultCapacityExport($data),
            new QuestionAnalyticsExport($questionData),
        ];

        foreach ($data as $item) {
            $sheets[] = new ResultCapacityDetailExport($item);
        }

        return $sheets;
    }
}
