<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContestController extends Controller
{
    use TUploadImage, TResponse;
    private $contest;
    private $major;

    public function __construct(Contest $contest, Major $major)
    {
        $this->contest = $contest;
        $this->major = $major;
    }

    /**
     *  Get list contest
     */
    private function getList()
    {
        try {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $data = $this->contest::search(request('q') ?? null, ['name', 'description'])
                ->missingDate('register_deadline', request('miss_date') ?? null, $now->toDateTimeString())
                ->passDate('register_deadline', request('pass_date') ?? null, $now->toDateTimeString())
                // ->passDate('date_start', request('upcoming_date') ?? null, $now->toDateTimeString())
                ->status(request('status'))
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
                ->hasDateTimeBetween('date_start', request('start_time') ?? null, request('end_time') ?? null)
                ->hasReuqest(['major_id' => request('major_id') ?? null])
                ->with([
                    'major',
                    'teams',
                    'rounds',
                    'enterprise'
                ])
                ->withCount('teams');
            // ->paginate(request('limit') ?? 10);
            // if(request()->ajax()){}
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View contest
    public function index()
    {
        if (!($data = $this->getList()->paginate(request('limit') ?? 10))) return abort(404);

        return view('pages.contest.index', [
            'contests' => $data,
            'majors' => $this->major::all(),
        ]);
    }

    //  Response contest
    public function apiIndex()
    {

        if (!($data = $this->getList())) return $this->responseApi(
            [
                "status" => false,
                "payload" => "Not found",
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
     *  End contest
     */


    public function create()
    {
        $majors = Major::all();
        return view('pages.contest.form-add', compact('majors'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'img' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'date_start' => 'required|date',
                'register_deadline' => 'required|date|after:date_start',
                'description' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'img.mimes' => 'Sai định dạng !',
                'img.required' => 'Chưa nhập trường này !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'date_start.required' => 'Chưa nhập trường này !',
                'date_start.date' => 'Sai định dạng !',
                'register_deadline.required' => 'Chưa nhập trường này !',
                'register_deadline.date' => 'Sai định dạng !',
                'register_deadline.after' => 'Thời gian kết thúc không được bằng thời gian bắt đầu !',
                'description.required' => 'Chưa nhập trường này !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $contest = new Contest();
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                $filename = $this->uploadFile($fileImage);
                $contest->img = $filename;
            }
            $contest->name = $request->name;
            $contest->date_start = $request->date_start;
            $contest->register_deadline = $request->register_deadline;
            $contest->description = $request->description;
            $contest->major_id = $request->major_id;
            $contest->status = config('util.ACTIVE_STATUS');
            $contest->save();
            DB::commit();
            return Redirect::route('admin.contest.list')->with('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            DB::rollBack();
            return Redirect::back()->with('error', 'Thêm mới thất bại !');
        }
    }


    public function un_status($id)
    {
        try {
            $contest = $this->contest::find($id);
            $contest->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        try {
            $contest = $this->contest::find($id);
            $contest->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }



    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return abort(404);
            DB::transaction(function () use ($id) {
                $contest = $this->contest::find($id);
                if (Storage::disk('google')->has($contest->image)) Storage::disk('google')->delete($contest->image);
                $contest->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function edit($id)
    {
        $major = Major::orderBy('id', 'desc')->get();

        $Contest = $this->getContest($id)->first();
        // dd($Contest);
        if ($Contest) {
            return view('pages.contest.edit', compact('Contest', 'major'));
        } else {
            return view('error');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required",
                'date_start' => "required",
                'register_deadline' => "required|after:date_start",
                'description' => "required",
                'major_id' => "required",
                'status' => "required",

            ],
            [
                "name.required" => "Tường name không bỏ trống !",
                "date_start.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                "register_deadline.required" => "Tường thời gian kết thúc không bỏ trống !",
                "register_deadline.after" => "Tường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                "description.required" => "Tường mô tả không bỏ trống !",
                "major_id.required" => "Tường cuộc thi tồn tại !",
                "status.required" => "Tường trạng thái không bỏ trống",

            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();

        $contest = Contest::find($id);

        if (is_null($contest)) {
            return response()->json([
                "payload" => 'Không tồn tại trong cơ sở dữ liệu !'
            ], 500);
        } else {
            if ($request->has('img')) {
                $fileImage =  $request->file('img');
                $img = $this->uploadFile($fileImage, $contest->img);
                $contest->img = $img;
            }
            $contest->update($request->all());

            Db::commit();
            return Redirect::route('admin.contest.list');
        }
    }

    private function getContest($id)
    {
        try {
            $contest = $this->contest::where('id', $id);
            return $contest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function addCollectionApiContest($contest)
    {
        try {
            return $contest->with(['teams' => function ($q) {
                return $q->withCount('members');
            }, 'rounds'])->withCount('rounds');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function apiShow($id)
    {
        try {
            //
            if (!($contest = $this->getContest($id))) return $this->responseApi(
                [
                    'status' => false,
                    'payload' => 'Không tìm thấy cuộc thi !',
                ]
            );
            if (!($contest2 = $this->addCollectionApiContest($contest))) return $this->responseApi(
                [
                    'status' => false,
                    'payload' => 'Không thể lấy thông tin cuộc thi  !',
                ]
            );

            return $this->responseApi(
                [
                    "status" => true,
                    "payload" => $contest2->first(),
                ]
            );
        } catch (\Throwable $th) {

            return $this->responseApi(
                [
                    "status" => false,
                    "payload" => 'Not found ',
                ],
                404
            );
        }
    }

    private function getApiDetailContest($id)
    {

        $data = Contest::find($id);
        return $data;
    }
    public function show(Request $request, $id)
    {
        $datas = $this->getApiDetailContest($id);
        // if (request('page') == '' || request('page') == null) {
        // }
        // $contest->load(request('page') == 'rounds');


        if (request('page') == 'rounds') {
            $datas->load('rounds');
            return view('pages.contest.detail.contest-round', compact('datas'));
        } elseif (request('page') == 'teams') {
            $datas->load('teams');
            return view('pages.contest.detail.contest-team', compact('datas'));
        } else {
            return view('pages.contest.detail.detail', compact('datas'));
        }
    }
}

//