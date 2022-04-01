<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
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
    use TUploadImage;
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
                ])
                ->withCount('teams')
                ->paginate(request('limit') ?? 10);
            // if(request()->ajax()){}
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View contest
    public function index()
    {
        if (!($data = $this->getList())) return abort(404);

        return view('pages.contest.index', [
            'contests' => $data,
            'majors' => $this->major::all(),
        ]);
    }

    //  Response contest
    public function apiIndex()
    {

        if (!($data = $this->getList())) return response()->json([
            "status" => false,
            "payload" => "Server not found",
        ], 404);
        return response()->json([
            "status" => true,
            "payload" => $data,
        ], 200);
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
            if (!(auth()->user()->hasRole('super admin'))) return redirect()->back()->with('error', 'Không thể xóa ');
            $contest = $this->contest::find($id);
            if (Storage::disk('google')->has($contest->image)) Storage::disk('google')->delete($contest->image);
            $contest->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect('error');
            // return redirect()->back()->with('error', 'Xóa không thành công ');
        }
    }
}