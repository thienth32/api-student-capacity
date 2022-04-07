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
                ->search(request('search') ?? null, ['name', 'slug'])
                ->paginate(request('limit') ?? $limit);

            return response()->json([
                'status' => true,
                'payload' => $dataMajor->toArray()
            ], 200);
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

    public function store(Request $request)
    {
        try {
            $slug = \Str::slug($request->name);
            Major::create([
                'name' => $request->name,
                'slug' => $slug,
            ]);

            return response()->json(
                [
                    'status' => true,
                    'payload' => 'Thành công '
                ]
            );
        } catch (\Throwable $h) {
            return response()->json(
                [
                    'status' => false,
                    'payload' => ' Quá trình tạo  chuyên ngành thất bại !'
                ]
            );
        }
    }

    public function edit($id)
    {
        try {
            $major = Major::find($id);
            $this->checkMajor($major);

            return response()->json(
                [
                    'status' => true,
                    'payload' => $major
                ]
            );
        } catch (\Throwable $h) {
            return response()->json(
                [
                    'status' => false,
                    'payload' => ' Quá trình lấy thông tin chuyên ngành thất bại !'
                ]
            );
        }
    }

    public function update($id, Request $request)
    {
        try {
            $major = Major::find($id);
            $this->checkMajor($major);

            $slug = \Str::slug($request->name);
            $major->update([
                'name' => $request->name,
                'slug' => $slug,
            ]);

            return response()->json(
                [
                    'status' => true,
                    'payload' => $major
                ]
            );
        } catch (\Throwable $h) {
            return response()->json(
                [
                    'status' => false,
                    'payload' => ' Quá trình lấy thông tin chuyên ngành thất bại !'
                ]
            );
        }
    }

    public function destroy($id)
    {
        try {

            $major = Major::find($id);
            $this->checkMajor($major);
            $major->delete();

            return response()->json(
                [
                    'status' => true,
                    'payload' => 'Thành công'
                ]
            );
        } catch (\Throwable $h) {
            return response()->json(
                [
                    'status' => false,
                    'payload' => ' Quá trình xóa chuyên ngành thất bại !'
                ]
            );
        }
    }

    public function checkMajor($major)
    {
        if (!$major)  return response()->json(
            [
                'status' => false,
                'payload' => ' Không tìm thấy chuyên ngành !'
            ]
        );
    }
}