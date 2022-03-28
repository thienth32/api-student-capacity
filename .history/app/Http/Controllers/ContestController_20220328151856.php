<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Member;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function listContest(Request $request, Contest $contest)
    {
        try {
            $data = $contest::search($request->q ?? null, ['name', 'description'])
                ->status($request->status)
                ->sort(request('sort') == 'desc' ? 'desc' : 'asc', request('sort_by') ?? null, 'contests')
                ->paginate($request->limit ?? 10);
            return response()->json([
                'status' => true,
                'payload' => $data,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}