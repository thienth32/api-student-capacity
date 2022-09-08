<?php

namespace App\Exports;

use App\Services\Modules\MExam\MExamInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExamExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private $id)
    {
    }

    public function collection()
    {
        return app(MExamInterface::class)->getResult($this->id);
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
        ];
    }
}