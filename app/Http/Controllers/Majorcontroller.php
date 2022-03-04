<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class Majorcontroller extends Controller
{

    public function listMajor()
    {

        $dataMajor = Major::all();
        return response()->json([
            'status' => true,
            'dataMajor' => $dataMajor->toArray()
        ]);
    }
}
