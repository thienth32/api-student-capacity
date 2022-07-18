<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Contest\RequestContest;
use App\Services\Traits\TStatus;
use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Judge;
use App\Models\Major;
use App\Services\Modules\MContest\Contest;
use App\Models\Skill;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ContestUser;
use App\Models\Round;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ContestController extends Controller
{
    use TUploadImage, TResponse, TTeamContest , TStatus;

     public function __construct(
        private Contest $contest,
        private Major $major,
        private Team $team ,
        private DB $db,
        private Storage $storage
    )
    { }

    /**
     *  Get list contest
     */
    private function getList($flagCapacity = false)
    {
        try {
            $with = [];

            if (!$flagCapacity) $with = [
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
            ];
            if ($flagCapacity) $with = [
                'rounds' => function ($q) {
                    return $q->with([
                        'exams' => function ($q) {
                            return $q->with([
                                'questions' => function ($q) {
                                    return $q->with('answers');
                                }
                            ]);
                        }
                    ]);
                }
            ];

            $data =  $this->contest->getList($with, request());

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function checkTypeContest()
    {
        if (request('type') != config('util.TYPE_CONTEST') && request('type') != config('util.TYPE_TEST')) abort(404);
    }

    public function getModelDataStatus($id)
    {
        return $this->contest->find($id);
    }

    public function index()
    {
        $this->checkTypeContest();
        if (!($data = $this->contest->index())) return abort(404);

        return view('pages.contest.index', [
            'contests' => $data ,
            'majors' => Major::where('parent_id', 0)->get(),
            'contest_type_text' =>  request('type') == 1 ? 'test năng lực' : 'cuộc thi'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/contests",
     *     description="Description api contests",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Lọc theo trạng thái ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="major_id",
     *         in="query",
     *         description="Lọc theo chuyên ngành   ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiIndex()
    {
        if (!($data = $this->contest->apiIndex())) return $this->responseApi(false);
        return $this->responseApi(true , $data);
    }

    /**
     * @OA\Get(
     *     path="/api/public/capacity",
     *     description="Description api capacity",
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Lọc theo trạng thái ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="major_id",
     *         in="query",
     *         description="Lọc theo chuyên ngành   ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiIndexCapacity()
    {
        if (!($data = $this->contest->apiIndex(true))) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }


    public function create()
    {
        $this->checkTypeContest();
        $majors = $this->major::all();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        return view('pages.contest.form-add', compact('majors', 'contest_type_text'));
    }

    public function store(RequestContest $request, Redirect $redirect)
    {

        $this->checkTypeContest();
        $this->db::beginTransaction();
        try {
            $filename = $this->uploadFile($request->img);
            $contest = $this->contest->store($filename,$request);
            $this->db::commit();
            return $redirect::route('admin.contest.show', ['id' => $contest->id])->with('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                if ($this->storage::disk('s3')->has($filename)) $this->storage::disk('s3')->delete($filename);
            }
            $this->db::rollBack();
            return $redirect::back()->with('error', 'Thêm mới thất bại !');
        }
    }

    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return abort(404);
            $this->db::transaction(function () use ($id) {
                $contest = $this->contest->find($id);
                if ($this->storage::disk('s3')->has($contest->image)) $this->storage::disk('s3')->delete($contest->image);
                $contest->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit($id)
    {

        $this->checkTypeContest();
        $major = $this->major::orderBy('id', 'desc')->get();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        $contest = $this->getContest($id, request('type') ?? 0)->first();
        if (!$contest) abort(404);
        if ($contest->type != request('type')) abort(404);
        $rewardRankPoint = json_decode($contest->reward_rank_point);
        if ($contest) {
            return view('pages.contest.edit', compact('contest', 'major', 'rewardRankPoint', 'contest_type_text'));
        } else {
            return view('error');
        }
    }

    public function update(RequestContest $request, $id, Validator $validatorFacades)
    {
        $this->checkTypeContest();
        $this->db::beginTransaction();
        $contest = $this->contest->find($id);
        try {
            if (is_null($contest)) {
                return redirect(route('admin.contest.list') . '?type=' . request('type') ?? 0);
            } else {
                $rewardRankPoint = json_encode(array(
                    'top1' => $request->top1,
                    'top2' => $request->top2,
                    'top3' => $request->top3,
                    'leave' => $request->leave,
                ));

                if ($request->has('img')) {
                    $img = $this->uploadFile($request->file('img'), $contest->img);
                    if(!$img)  return redirect()->back()->with('error', 'Cập nhật thất bại !');
                    $dataSave = array_merge($request->except(['_method','_token','img']) , [
                        'reward_rank_point' => $rewardRankPoint,
                        'img' => $img
                    ]);
                }else{
                    $dataSave = array_merge($request->except(['_method','_token']) , [
                        'reward_rank_point' => $rewardRankPoint,
                    ]);
                }
                $this->contest->update($contest , $dataSave);
                $this->db::commit();
                // return Redirect::route('admin.contest.list');
                return redirect(route('admin.contest.list') . '?type=' . request('type') ?? 0);
            }
        }catch (\Exception $e) {
            $this->db::rollBack();
            return redirect()->back()->with('error', 'Cập nhật thất bại !');
        }

    }

    private function getContest($id, $type = 0)
    {
        try {
            $contest = $this->contest->getContest()::where('id', $id)->where('type', $type);
            return $contest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function apiShow($id)
    {
        try {
            if (!($contest = $this->contest->apiShow($id,config('util.TYPE_CONTEST')) ))
                return $this->responseApi(false,'Không thể lấy thông tin cuộc thi  !');
            return $this->responseApi(true,$contest);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    public function apiShowCapacity($id)
    {

        try {
            $capacity = $this->contest->apiShow($id,config('util.TYPE_TEST'));
            if (is_null($capacity))
                return $this->responseApi(false,'Không tìm thấy bài test năng lực !');
            return $this->responseApi(true,$capacity);
        } catch (\Throwable $th) {
            return $this->responseApi(false );
        }
    }

    public function show(Request $request, $id)
    {
        $contest = $this->contest->show($id,config('util.TYPE_CONTEST'));
        if(!$contest) abort(404);
        return view('pages.contest.detail.detail', compact('contest'));
    }

    public function show_test_capacity(Request $request,Skill $skillModel, $id )
    {
        $capacity = $this->contest->show($id,config('util.TYPE_TEST'));
        if (!$capacity) abort(404);
        $skills = $skillModel::all();
        return view('pages.contest.detail-capacity.detail', [
            'test_capacity' => $capacity,
            'skills' => $skills
        ]);
    }

    public function contestDetailTeam($id)
    {
        $contest = $this->contest->find($id);
        $teams = $this->team::get()->load('contest');
        return view('pages.contest.detail.team.contest-team', compact('contest', 'teams'));
    }

    public function contestDetailTeamAddSelect(Request  $request,Redirect $redirect, $id)
    {
        $contest = $this->contest->find($id);
        $team = $this->team::find($request->team_id);
        if (is_null($contest) && is_null($team)) {
            return $redirect::back();
        } else {
            $team->contest_id = $id;
            $team->save();
            return $redirect::back();
        }
    }

    public function softDelete()
    {
        $listContestSofts = $this->contest->index();
        return view('pages.contest.contest-soft-delete', [
            'listContestSofts' => $listContestSofts
        ]);
    }

    public function backUpContest($id)
    {
        try {
            $this->contest->backUpContest($id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function deleteContest($id)
    {
        try {
            $this->contest->deleteContest($id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function contestDetailEnterprise($id , Enterprise $enterpriseModel)
    {
        $contest =  $this->contest->find($id);
        if (!($contestEnterprise = $contest->load('enterprise')->enterprise()->paginate(5))) return abort(404);
        $enterprise = $enterpriseModel::all();
        return view('pages.contest.detail.enterprise', ['contest' => $contest, 'contestEnterprise' => $contestEnterprise, 'enterprise' => $enterprise]);
    }
    public function attachEnterprise(Request $request, $id)
    {
        try {
            $this->contest->find($id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    public function detachEnterprise($id, $enterprise_id)
    {
        try {
            $this->contest->find($id)->enterprise()->detach([$enterprise_id]);
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }


    public function addFormTeamContest($id)
    {
        $contest =  $this->contest->find($id);
        return view('pages.contest.detail.team.form-add-team-contest', compact('contest'));
    }

    public function addFormTeamContestSave(Request $request, $id)
    {
        $contest = $this->contest->find($id);
        if (!is_null($contest)) {
            return $this->addTeamContest($request, $id, Redirect::route('admin.contest.detail.team', ['id' => $id]), Redirect::back());
        } else {
            return Redirect::back();
        }
    }

    public function editFormTeamContest($id, $id_team, User $user)
    {

        $contest = $this->contest->find($id);
        if (!is_null($contest)) {
            $userArray = [];
            $users = $user::get();

            $team = $this->team::find($id_team)->load('users');
            foreach ($users as $user) {
                foreach ($team->users as $me) {
                    if ($user->id == $me->id) {
                        array_push($userArray, [
                            'id_user' => $user->id,
                            'email_user' => $user->email,
                            'name_user' => $user->name
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
            return redirect()->back();
        }
    }

    public function editFormTeamContestSave(Request $request, $id_contest, $id_team)
    {
        $contest = $this->contest->find($id_contest);
        if (!is_null($contest)) {
            return $this->editTeamContest($request, $id_team, $id_contest, Redirect::route('admin.contest.detail.team', ['id' => $id_contest]), Redirect::back());
        } else {
            return redirect()->back();
        }
    }

    public function userTeamRound($roundId, Round $round)
    {
        $team_id = 0;
        $user_id = auth('sanctum')->user()->id;
        $round = $round::find($roundId)->load('teams');
        try {
            if ($round->teams) {
                foreach ($round->teams as $team) {
                    foreach ($team->users as $user) {
                        if ($user->id == $user_id) {
                            $team_id = $team->id;
                        }
                    }
                }
            }
            if ($team_id == 0)  return $this->responseApi(true,[]);
            $team = $this->team::find($team_id)->load('members');
            return $this->responseApi(true,$team);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    public function sendMail($id)
    {
        $contest = $this->contest->sendMail($id);
        $judges = $contest->judges;
        $users = [];
        if (count($contest->teams) > 0) {
            foreach ($contest->teams as $team) {
                foreach ($team->members as $user) {
                    array_push($users, $user);
                }
            }
        }
        return view('pages.contest.add-mail', ['contest' => $contest, 'judges' => $judges, 'users' => array_unique($users)]);
    }

    public function register_deadline($id)
    {
        if (!$contest = $this->contest->find($id)) abort(404);
        $take_exams = $contest->take_exams()
            ->with([
                'teams' => function ($q) use ($contest) {
                    return $q->where('contest_id', $contest->id)->with('users');
                }
            ])
            ->orderByDesc('final_point')
            ->orderByDesc('updated_at')->get();
        $pointAdd = json_decode($contest->reward_rank_point);
        try {
            $this->db::transaction(function () use ($contest, $pointAdd, $take_exams) {
                foreach ($take_exams as $key => $take_exam) {
                    if ($key == 0) {
                        if ($take_exam->teams) $this->updateUserAddPoint($take_exam->teams->users, $contest->id, $pointAdd->top1 ?? 0);
                    } elseif ($key == 1) {
                        if ($take_exam->teams) $this->updateUserAddPoint($take_exam->teams->users, $contest->id, $pointAdd->top2 ?? 0);
                    } elseif ($key == 2) {
                        if ($take_exam->teams) $this->updateUserAddPoint($take_exam->teams->users, $contest->id, $pointAdd->top3 ?? 0);
                    } else {
                        if ($take_exam->teams) $this->updateUserAddPoint($take_exam->teams->users, $contest->id, $pointAdd->leave ?? 0);
                    }
                }
                $contest->update([
                    'status' => 2,
                ]);
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    private function updateUserAddPoint($users, $id, $point, ContestUser $contestUser)
    {
        foreach ($users as $user) {
            if (!$contestUser = $contestUser::where('contest_id', $id)
                ->where('user_id', $user->id)
                ->first()) $contestUser = $contestUser::create([
                'contest_id' => $id,
                'user_id' => $user->id,
                'reward_point' => 0
            ]);
            $contestUser->reward_point = $contestUser->reward_point + $point;
            $contestUser->save();
        };
    }

    public function apiCapacityRelated($id_capacity)
    {
        $capacityArrId = [];
        $capacity = $this->contest->find($id_capacity);
        if(is_null($capacity)) return $this->responseApi(false, 'Không tìm thấy bài test năng lực !');
        $capacity->load(['recruitment'=>function($q){
            return $q->with(['contest']);
        }]);
        foreach ($capacity->recruitment as  $recruitment) {
            if ($recruitment->contest) foreach ($recruitment->contest as $contest) {
                array_push($capacityArrId, $contest->id);
            }
        }
        $capacityArrId= array_unique($capacityArrId);
        unset($capacityArrId[array_search($id_capacity,$capacityArrId)]);
        $capacitys= $this->contest->getContest()::whereIn('id', $capacityArrId)->limit(request('limit') ?? 4)->get();
        $capacitys->load(['rounds']);
        return $this->responseApi(true,$capacitys);
    }
}



//
