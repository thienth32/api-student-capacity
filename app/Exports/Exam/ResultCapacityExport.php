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
            'Sinh vien',
            'Mail',
            "So diem",
            "Trang thai",
            "Chon dung",
            "Chon sai",
            "Chua tra loi"
        ];
    }

    public function map($data): array
    {
        return [
            $data->user->name,
            $data->user->email,
            $data->scores,
            $data->status == 1 ? 'Đã nộp' : 'Chưa nộp ',
            $data->false_answer,
            $data->true_answer,
            $data->donot_answer,
        ];
    }

    public function title(): string
    {
        return "Tổng quan";
    }
}
