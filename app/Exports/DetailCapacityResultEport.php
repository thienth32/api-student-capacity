<?php

namespace App\Exports;

use App\Services\Modules\MResultCapacityDetail\MResultCapacityDetailInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DetailCapacityResultEport implements FromCollection, WithHeadings, WithMapping
{

    public function __construct(private $id)
    {
    }

    public function collection()
    {
        return app(MResultCapacityDetailInterface::class)->getHistoryByResultCapacityId($this->id)->questions;
    }

    public function headings(): array
    {
        return [
            "Id",
            "Câu hỏi ",
            "Câu trả lời ",
            "Đáp án  ",
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->content,
            json_encode($data->answers->map(function ($data) {
                return [
                    $data->id,
                    $data->content,
                    $data->is_correct == 1 ? "Đáp án đúng" : "Đáp án sai"
                ];
            })),
            json_encode($data->resultCapacityDetail->map(function ($data) {
                return [
                    $data->answer_id
                ];
            }))
        ];
    }
}