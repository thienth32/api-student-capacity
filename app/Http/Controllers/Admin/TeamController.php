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
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use TUploadImage, TCheckUserDrugTeam, TTeamContest, TResponse;
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
            $query = $this->team::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->team::where('name', 'like', "%$keyword%");
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
    // Danh s??ch teams ph??a view
    public function ListTeam(Request $request)
    {
        try {
            $Contest = $this->contest::orderBy('id', 'DESC')->get();
            $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

            return view('pages.team.listTeam', compact('dataTeam', 'Contest'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'l???i'
            ]);
        };
    }

    //x??a Teams
    public function deleteTeam(Request $request, $id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data =  $this->team::find($id))) return false;
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
        $contests = $this->contest::where('type', 0)->get();
        return view('pages.team.form-add', compact('contests'));
    }

    public function store(Request $request)
    {

        return $this->addTeamContest($request, null, Redirect::route('admin.teams'), Redirect::back());
    }

    public function edit($id)
    {
        $userArray = [];
        $contests = $this->contest::where('type', 0)->get();
        $team = $this->team::find($id);
        foreach ($team->members as $me) {
            array_push($userArray, [
                'id_user' => $me->id,
                'email_user' => $me->email,
                'name_user' => $me->name,
                'bot' => $me->pivot->bot,
            ]);
        }
        return view('pages.team.form-edit', compact('contests', 'team', 'userArray'));
    }
    public function update(Request $request, $id_team)
    {
        $team =  $this->team::find($id_team);
        if (!is_null($team)) {
            return $this->editTeamContest($request, $id_team, null, Redirect::route('admin.teams'), Redirect::back());
        } else {
            return redirect()->back();
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
            $this->team::withTrashed()->where('id', $id)->restore();
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

            $this->team::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    // chi ti???t ?????i thi ph??a client
    public function apiShow($id)
    {
        try {
            $team = $this->team::find($id);
            $team->load('members');
            $team->load('contest');
            return $this->responseApi(true, $team);
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
                    'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                    'image.mimes' => 'Sai ?????nh d???ng !',
                    'image.max' => 'Dung l?????ng ???nh kh??ng ???????c v?????t qu?? 10MB !',
                ]
            );
            if ($validate->fails()) return $this->responseApi(true, $validate->errors());
            $user_id = auth('sanctum')->user()->id;
            $user = $this->user::find($user_id);
            $teamCheck = $this->team::find($team_id)->load('members');
            if (is_null($user) || is_null($teamCheck)) {
                return  $this->responseApi(false, 'Kh??ng t???n t???i trong c?? s??? d??? li???u !');
            } else {
                foreach ($teamCheck->members as $u) {
                    if ($u->pivot->bot === 1) if (!($u->pivot->user_id === $user_id))
                        return  $this->responseApi(false, 'B???n kh??ng c?? quy???n ????? ch???nh s???a cu???c thi !');
                }
                if ($user->status != config('util.ACTIVE_STATUS'))
                    return  $this->responseApi(false, 'T??i kho???n ???? b??? kh??a !');
                $teamChecks = $this->team::where(
                    'contest_id',
                    $request->contest_id
                )->where('name', trim($request->name))->get();
                foreach ($teamChecks as $teamCheck) {
                    if ($teamCheck->id != $team_id)
                        return $this->responseApi(false, 'T??i kho???n n??y ???? tham gia ?????i thi kh??c !!');
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
                return $this->responseApi(true, $team);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('s3')->has($fileImage)) Storage::disk('s3')->delete($fileImage);
            }
            return $this->responseApi(true, $th);
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
                'contest_id.required' => 'Ch??a nh???p tr?????ng n??y !',
                'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                'image.required' => 'Ch??a nh???p tr?????ng n??y !',
                'image.mimes' => 'Sai ?????nh d???ng !',
                'image.max' => 'Dung l?????ng ???nh kh??ng ???????c v?????t qu?? 10MB !',
            ]
        );
        if ($validate->fails()) return  $this->responseApi(true, $validate->errors());
        $teamCheck = $this->team::where(
            'contest_id',
            $request->contest_id
        )->where('name', trim($request->name))->get();
        if (count($teamCheck) > 0) return $this->responseApi(false, 'T??n ???? t???n t???i trong cu???c thi !!');
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $result = $this->checkUserDrugTeam($request->contest_id, [$user_id]);
            if (count($result['user-not-pass']) > 0) return $this->responseApi(false, 'T??i kho???n n??y ???? tham gia ?????i thi kh??c !!');
            $today = Carbon::now()->toDateTimeString();
            $user = $this->user::find($user_id);
            $contest = $this->contest::find($request->contest_id);
            if (is_null($user) || is_null($contest)) {
                return $this->responseApi(false, 'Kh??ng t???n t???i trong c?? s??? d??? li???u !');
            } else {
                if ($user->status != config('util.ACTIVE_STATUS')) return $this->responseApi(false, 'T??i kho???n ???? b??? kh??a !');
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
                    return $this->responseApi(true, 'T???o ?????i th??nh c??ng !', ['id_team' => $modelTeamId]);
                } else {
                    return $this->responseApi(false, '???? qu?? th???i h???n ????ng k?? cu???c thi !');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($fileImage)) Storage::disk('google')->delete($fileImage);
            }

            return $this->responseApi(true, $th);
        }
    }


    public function checkUserTeamContest($id_contest)
    {
        $user_id = auth('sanctum')->user()->id;
        $result = $this->checkUserDrugTeam($id_contest, [$user_id]);
        if (count($result['user-not-pass']) > 0) return $this->responseApi(false, 'T??i kho???n n??y ???? tham gia cu???c thi kh??c !');
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
                'user_id.required' => 'Ch??a nh???p tr?????ng n??y !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(false, $validate->errors());
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $team = $this->team::where('id', $id_team)->where('contest_id', $id_contest)->first();
            if (is_null($team)) return $this->responseApi(false, '?????i kh??ng t???n t???i trong cu???c thi !');


            $team->load('members');
            $result = $this->checkUserDrugTeam($id_contest, $request->user_id);
            foreach ($team->members as $userTeam) {
                if ($userTeam->id === $user_id && $userTeam->pivot->bot == 1) {
                    $team->members()->attach($result['user-pass']);
                    DB::commit();

                    $user_pass = $this->user::whereIn('id', $result['user-pass'])->get();
                    $use_not_pass = $this->user::whereIn('id', $result['user-not-pass'])->get();
                    // return response()->json([
                    //     'status' => true,
                    //     'payload' => 'Th??m th??nh vi??n th??nh c??ng !',
                    // 'user_pass' => $user_pass ?? null,
                    // 'user_not_pass' => $use_not_pass ?? null
                    // ]);
                    return $this->responseApi(true, 'Th??m th??nh vi??n th??nh c??ng !', [
                        'user_pass' => $user_pass ?? null,
                        'user_not_pass' => $use_not_pass ?? null
                    ]);
                } else {
                    return $this->responseApi(false, 'Kh??ng ????? quy???n ????? th??m th??nh vi??n !');
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
            $usersNotTeam = $this->user::where('status', config('util.ACTIVE_STATUS'))->pluck('id');
            $usersNotTeam = $this->checkUserDrugTeam($id_contest, $usersNotTeam);
            $users = $this->user::select('id', 'name', 'email', 'avatar')
                ->search(request('key') ?? null, ['name', 'email'])
                ->whereIn('id', $usersNotTeam['user-pass'])
                ->limit(5)->get();
            return $this->responseApi(true, $users);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function getContest(Request $request)
    {
        $max_user = $this->contest::find($request->id)->max_user;
        return $this->responseApi(true, $max_user);
    }

    public function deleteUserTeamContest(Request $request)
    {
        $team = $this->team::find($request->team_id);
        if (is_null($team))  return $this->responseApi(false, "Th??ng tin ?????i b??? l???i !!");


        $userID = $this->user::whereIn('id', $request->user_id)->get()->pluck('id');
        $team->members()->detach($userID);
        return $this->responseApi(false, "X??a th??nh vi??n th??nh c??ng !!");
    }
}