<?php

namespace App\Exports\Exam;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ResultCapacityExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Thí sinh',
            'Email',
            "Điểm hệ thống",
            "Trạng thái",
            "Số câu đúng",
            "Số câu sai",
            "Số câu chưa làm",
            "Điểm tổng kết"
        ];
    }

    public function map($data): array
    {
        $total_question = $data->true_answer + $data->false_answer + $data->donot_answer;

        return [
            $data->user->name,
            $data->user->email,
            $data->scores,
            $data->status == 1 ? 'Đã nộp' : 'Chưa nộp ',
            $data->true_answer ?? '0',
            $data->false_answer ?? '0',
            $data->donot_answer ?? '0',
            $total_question ? round($data->true_answer/$total_question, 2)*10 : '0'
        ];
    }

    public function title(): string
    {
        return "Tổng quan";
    }
}
