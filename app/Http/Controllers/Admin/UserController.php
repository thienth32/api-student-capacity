<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function TeamUserSearch(Request $request)
    {
        $users = User::search($request->key)->take(4)->get();
        return response()->json($users, 200);
    }
}