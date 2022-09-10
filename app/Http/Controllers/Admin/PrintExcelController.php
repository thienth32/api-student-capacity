<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DetailCapacityResultEport;
use App\Exports\ExamExport;
use App\Exports\HistoryTeamsResultContestExport;
use App\Http\Controllers\Controller;
use App\Services\Modules\MResultCapacityDetail\MResultCapacityDetailInterface;
use Illuminate\Http\Request;
use Excel;

class PrintExcelController extends Controller
{
    public function printf()
    {
        if (!request('type')) return 'No excel file';
        $type = request('type') . "EXCEL";
        return $this->$type(request());
    }

    public function historyExamEXCEL($r)
    {
        return Excel::download(new ExamExport($r->exam_id), time() . '.xlsx');
    }

    public function historyDetailCapacityEXCEL($r)
    {
        if (!isset($r->capacity_result_id)) return 'No excel file';
        return Excel::download(new DetailCapacityResultEport($r->capacity_result_id), time() . '.xlsx');
    }

    public function historyTeamsResultContestEXCEL($r)
    {
        if (!isset($r->round_id)) return 'No excel file';
        return Excel::download(new HistoryTeamsResultContestExport($r->round_id), time() . '.xlsx');
    }
}