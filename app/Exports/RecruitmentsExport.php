<?php

namespace App\Exports;

use App\Models\Recruitment;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecruitmentsExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new RecruitmentsByPostExport($this->startDate,$this->endDate),
            new RecruitmentsByCandidateExport($this->startDate,$this->endDate),
        ];
    }
}
