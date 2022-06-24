<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use TUploadImage;
    use TCheckUserDrugTeam, TTeamContest;
    private $contest;
    private $team;
    private $user;

    public function __construct(Contest $contest, User $user, Team $team)
    {
        $this->contest = $contest;
        $this->team = $team;
        $this->user = $user;
    }
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $timeDay = $request->has('day') ? $request->day : Null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('team_soft_delete') ? $request->team_soft_delete : null;

        if ($softDelete != null) {
            $query = Team::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = Team::where('name', 'like', "%$keyword%");
        if ($timeDay != null) {
            $current = Carbon::now();
            $query->where('created_at', '>=', $current->subDays($timeDay));
        }
        if ($contest != null) {
            $query->where('contest_id', $contest);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        // dd($query->get());
        return $query;
    }
    // Danh sách teams phía view
    public function ListTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $Contest = Contest::orderBy('id', 'DESC')->get();
            $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

            DB::commit();
            return view('pages.team.listTeam', compact('dataTeam', 'Contest'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'lỗi'
            ]);
        };
    }

    //xóa Teams
    public function deleteTeam(Request $request, $id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = Team::find($id))) return false;
                if (Storage::disk('s3')->has($data->image)) Storage::disk('s3')->delete($data->image);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }



    public function create()
    {
        $contests = Contest::all();
        return view('pages.team.form-add', compact('contests'));
    }

    public function store(Request $request)
    {
        return $this->addTeamContest($request, null, Redirect::route('admin.teams'), Redirect::back());
    }

    public function edit($id)
    {
        $userArray = [];
        $users = User::all();
        $contests = Contest::all();
        $team = Team::find($id);
        foreach ($users as $user) {
            foreach ($team->members as $me) {
                if ($user->id == $me->id) {
                    array_push($userArray, [
                        'id_user' => $user->id,
                        'email_user' => $user->email,
                        'name_user' => $user->name
                    ]);
                }
            }
        }
        return view('pages.team.form-edit', compact('contests', 'team', 'userArray'));
    }
    public function update(Request $request, $id_team)
    {
        $team = Team::find($id_team);
        if (!is_null($team)) {
            return $this->editTeamContest($request, $id_team, null, Redirect::route('admin.teams'), Redirect::back());
        } else {
            return Redirect::back();
        }
    }



    public function softDelete(Request $request)
    {
        $listTeamSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

        return view('pages.team.team-soft-delete', compact('listTeamSofts'));
    }
    public function backUpTeam($id)
    {
        try {
            Team::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function destroy($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;

            Team::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    // chi tiết đội thi phía client
    public function apiShow($id)
    {
        try {
            $team = Team::find($id);
            $team->load('members');
            $team->load('contest');
            return response()->json([
                'status' => true,
                'payload' => $team,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function apiEditTeam(Request $request, $team_id)
    {
        DB::beginTransaction();
        try {
            $validate = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'image' =>  'mimes:jpeg,png,jpg|max:10000',
                ],
                [
                    'name.required' => 'Chưa nhập trường này !',
                    'image.mimes' => 'Sai định dạng !',
                    'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                ]
            );
            if ($validate->fails()) return response()->json([
                'status' => false,
                'payload' => $validate->errors()
            ]);
            $user_id = auth('sanctum')->user()->id;
            $user = User::find($user_id);
            $teamCheck = $this->team::find($team_id)->load('members');
            if (is_null($user) || is_null($teamCheck)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Không tồn tại trong cơ sở dữ liệu !'
                ]);
            } else {
                foreach ($teamCheck->members as $u) {
                    if ($u->pivot->bot === 1) if (!($u->pivot->user_id === $user_id)) return response()->json([
                        'status' => false,
                        'payload' => 'Bạn không có quyền để chỉnh sửa cuộc thi !'
                    ]);
                }
                if ($user->status != config('util.ACTIVE_STATUS')) return response()->json([
                    'status' => false,
                    'payload' => 'Tài khoản đã bị khóa !'
                ]);

                $teamChecks = Team::where(
                    'contest_id',
                    $request->contest_id
                )->where('name', trim($request->name))->get();
                foreach ($teamChecks as $teamCheck) {
                    if ($teamCheck->id != $team_id) return response()->json([
                        'status' => false,
                        'payload' => 'Tài khoản này đã tham gia đội thi khác !!'
                    ]);
                }
                $team =  $this->team::find($team_id);
                if ($request->has('image')) {
                    $fileImage = $request->file('image');
                    $filename = $this->uploadFile($fileImage, $team->image);
                    $team->image = $filename;
                }
                $team->name = $request->name;
                $team->save();
                DB::commit();
                return response()->json([
                    'status' => true,
                    'payload' => $team
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('s3')->has($fileImage)) Storage::disk('s3')->delete($filename);
            }
            return response()->json([
                'status' => false,
                'payload' =>  $th
            ]);
        }
    }

    public function apiAddTeam(Request $request)
    {

        $validate = validator::make(
            $request->all(),
            [
                'contest_id' => 'required',
                'name' => 'required',
                'image' =>  'required|mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'contest_id.required' => 'Chưa nhập trường này !',
                'name.required' => 'Chưa nhập trường này !',
                'image.required' => 'Chưa nhập trường này !',
                'image.mimes' => 'Sai định dạng !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);
        // dd($request->all());
        $teamCheck = Team::where(
            'contest_id',
            $request->contest_id
        )->where('name', trim($request->name))->get();
        if (count($teamCheck) > 0) return response()->json([
            'status' => false,
            'payload' => 'Tên đã tồn tại trong cuộc thi !!'
        ]);
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $result = $this->checkUserDrugTeam($request->contest_id, [$user_id]);
            if (count($result['user-not-pass']) > 0) return response()->json([
                'status' => false,
                'payload' => 'Tài khoản này đã tham gia đội thi khác !!'
            ]);
            $today = Carbon::now()->toDateTimeString();
            $user = User::find($user_id);
            $contest = Contest::find($request->contest_id);
            if (is_null($user) || is_null($contest)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Không tồn tại trong cơ sở dữ liệu !'
                ]);
            } else {
                if ($user->status != config('util.ACTIVE_STATUS')) return response()->json([
                    'status' => false,
                    'payload' => 'Tài khoản đã bị khóa !'
                ]);
                if (strtotime($contest->register_deadline) > strtotime($today)) {
                    $teamModel = new Team();
                    if ($request->hasFile('image')) {
                        $fileImage = $request->file('image');
                        $filename = $this->uploadFile($fileImage);
                        $teamModel->image = $filename;
                    }
                    $teamModel->name = $request->name;
                    $teamModel->contest_id = $request->contest_id;
                    $teamModel->save();
                    $teamModel->members()->attach($result['user-pass'], ['bot' => config('util.ACTIVE_STATUS')]);
                    DB::commit();
                    $modelTeamId =  $teamModel->id;
                    return response()->json([
                        'status' => true,
                        'payload' => 'Tạo đội thành công !',
                        'id_team' => $modelTeamId,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'payload' => 'Đã quá thời hạn đăng kí cuộc thi !'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($fileImage)) Storage::disk('google')->delete($filename);
            }
            return response()->json([
                'status' => false,
                'payload' =>  $th
            ]);
        }
    }


    public function checkUserTeamContest($id_contest)
    {
        $user_id = auth('sanctum')->user()->id;
        $result = $this->checkUserDrugTeam($id_contest, [$user_id]);
        if (count($result['user-not-pass']) > 0) return response()->json([
            'status' => false,
            'payload' => 'Tài khoản này đã tham gia cuộc thi khác !'
        ]);
    }


    public function addUserTeamContest(Request $request, $id_contest, $id_team)
    {

        $validate = Validator::make(

            $request->all(),
            [
                "user_id"    => "required",
                "user_id.*"  => "required",
            ],
            [
                'user_id.required' => 'Chưa nhập trường này !',
            ]
        );

        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $team = Team::where('id', $id_team)->where('contest_id', $id_contest)->first();
            if (is_null($team)) return response()->json([
                'status' => false,
                'payload' => 'Đội không tồn tại trong cuộc thi !'
            ]);
            $team->load('members');
            $result = $this->checkUserDrugTeam($id_contest, $request->user_id);
            foreach ($team->members as $userTeam) {
                if ($userTeam->id === $user_id && $userTeam->pivot->bot == 1) {
                    $team->members()->attach($result['user-pass']);
                    DB::commit();

                    $user_pass = User::whereIn('id', $result['user-pass'])->get();
                    $use_not_pass = User::whereIn('id', $result['user-not-pass'])->get();
                    return response()->json([
                        'status' => true,
                        'payload' => 'Thêm thành viên thành công !',
                        'user_pass' => $user_pass ?? null,
                        'user_not_pass' => $use_not_pass ?? null
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'payload' => 'Không đủ quyền để thêm thành viên !'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function userTeamSearch($id_contest, Request $request)
    {
        try {
            $usersNotTeam = User::where('status', config('util.ACTIVE_STATUS'))->pluck('id');
            $usersNotTeam = $this->checkUserDrugTeam($id_contest, $usersNotTeam);
            $users = User::select('id', 'name', 'email', 'avatar')
                ->search(request('key') ?? null, ['name', 'email'])
                ->whereIn('id', $usersNotTeam['user-pass'])
                ->limit(5)->get();
            return response()->json([
                'status' => true,
                'payload' => $users,
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function getContest(Request $request)
    {
        $max_user = Contest::find($request->id)->max_user;
        return response()->json([
            'status' => true,
            'payload' =>  $max_user,
        ]);
    }

    public function deleteUserTeamContest(Request $request)
    {
        $team = Team::find($request->team_id);
        if (is_null($team))  return response()->json([
            'status' => false,
            'payload' => "Thông tin đội bị lỗi !!",
        ]);
        $userID = User::whereIn('id', $request->user_id)->get()->pluck('id');
        $team->members()->detach($userID);
        return response()->json([
            'status' => true,
            'payload' => "Xóa thành viên thành công !!",
        ]);
    }
}