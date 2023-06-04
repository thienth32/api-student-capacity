<?php

namespace App\Exports;

use App\Models\Recruitment;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RecruitmentsExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function sheets(): array
    {
        return [
            new RecruitmentsByPostExport(),
            new RecruitmentsByCandidateExport(),
        ];
    }
}
