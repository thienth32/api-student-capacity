<?php

namespace App\Exports;

use App\Services\Modules\MRound\MRoundInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HistoryTeamsResultContestExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private $id)
    {
    }

    public function collection()
    {
        return app(MRoundInterface::class)->getTeamByRoundId($this->id, true);
    }

    public function headings(): array
    {
        return [
            "ID đội thi",
            "Tên đội thi",
            "Thời gian chốt điểm ",
            "Điểm ",
        ];
    }

    public function map($data): array
    {
        return [
            $data->id,
            $data->name,
            $data->result->created_at,
            $data->result->point,
        ];
    }
}