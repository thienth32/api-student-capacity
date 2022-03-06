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
            $users = User::status(request('status') ?? null)
                ->sort(request('sort') == 'desc' ? 'desc' : 'asc', request('sort_by') ?? null, 'users')
                ->search(request('search') ?? null)
                ->has_role(request('role') ?? null)
                ->paginate(request('limit') ?? $limit);

            return response()->json(
                [
                    'status' => true,
                    'payload' => $users
                ],
                200
            );
        } catch (\Throwable $e) {

            return response()->json(
                [
                    'status' => false,
                    'payload' => 'Máy chủ bị lỗi , liên hệ quản trị viên để khắc phục sự cố  !'
                ],
                506
            );
        }
    }
}