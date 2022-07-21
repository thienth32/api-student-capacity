<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/public/sponsors",
     *     description="Description api sponsor",
     *     tags={"Sponsor"},
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function list(Request $request)
    {
        $sponsors = Sponsor::all();
        return response()->json([
            'status' => true,
            'payload' => $sponsors->toArray()
        ]);
    }
}
