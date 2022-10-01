<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Major;
use App\Models\Skill;
use App\Models\Enterprise;
use App\Models\ContestUser;
use Illuminate\Http\Request;
use App\Services\Traits\TStatus;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Contest\RequestContest;
use App\Services\Modules\MTeam\MTeamInterface;
use App\Services\Modules\MMajor\MMajorInterface;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MContestUser\MContestUserInterface;

class ContestController extends Controller
{
    use TUploadImage, TResponse, TTeamContest, TStatus;

    public function __construct(
        private MContestInterface $contest,
        private MMajorInterface $majorRepo,
        // private Major $major,
        private MTeamInterface $teamRepo,
        // private Team $team,
        private DB $db,
        private Storage $storage,
        private MSkillInterface $skill,
        private MContestUserInterface $contestUser,
    ) {
    }

    public function getConTestCapacity()
    {
        if (!auth()->check()) return $this->responseApi(false, "Không thể xem !");
        $data = $this->contest->getConTestCapacityByDateTime();
        return $this->responseApi(true, $data);
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
            'contests' => $data,
            'majors' => $this->majorRepo->getAllMajor(['where' => ['parent_id' => 0]], ['majorChils']),
            'contest_type_text' =>  request('type') == 1 ? 'test năng lực' : 'cuộc thi'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/contests",
     *     description="Description api contests",
     *     tags={"Contest"},
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
        return $this->responseApi(true, $data);
    }

