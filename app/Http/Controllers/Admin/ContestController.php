<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Major;
use App\Models\Team;
use App\Models\User;
use App\Services\Traits\TTeamContest;
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
    use TUploadImage, TResponse, TTeamContest;
    private $contest;
    private $major;
    private $team;

    public function __construct(Contest $contest, Major $major, Team $team)
    {
        $this->contest = $contest;
        $this->major = $major;
        $this->team = $team;
    }

    /**
     *  Get list contest
     */
    private function getList()
    {
        try {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $data = $this->contest::when(request()->has('contest_soft_delete'), function ($q) {
                return $q->onlyTrashed();
            })->search(request('q') ?? null, ['name', 'description'])
                ->missingDate('register_deadline', request('miss_date') ?? null, $now->toDateTimeString())
                ->passDate('register_deadline', request('pass_date') ?? null, $now->toDateTimeString())
                ->registration_date('end_register_time', request('registration_date') ?? null, $now->toDateTimeString())
                ->status(request('status'))
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
                ->hasDateTimeBetween('date_start', request('start_time') ?? null, request('end_time') ?? null)
                // ->hasDateTimeBetween('end_register_time',request('registration_date'))
                ->hasRequest(['major_id' => request('major_id') ?? null])
                ->with([
                    'major',
                    'teams',
                    'rounds' => function ($q) {
                        return $q->with([
                            'teams' => function ($q) {
                                return $q->with('members');
                            }
                        ]);
                    },
                    'enterprise',
                    'judges'
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
            'majors' => Major::where('parent_id', 0)->get(),
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
                "payload" => $data->paginate(request('limit') ?? 9),
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
                'name' => 'required|max:255|unique:contests,name',
                'img' => 'required|mimes:jpeg,png,jpg|max:10000',
                'date_start' => 'required|date',
                'register_deadline' => 'required|date|after:date_start',
                'description' => 'required',
                'start_register_time' => 'required|date|before:end_register_time',
                'end_register_time' => 'required|date|after:start_register_time|before:date_start',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.unique' => 'Tên cuộc thi đã tồn tại !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'img.mimes' => 'Sai định dạng !',
                'img.required' => 'Chưa nhập trường này !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'date_start.required' => 'Chưa nhập trường này !',
                'date_start.date' => 'Sai định dạng !',
                'start_register_time.required' => 'Chưa nhập trường này !',
                'start_register_time.date' => 'Sai định dạng !',
                'start_register_time.before' => 'Thời gian bắt đầu đăng kí không được bằng hoặc lớn hơn thời gian kết thúc đăng kí!',

                'end_register_time.required' => 'Chưa nhập trường này !',
                'end_register_time.date' => 'Sai định dạng !',
                'end_register_time.after' => 'Thời gian kết thúc đăng kí không được bằng hoặc nhỏ hơn thời gian bắt đầu đăng kí!',
                'end_register_time.before' => 'Thời gian kết thúc đăng kí không được bằng hoặc lớn hơn thời gian bắt đầu cuộc thi!',
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
            $contest->start_register_time = $request->start_register_time;
            $contest->end_register_time = $request->end_register_time;
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
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return abort(404);
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
                'name' => 'required|unique:contests,name,' . $id . '',
                'img' => 'required|mimes:jpeg,png,jpg|max:10000',
                'date_start' => "required",
                'register_deadline' => "required|after:date_start",
                'description' => "required",
                'major_id' => "required",
                'status' => "required",
                'start_register_time' => 'required|date|before:end_register_time',
                'end_register_time' => 'required|date|after:start_register_time|before:date_start',
            ],
            [
                'img.mimes' => 'Sai định dạng !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                "name.required" => "Tường name không bỏ trống !",
                "name.unique" => "Tên cuộc thi đã tồn tại !",
                "date_start.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                "register_deadline.required" => "Tường thời gian kết thúc không bỏ trống !",
                "register_deadline.after" => "Tường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                "description.required" => "Tường mô tả không bỏ trống !",
                "major_id.required" => "Tường cuộc thi tồn tại !",
                "status.required" => "Tường trạng thái không bỏ trống",

                'end_register_time.required' => 'Chưa nhập trường này !',
                'end_register_time.date' => 'Sai định dạng !',
                'end_register_time.after' => 'Thời gian kết thúc đăng kí không được bằng hoặc nhỏ hơn thời gian bắt đầu đăng kí!',
                'end_register_time.before' => 'Thời gian kết thúc đăng kí không được bằng hoặc lớn hơn thời gian bắt đầu cuộc thi!',
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

            return $contest->with(['enterprise', 'teams' => function ($q) {
                return $q->withCount('members');
            }, 'rounds' => function ($q) {
                return $q->with([
                    'teams' => function ($q) {
                        return $q->with('members');
                    },
                    'judges' => function ($q) {
                        return $q->with('user');
                    }
                ]);
            }, 'judges'])->withCount('rounds');
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


    public function show(Request $request, $id)
    {
        $contest =  Contest::find($id);
        return view('pages.contest.detail.detail', compact('contest'));
    }


    public function contestDetailTeam($id)
    {
        $contest =  Contest::find($id);
        $teams = Team::get()->load('contest');
        return view('pages.contest.detail.team.contest-team', compact('contest', 'teams'));
    }

    public function contestDetailTeamAddSelect(Request  $request, $id)
    {
        // dd($request->all());
        $contest = Contest::find($id);
        $team = Team::find($request->team_id);
        if (is_null($contest) && is_null($team)) {
            return Redirect::back();
        } else {
            $team->contest_id = $id;
            $team->save();
            return Redirect::back();
        }
    }

    public function softDelete()
    {
        $listContestSofts = $this->getList()->paginate(request('limit') ?? 5);
        return view('pages.contest.contest-soft-delete', [
            'listContestSofts' => $listContestSofts
        ]);
    }

    public function backUpContest($id)
    {
        try {
            $this->contest::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function deleteContest($id)
    {
        try {
            $this->contest::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function contestDetailEnterprise($id)
    {
        if (!($contestEnterprise = Contest::find($id)->load('enterprise')->enterprise()->paginate(5))) return abort(404);
        $contest =  Contest::find($id);
        $enterprise = Enterprise::all();
        return view('pages.contest.detail.enterprise', ['contest' => $contest, 'contestEnterprise' => $contestEnterprise, 'enterprise' => $enterprise]);
    }
    public function attachEnterprise(Request $request, $id)
    {
        try {

            Contest::find($id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function detachEnterprise($id, $enterprise_id)
    {
        try {
            Contest::find($id)->enterprise()->detach([$enterprise_id]);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }


    public function addFormTeamContest($id)
    {
        $contest =  Contest::find($id);
        return view('pages.contest.detail.team.form-add-team-contest', compact('contest'));
    }

    public function addFormTeamContestSave(Request $request, $id)
    {
        $contest = Contest::find($id);
        if (!is_null($contest)) {
            return $this->addTeamContest($request, $id, Redirect::route('admin.contest.detail.team', ['id' => $id]), Redirect::back());
        } else {
            return Redirect::back();
        }
    }

    public function editFormTeamContest($id, $id_team)
    {
        $contest = Contest::find($id);
        if (!is_null($contest)) {
            $userArray = [];
            $users = User::get();

            $team = Team::find($id_team)->load('users');
            foreach ($users as $user) {
                foreach ($team->users as $me) {
                    if ($user->id == $me->id) {
                        array_push($userArray, [
                            'id_user' => $user->id,
                            'email_user' => $user->email
                        ]);
                    }
                }
            }
            // dd($userArray);
            return view(
                'pages.contest.detail.team.form-edit-team-contest',
                [
                    'contest' => $contest,
                    'team' => $team,
                    'userArray' => $userArray
                ]
            );
        } else {
            return Redirect::back();
        }
    }

    public function editFormTeamContestSave(Request $request, $id_contest, $id_team)
    {
        $contest = Contest::find($id_contest);
        if (!is_null($contest)) {
            return $this->editTeamContest($request, $id_team, $id_contest, Redirect::route('admin.contest.detail.team', ['id' => $id_contest]), Redirect::back());
        } else {
            return Redirect::back();
        }
    }
}



//