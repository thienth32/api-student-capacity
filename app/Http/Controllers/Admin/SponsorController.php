<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function list(Request $request)
    {
        $sponsors = Sponsor::all();
        return response()->json([
            'status' => true,
            'payload' => $sponsors->toArray()
        ]);
    }
}