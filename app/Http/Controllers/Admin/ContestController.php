<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Contest\RequestContest;
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
use Illuminate\Support\Facades\Log;
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
    use TUploadImage, TResponse, TTeamContest;

    private $contest;
    private $major;
    private $team;
    private $db;
    public function __construct(Contest $contest, Major $major, Team $team , DB $db)
    {
        $this->contest = $contest;
        $this->major = $major;
        $this->team = $team;
        $this->db = $db;
    }

    /**
     *  Get list contest
     */
    private function getList($flagCapacity = false)
    {
        try {
            return $this->contest->getList($flagCapacity,request());
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function checkTypeContest()
    {
        if (request('type') != config('util.TYPE_CONTEST') && request('type') != config('util.TYPE_TEST')) abort(404);
    }

    //  View contest
    public function index()
    {
        $this->checkTypeContest();
        if (!($data = $this->getList())) return abort(404);

        return view('pages.contest.index', [
            'contests' => $data ->where('type', request('type') ?? 0)
                                ->paginate(request('limit') ?? 10),
            'majors' => Major::where('parent_id', 0)->get(),
            'contest_type_text' =>  request('type') == 1 ? 'test năng lực' : 'cuộc thi'
        ]);
    }

    //  Response contest
    public function apiIndex()
    {
//        $data = $this->getList();
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
                "payload" => $data->where('type', config('util.TYPE_CONTEST'))->paginate(request('limit') ?? 9),
            ]
        );
    }
    /**
     *  End contest
     */

    public function apiIndexCapacity()
    {

        if (!($data = $this->getList(true))) return $this->responseApi(
            [
                "status" => false,
                "payload" => "Not found",
            ],
            404
        );
        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data->where('type', config('util.TYPE_TEST'))->paginate(request('limit') ?? 9),
            ]
        );
    }


    public function create()
    {
        $this->checkTypeContest();
        $majors = $this->major::all();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        return view('pages.contest.form-add', compact('majors', 'contest_type_text'));
    }

    public function store(RequestContest $request, Redirect $redirect, Storage $storage)
    {

        $this->checkTypeContest();
        if ($request->hasFile('img')) {
            $fileImage = $request->file('img');
            $filename = $this->uploadFile($fileImage);
        }
        $this->db::beginTransaction();
        try {
            $contest = $this->contest->store($filename,$request);
            $this->db::commit();
            return $redirect::route('admin.contest.show', ['id' => $contest->id])->with('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                if ($storage::disk('s3')->has($filename)) $storage::disk('s3')->delete($filename);
            }
            $this->db::rollBack();
            return $redirect::back()->with('error', 'Thêm mới thất bại !');
        }
    }
    public function un_status($id)
    {
        try {
            $contest = $this->contest->find($id);
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
            $contest = $this->contest->find($id);
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
                $contest = $this->contest->find($id);
                if (Storage::disk('s3')->has($contest->image)) Storage::disk('s3')->delete($contest->image);
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
                    $fileImage =  $request->file('img');
                    $img = $this->uploadFile($fileImage, $contest->img);
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
            return redirect()->back()->with('error', 'Cập nhật thất bại !');;
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
            if (!($contest = $this->getContest($id, config('util.TYPE_CONTEST')))) return $this->responseApi(
                [
                    'status' => false,
                    'payload' => 'Không tìm thấy cuộc thi !',
                ]
            );
            if (!($contest2 = $this->addCollectionApiContest($contest)->first())) return $this->responseApi(
                [
                    'status' => false,
                    'payload' => 'Không thể lấy thông tin cuộc thi  !',
                ]
            );

            return $this->responseApi(
                [
                    "status" => true,
                    "payload" => $contest2,
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

    public function apiShowCapacity($id)
    {
        $contest = $this->getContest($id, config('util.TYPE_TEST'))->first()->load('rounds');
        try {
            if (is_null($contest))
                return $this->responseApi(
                    [
                        'status' => false,
                        'payload' => 'Không tìm thấy bài test năng lực !',
                    ]
                );
            return $this->responseApi(
                [
                    "status" => true,
                    "payload" => $contest,
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
        $contest =  $this->contest->getContest()::whereId($id)->where('type', config('util.TYPE_CONTEST'))->first()->load(['judges', 'rounds' => function ($q) use ($id) {
            return $q->when(
                auth()->check() && auth()->user()->hasRole('judge'),
                function ($q) use ($id) {
                    $judge = Judge::where('contest_id', $id)->where('user_id', auth()->user()->id)->with('judge_round')->first('id');
                    $arrId = [];
                    foreach ($judge->judge_round as $judge_round) {
                        array_push($arrId, $judge_round->id);
                    }
                    return $q->whereIn('id', $arrId);
                }
            );
        }]);
        return view('pages.contest.detail.detail', compact('contest'));
    }

    public function show_test_capacity(Request $request, $id , Skill $skillModel)
    {
        if (! $this->contest->getContest()::where('type', 1)->whereId($id)->exists()) abort(404);
        $test_capacity =  $this->contest->getContest()::where('type', 1)
            ->whereId($id)
            ->with([
                'rounds' => function ($q) {
                    return $q->with(['exams'])->withCount('exams');
                }
            ])
            ->first();
        $skills = $skillModel::all();
        return view('pages.contest.detail-capacity.detail', [
            'test_capacity' => $test_capacity,
            'skills' => $skills
        ]);
    }

    public function contestDetailTeam($id)
    {
        $contest =   $this->contest->find($id);
        $teams = $this->team::get()->load('contest');
        return view('pages.contest.detail.team.contest-team', compact('contest', 'teams'));
    }

    public function contestDetailTeamAddSelect(Request  $request,Redirect $redirect, $id)
    {
        // dd($request->all());
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
        $listContestSofts = $this->getList()->paginate(request('limit') ?? 5);
        return view('pages.contest.contest-soft-delete', [
            'listContestSofts' => $listContestSofts
        ]);
    }

    public function backUpContest($id)
    {
        try {
            $this->contest->getContest()::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function deleteContest($id)
    {
        try {
            $this->contest->getContest()::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function contestDetailEnterprise($id , Enterprise $enterpriseModel)
    {
        if (!($contestEnterprise = $this->contest->find($id)->load('enterprise')->enterprise()->paginate(5))) return abort(404);
        $contest =  $this->contest->find($id);
        $enterprise = $enterpriseModel::all();
        return view('pages.contest.detail.enterprise', ['contest' => $contest, 'contestEnterprise' => $contestEnterprise, 'enterprise' => $enterprise]);
    }
    public function attachEnterprise(Request $request, $id)
    {
        try {

            $this->contest->find($id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function detachEnterprise($id, $enterprise_id)
    {
        try {
            $this->contest->find($id)->enterprise()->detach([$enterprise_id]);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
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
            return Redirect::back();
        }
    }

    public function editFormTeamContestSave(Request $request, $id_contest, $id_team)
    {
        $contest = $this->contest->find($id_contest);
        if (!is_null($contest)) {
            return $this->editTeamContest($request, $id_team, $id_contest, Redirect::route('admin.contest.detail.team', ['id' => $id_contest]), Redirect::back());
        } else {
            return Redirect::back();
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
            if ($team_id == 0)  return response()->json([
                'status' => true,
                'payload' => [],
            ]);
            $team = $this->team::find($team_id)->load('members');
            return response()->json([
                'status' => true,
                'payload' => $team,
            ]);
        } catch (\Throwable $th) {
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            dd($th);
        }
    }

    public function sendMail($id)
    {
        $contest = $this->contest->getContest()::findOrFail($id)->load([
            'judges',
            'teams' => function ($q) {
                return $q->with(['members']);
            }
        ]);
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
        $take_exams = $contest->take_exams()->with(['teams' => function ($q) use ($contest) {
            return $q->where('contest_id', $contest->id)->with('users');
        }])->orderByDesc('final_point')->orderByDesc('updated_at')->get();
        $pointAdd = json_decode($contest->reward_rank_point);
        try {
            DB::transaction(function () use ($contest, $pointAdd, $take_exams) {
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
        $capacityArrId= [];
        $capacity = $this->contest->find($id_capacity);
        if(is_null($capacity)) return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Không tìm thấy bài test năng lực !',
            ]
        );
        $capacity->load(['recruitment'=>function($q){
            return $q->with(['contest'=>function($q){
                //  return $q->get(['id']);
            }]);
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
        return response()->json([
            'status' => true,
            'payload' => $capacitys,
        ]);
    }
}



//
