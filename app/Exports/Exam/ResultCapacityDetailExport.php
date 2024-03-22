<?php

namespace App\Exports\Exam;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResultCapacityDetailExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{

    public $resultCapacity;

    public function __construct($resultCapacity)
    {
        $this->resultCapacity = $resultCapacity;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collect = collect();

        foreach ($this->resultCapacity->examBelongTo->questions as $question) {
            $firstAns = $question->answers->first();

            $collect->push([
                'id' => $question->id,
                'type' => $question->type ?? '',
                'rank' => $question->rank ?? '',
                'content' => $question->content,
                'ans_id' => $firstAns->id,
                'ans_content' => $firstAns->content,
                'is_correct' => $firstAns->is_correct,
            ]);

            foreach ($question->answers->slice(1) as $answer) {
                $collect->push([
                    'id' => $question->id,
                    'type' => '',
                    'rank' => '',
                    'content' => '',
                    'ans_id' => $answer->id,
                    'ans_content' => $answer->content,
                    'is_correct' => $answer->is_correct,
                ]);
            }
        }

        return $collect;
    }

    public function headings(): array
    {
        return [
            'Thể loại câu hỏi',
            "Mức độ",
            'Câu hỏi',
            "Câu trả lời",
            "Đáp án đúng",
            "Đáp án của sinh viên",
            "Trạng thái trả lời"
        ];
    }

    public function map($data): array
    {
        $resultDetail = $this->resultCapacity->resultCapacityDetail
            ->where('question_id', $data['id'])
            ->first();
        $ans_id = $data['ans_id'];

        $is_correct = $data['is_correct'];

        $status = '';

        if ((is_null($resultDetail) || empty($resultDetail->answer_id))) {
            $status = $data['type'] !== '' ? 'Chưa trả lời' : '';
        } else if ($resultDetail->answer_id == $ans_id) {
            $status = $is_correct == 1 ? 'Trả lời đúng' : 'Trả lời sai';
        }

        return [
            $data['type'] == '' ? '' : ($data['type'] == 0 ? 'Một đáp án' : 'Nhiều đáp án'),
            config('util.EXCEL_QESTIONS.RANKS')[$data['rank']] ?? '',
            strip_tags($data['content']),
            strip_tags($data['ans_content']),
            $is_correct ? 'Đáp án đúng' : '',
            $resultDetail && $resultDetail->answer_id == $ans_id ? 'X' : '',
            $status
        ];
    }

    public function title(): string
    {
        return $this->resultCapacity->user->email;
    }
}
