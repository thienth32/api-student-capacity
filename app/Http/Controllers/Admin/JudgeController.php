<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Judge;
use App\Models\Round;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JudgeController extends Controller
{
    use TResponse;
    public function attachJudge(Request $request, $id)
    {

        try {
            Round::find($id)->judges()->attach($request->user_id);
            return $this->responseApi([
                'status' => true,
                'payload' => 'Thêm thành công !!',
            ]);
        } catch (\Throwable $th) {
            return $this->responseApi([
                'status' => false,
                'payload' => $th,
            ]);
        }
    }
    public function detachJudge(Request $request, $id)
    {
        try {
            Round::find($id)->judges()->detach($request->user_id);
            return $this->responseApi([
                'status' => true,
                'payload' => 'Xóa thành công !!',
            ]);
        } catch (\Throwable $th) {
            return $this->responseApi([
                'status' => false,
                'payload' => $th,
            ]);
        }
    }
    public function syncJudge(Request $request, $id)
    {
        try {
            Round::find($id)->judges()->sync($request->user_id);
            return $this->responseApi([
                'status' => true,
                'payload' => 'Cập nhật thành công !!',
            ]);
        } catch (\Throwable $th) {
            return $this->responseApi([
                'status' => false,
                'payload' => $th,
            ]);
        }
    }
}