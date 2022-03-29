<?php

namespace App\Http\Controllers;

use App\Models\Round;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RoundController extends Controller
{
    use TResponse;
    private $round;

    public function __construct(Round $round)
    {
        $this->round = $round;
    }

    /**
     *  Get list round
     */
    private function getList()
    {
        try {
            $data = $this->round::search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'desc' : 'asc'), request('sort_by') ?? null, 'rounds')
                ->hasReuqest([
                    'contest_id' => request('contest_id') ?? null,
                    'type_exam_id' => request('type_exam_id') ?? null,
                ])
                ->with([
                    'contest',
                    'type_exam',
                ])
                ->paginate(request('limit') ?? 10);
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View round
    public function index()
    {
        if (!($data = $this->getList())) return view('not_found');
        $data = $this->getList();
        return view('', ['rounds' => $data]);
    }

    //  Response round
    public function apiIndex()
    {

        if (!($data = $this->getList())) return $this->responseApi(
            [
                "status" => false,
                "payload" => "Server not found",
            ],
            404
        );

        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data,
            ]
        );
    }
    /**
     *  End list round
     */

    /**
     *  Update round
     */

    private function updateRound($id)
    {
        try {
            if (!($round = $this->round::find($id))) return false;
            $validator = Validator::make(
                request()->all(),
                [
                    'name' => "required",
                    'start_time' => "required|date_format:Y-m-d H:i:s|",
                    'end_time' => "required|date_format:Y-m-d H:i:s|after:start_time",
                    'description' => "required",
                    'contest_id' => "required",
                    'type_exam_id' => "required",
                ],
                [
                    "name.required" => "Tường name không bỏ trống !",
                    "start_time.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                    "start_time.date_format" => "Tường thời gian  bắt đầu không khớp !",
                    "end_time.required" => "Tường thời gian kết thúc không bỏ trống !",
                    "end_time.date_format" => "Tường thời gian kết thúc không khớp !",
                    "end_time.after" => "Tường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                    "description.required" => "Tường mô tả không bỏ trống !",
                    "contest_id.required" => "Tường cuộc thi tồn tại !",
                    "type_exam_id.required" => "Tường loại thi không tồn tại !",
                ]
            );
            if ($validator->fails()) return [
                'status' => false,
                'errors' => $validator,
            ];
            $data = null;
            if (request()->has('image')) {
                $validator  =  Validator::make(
                    request()->all(),
                    [
                        'image' => 'mimes:jpeg,jpg,png|max:10000'
                    ],
                    [
                        'image.max' => 'Ảnh không quá 10000 kb  !',
                        'image.mimes' => 'Ảnh không đúng định dạng: jpeg,jpg,png !',
                    ]
                );
                if ($validator->fails()) return [
                    'status' => false,
                    'errors' => $validator,
                ];
                if (Storage::disk('google')->has($round->image)) Storage::disk('google')->delete($round->image);
                // $nameFile = uniqid() . '-' . time() . '_img.' . request()->image->getClientOriginalExtension();
                $nameFile = $this->uploadFile(request()->image);
                // Storage::disk('google')->putFileAs('', request()->image, $nameFile);
                $data = array_merge(request()->except('image'), [
                    'image' => $nameFile
                ]);
            } else {
                $data = request()->all();
            }
            $round->update($data);
            return $round;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function update($id)
    {
        if ($data = $this->updateRound($id)) {
            if (isset($data['status']) && $data['status'] == false) return redirect()->back()->withErrors($data['errors']);
            return redirect('');
        }
        return redirect('error');
    }
    // Response round
    // public function apiUpdate($id)
    // {
    //     if ($data = $this->updateRound($id)) {
    //         if (isset($data['status']) && $data['status'] == false) return response()->json([
    //             "status" => false,
    //             "payload" => $data['errors']->errors(),
    //         ]);
    //         return response()->json([
    //             "status" => true,
    //             "payload" => $data,
    //         ]);
    //     }

    //     return response()->json([
    //         "status" => false,
    //         "payload" => "Server not found",
    //     ], 404);
    // }
    /**
     * End update round
     */

    /**
     * Destroy round
     */

    private function destroyRound($id)
    {
        try {
            $data = $this->round::find($id);
            if (Storage::disk('google')->has($data->image)) Storage::disk('google')->delete($data->image);
            $data->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function destroy($id)
    {
        if ($this->destroyRound($id)) return redirect('');
        return redirect('error');
    }

    // Response
    // public function apiDestroy($id)
    // {
    //     if ($this->destroyRound($id))  return response()->json([
    //         "status" => true,
    //         "payload" => "Success"
    //     ]);
    //     return response()->json([
    //         "status" => false,
    //         "payload" => "Server not found"
    //     ], 404);
    // }
    /**
     *  End destroy round
     */
}