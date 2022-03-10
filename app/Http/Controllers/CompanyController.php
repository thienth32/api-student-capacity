<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function listCompany()
    {
        $dataCompany = company::all();
        return response()->json([
            'status' => true,
            'dataContest' => $dataCompany->toArray()
        ]);
    }
    public function FeedbackCompany()
    {
        $dataFeedback = company::all();
        $dataFeedback->load('feedbacks');
        return response()->json([
            'status' => true,
            'dataFeedback' => $dataFeedback->toArray()
        ]);
    }
}