    /**
     * @OA\Get(
     *     path="/api/public/capacity",
     *     description="Description api capacity",
     *     tags={"Capacity"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="qq",
     *         in="query",
     *         description="Tìm kiếm tách chuỗi ",
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
     *     @OA\Parameter(
     *         name="skill_id",
     *         in="query",
     *         description="Lọc theo skill   ",
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
        $majors = $this->majorRepo->getAllMajor();
        $skills = $this->skill->getAll();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        return view('pages.contest.form-add', compact('majors', 'contest_type_text', 'skills'));
    }

    public function store(RequestContest $request, Redirect $redirect)
    {
        $this->checkTypeContest();
        $this->db::beginTransaction();
        try {

            $filename = $this->uploadFile($request->img);
            $contest = $this->contest->store($filename, $request, $request->skill ?? []);

            $this->db::commit();
            if ($contest->type == 1) return $redirect::route('admin.contest.show.capatity', ['id' => $contest->id])->withErrors('success', 'Thêm mới thành công !');
            return $redirect::route('admin.contest.show', ['id' => $contest->id])->withErrors('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                if ($this->storage::disk('s3')->has($filename)) $this->storage::disk('s3')->delete($filename);
            }
            $this->db::rollBack();
            return $redirect::back()->withErrors(['error' => 'Thêm mới thất bại !']);
        }
    }

    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return abort(404);
            $this->db::transaction(function () use ($id) {
                $contest = $this->contest->find($id);
                if ($this->storage::disk('s3')->has($contest->image ?? 'null')) $this->storage::disk('s3')->delete($contest->image);
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
        $major = $this->majorRepo->getAllMajor();
        $skills = $this->skill->getAll();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        $contest = $this->contest->getContestByIdUpdate($id, request('type') ?? 0);
        if (!$contest || $contest->status == 2 || $contest->type != request('type')) abort(404);

        $rewardRankPoint = json_decode($contest->reward_rank_point);
        $skillContests = $contest->skills->map(function ($data) {
            return $data->skill_id;
        })->toArray();

        return view('pages.contest.edit', compact('contest', 'skillContests', 'major', 'rewardRankPoint', 'contest_type_text', 'skills'));
    }

    public function update(RequestContest $request, $id)
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
                    if (!$img)  return redirect()->back()->with('error', 'Cập nhật thất bại !');
                    $dataSave = array_merge($request->except(['_method', '_token', 'img']), [
                        'reward_rank_point' => $rewardRankPoint,
                        'img' => $img
                    ]);
                } else {
                    $dataSave = array_merge($request->except(['_method', '_token']), [
                        'reward_rank_point' => $rewardRankPoint,
                    ]);
                }

                if ($contest->date_start < now()) unset($dataSave['date_start']);

                $this->contest->update($contest, $dataSave, $request->skill ?? []);

                $this->db::commit();
                if ($contest->type == 1) return redirect(route('admin.contest.show.capatity', ['id' => $contest->id]))->withErrors('success', 'Cập nhật thành công !');
                return redirect(route('admin.contest.list') . '?type=' . request('type') ?? 0)->withErrors('success', 'Cập nhật thành công !');
            }
        } catch (\Exception $e) {
            $this->db::rollBack();
            return redirect()->back()->withErrors(['error' => 'Cập nhật thất bại !']);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/contests/{id}",
     *     description="Description api contests",
     *     tags={"Contest"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id cuộc thi ",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiShow($id)
    {
        try {
            if (!($contest = $this->contest->apiShow($id, config('util.TYPE_CONTEST'))))
                return $this->responseApi(false, 'Không thể lấy thông tin cuộc thi  !');
            return $this->responseApi(true, $contest);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/capacity/{id}",
     *     description="Description api capacity",
     *     tags={"Capacity"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id test năng lực  ",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiShowCapacity($id)
    {
        try {
            $capacity = $this->contest->apiShow($id, config('util.TYPE_TEST'));
            if (is_null($capacity))
                return $this->responseApi(false, 'Không tìm thấy bài test năng lực !');
            return $this->responseApi(true, $capacity);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    public function show(Request $request, $id)
    {
        $contest = $this->contest->show($id, config('util.TYPE_CONTEST'));
        if (!$contest) abort(404);
        return view('pages.contest.detail.detail', compact('contest'));
    }

    public function show_test_capacity(Request $request, Skill $skillModel, $id)
    {
        $capacity = $this->contest->getContestByIdUpdate($id, config('util.TYPE_TEST'));
        if (!$capacity) abort(404);
        $skills = $skillModel::all(['name', 'id']);
        return view('pages.contest.detail-capacity.detail', [
            'test_capacity' => $capacity,
            'skills' => $skills
        ]);
    }

    public function contestDetailTeam($id)
    {
        $contest = $this->contest->find($id);
        $teams = $this->teamRepo->getAllTeam([], ['contest']);
        return view('pages.contest.detail.team.contest-team', compact('contest', 'teams'));
    }

    public function contestDetailTeamAddSelect(Request  $request, Redirect $redirect, $id)
    {
        try {
            $this->teamRepo->updateTeam($request->team_id, ['contest_id' => $id]);
            return $redirect::back();
        } catch (\Throwable $th) {
            return $redirect::back()->withErrors(["error" => "Đã xảy ra lỗi !"]);
        }
    }

    public function softDelete()
    {
        $listContestSofts = $this->contest->index();
        $namePage = request('type') == 1 ? 'Test năng lực' : 'Cuộc thi ';
        return view('pages.contest.contest-soft-delete', [
            'listContestSofts' => $listContestSofts,
            'namePage' => $namePage
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

    public function contestDetailEnterprise($id, Enterprise $enterpriseModel)
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
            $contest->load(['teams' => function ($q) use ($id_team) {
                return $q->with('members')->whereId($id_team)->first();
            }]);

            foreach ($contest->teams as  $team) {
                foreach ($team->members as  $me) {
                    array_push($userArray, [
                        'id_user' => $me->id,
                        'email_user' => $me->email,
                        'name_user' => $me->name,
                        'bot' => $me->pivot->bot,
                    ]);
                }
            }
            $team = $this->teamRepo->find($id_team);

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
            dd($th->getMessage());
            return abort(404);
        }
    }

    private function updateUserAddPoint($users, $id, $point)
    {

        foreach ($users as $user) {
            $this->contestUser->checkExitsAndManager([
                'contest_id' => $id,
                'user' => $user,
                'point' => $point
            ]);
        };
    }

    public function apiContestRelated($id_capacity)
    {
        try {
            $capacitys = $this->contest->getContestRelated($id_capacity);
            return $this->responseApi(true, $capacitys);
        } catch (\Throwable $th) {
            return $this->responseApi(false, $th->getMessage());
        }
    }
}



//