<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Member;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function listContest(Request $request)
    {
        try {
            return response()->json([
                'status' => true,
                'payload' => $dataContent->toArray()
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}