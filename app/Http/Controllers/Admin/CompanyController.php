<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/companys",
     *     description="Description api company",
     *     tags={"Company"},
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function listCompany()
    {
        $dataCompany = Company::all();
        return response()->json([
            'status' => true,
            'dataContest' => $dataCompany->toArray()
        ]);
    }
}
