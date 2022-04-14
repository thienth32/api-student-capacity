<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}