<?php

namespace App\Http\Controllers\Admin;

use App\Models\Round;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\TypeExam;
use Illuminate\Support\Facades\DB;

class RoundController extends Controller
{
    use TResponse, TUploadImage;
    private $round;
    private $contest;
    private $type_exam;

    public function __construct(Round $round, Contest $contest, TypeExam $type_exam)
    {
        $this->round = $round;
        $this->contest = $contest;
        $this->type_exam = $type_exam;
    }

    /**
     *  Get list round
     */
    private function getList()
    {
        try {
            $data = $this->round::search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'rounds')
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    ((request('day') ? 'day' : '') ??
                        (request('month') ? 'month' : '') ??
                        (request('year') ? 'year' : '')) ?? null,
                    (request('day') ??
                        request('month') ??
                        request('year')) ?? null,
                    'start_time'
                )
                ->hasReuqest([
                    'contest_id' => request('contest_id') ?? null,
                    'type_exam_id' => request('type_exam_id') ?? null,
                ])
                ->with([
                    'contest',
                    'type_exam',
                ]);

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View round
    public function index()
    {
        if (!($rounds = $this->getList())) return view('not_found');

        $rounds = $this->getList();
        return view('pages.rounds.index', [
            'rounds' => $rounds->paginate(request('limit') ?? 5),
            'contests' => $this->contest::withCount(['teams', 'rounds'])->get(),
            'type_exams' => $this->type_exam::all(),
        ]);
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
                "payload" => $data->get(),
            ]
        );
    }

    /**
     *  End list round
     */

    /**
     *  Edit
     */

    public function edit($id)
    {
        try {
            return view('pages.rounds.edit', [
                'round' => $this->round::where('id', $id)->get()->map->format()[0],
                'contests' => $this->contest::all(),
                'type_exams' => $this->type_exam::all(),
            ]);
        } catch (\Throwable $th) {
            return view('error');
        }
    }

    /**
     *  End edit round
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
                    'start_time' => "required",
                    'end_time' => "required|after:start_time",
                    'description' => "required",
                    'contest_id' => "required",
                    'type_exam_id' => "required",
                ],
                [
                    "name.required" => "Tường name không bỏ trống !",
                    "start_time.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                    "end_time.required" => "Tường thời gian kết thúc không bỏ trống !",
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
                        'image' => 'file|mimes:jpeg,jpg,png|max:10000'
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
                $nameFile = $this->uploadFile(request()->image, $round->image);
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
            return redirect(route('web.round.list'));
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
            DB::transaction(function () use ($id) {
                if (!($data = $this->round::find($id))) return false;
                if (Storage::disk('google')->has($data->image)) Storage::disk('google')->delete($data->image);
                $data->results()->delete();
                $data->delete();
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function destroy($id)
    {
        if ($this->destroyRound($id)) return redirect()->back();
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