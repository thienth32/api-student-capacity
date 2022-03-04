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

    public function index()
    {
        // List
        try {

            $limit = 10;
            $user = User::query();

            $user->when(request('sort'), function ($q) {
                return $q->orderBy(request('sort_by') ?? 'id', (request('sort') == 'desc' ? 'desc' : 'asc'));
            });
            $user->when(request('search'), function ($q) {
                $str = \Str::slug(request('search'), " ");
                return $q->where('name', 'like', "%$str%")->orWhere('email', 'like', "%$str%");
            });
            $user = $user->paginate(request('limit') ?? $limit);

            return response()->json(
                [
                    'status' => true,
                    'data' => $user
                ],
                201
            );
        } catch (\Throwable $e) {

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Server error ! '
                ],
                506
            );
        }
    }
}