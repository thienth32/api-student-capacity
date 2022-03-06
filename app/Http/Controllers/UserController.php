<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'payload' => $users->toArray()
        ]);
    }

    public function get_user_by_token(Request $request){
        return response([
            'status' => true,
            'payload' => $request->user()->toArray()
        ]);
    }
}
