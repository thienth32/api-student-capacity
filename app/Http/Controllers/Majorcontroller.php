<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class Majorcontroller extends Controller
{

    public function listMajor()
    {
        try {
            $limit = 10;
            $dataMajor = Major::sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'majors')
                ->search(request('search') ?? null,['name','slug'])
                ->paginate(request('limit') ?? $limit);

            return response()->json([
                'status' => true,
                'payload' => $dataMajor->toArray()
            ],200);

        }catch(\Throwable $e) {
            return response()->json(
                [
                    'status' => false,
                    'payload' => 'Máy chủ bị lỗi , liên hệ quản trị viên để khắc phục sự cố  !'
                ],
                506
            );
        }

    }

    public function store(Request $request)
    {

    }
}
