<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Modules\MExam\MExamInterface;
use Illuminate\Http\Request;
use App\Exports\ExamExport;
use App\Services\Modules\MRound\MRoundInterface;
use PDF;
use Excel;

class PrintPDFController extends Controller
{
    public function __construct(private MRoundInterface $roundRp)
    {
    }

    public function printf()
    {

        if (!request('type')) return 'No pdf file';
        $type = request('type') . "PDF";
        $data = $this->$type(request());
        $pdf = PDF::loadView('pdf.' . $data['view'], ['data' => $data['data']]);

        return $pdf->download(time() . '.pdf');
    }

    public function historyExamPDF($r)
    {
        return [
            'data' => $this->roundRp->getResult($r->exam_id),
            'view' => 'exam-result'
        ];
    }
}