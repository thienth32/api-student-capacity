<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExamExport;
use App\Http\Controllers\Controller;
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
}