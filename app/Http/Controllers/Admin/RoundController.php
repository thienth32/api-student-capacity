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
use Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        return view('pages.round.index', [
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
     *  Store round
     */

    public function create()
    {
        $contests = Contest::all();
        $typeexams = TypeExam::all();
        return view('pages.round.form-add', compact('contests', 'typeexams'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'description' => 'required',
                'contest_id' => 'required|numeric',
                'type_exam_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'image.mimes' => 'Sai định dạng !',
                'image.required' => 'Chưa nhập trường này !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'start_time.required' => 'Chưa nhập trường này !',
                'end_time.required' => 'Chưa nhập trường này !',
                'end_time.after' => 'Thời gian kết thúc không được bằng thời gian bắt đầu !',
                'description.required' => 'Chưa nhập trường này !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
                'type_exam_id.required' => 'Chưa nhập trường này !',
                'type_exam_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                $filename = $this->uploadFile($fileImage);
            }
            $round = new Round();
            $round->name = $request->name;
            $round->image = $filename;
            $round->start_time = $request->start_time;
            $round->end_time = $request->end_time;
            $round->description = $request->description;
            $round->contest_id = $request->contest_id;
            $round->type_exam_id = $request->type_exam_id;
            $round->save();
            Db::commit();
            return Redirect::route('admin.round.list');
        } catch (Exception $ex) {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            Db::rollBack();
            return Redirect::back()->with(['error' => 'Thêm mới thất bại !']);
        }
    }
    /**
     *  End store round
     */



    /**
     *  Edit
     */

    public function edit($id)
    {
        try {
            return view('pages.round.edit', [
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
            return redirect(route('admin.round.list'));
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
            if (!(auth()->user()->hasRole('super admin'))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = $this->round::find($id))) return false;
                if (Storage::disk('google')->has($data->image)) Storage::disk('google')->delete($data->image);
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
        if (!(auth()->user()->hasRole('super admin'))) return redirect()->back()->with('error', 'Không thể xóa ');
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
    private function roundJudges($id)
    {
        $rounds = Round::find($id);
        $rounds->load('judges');
        return $rounds;
    }

    public function roundDetailJudges($id)
    {
        $rounds = $this->roundJudges($id);
        return view('pages.judges.list', compact('rounds'));
    }
    public function roundDetailJudgesApi($id)
    {
        // return response()->json($id, 200);

        $rounds = $this->roundJudges($id);
        return response()->json(['payload' => $rounds], 200);
    }
}