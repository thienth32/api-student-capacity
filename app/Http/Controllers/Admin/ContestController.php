<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Judge;
use App\Models\Major;
use App\Models\Contest;
use App\Models\Skills;
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

    public function __construct(Contest $contest, Major $major, Team $team)
    {
        $this->contest = $contest;
        $this->major = $major;
        $this->team = $team;
    }

    /**
     *  Get list contest
     */
    private function getList($flagCapacity = false)
    {
        try {
            $with = [];
            if(!$flagCapacity) $with = [
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
            if($flagCapacity) $with = [
                'rounds' => function ($q) {
                    return $q -> with([
                        'exams' => function ($q) {
                            return $q -> with ([
                                'questions' => function ($q) {
                                    return $q -> with('answers');
                                }
                            ]);
                        }
                    ]);
                }
            ];
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $data = $this->contest::when(request()->has('contest_soft_delete'), function ($q) {
                return $q->onlyTrashed();
            })
                ->when(auth()->check() && auth()->user()->hasRole('judge'), function ($q) {
                    return $q->whereIn('id', array_unique(Judge::where('user_id', auth()->user()->id)->pluck('contest_id')->toArray()));
                })
                ->search(request('q') ?? null, ['name'])
                ->missingDate('register_deadline', request('miss_date') ?? null, $now->toDateTimeString())
                ->passDate('register_deadline', request('pass_date') ?? null, $now->toDateTimeString())
                ->registration_date('end_register_time', request('registration_date') ?? null, $now->toDateTimeString())
                ->status(request('status'))
                ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
                ->hasDateTimeBetween('date_start', request('start_time') ?? null, request('end_time') ?? null)
                // ->hasDateTimeBetween('end_register_time',request('registration_date'))
                ->hasRequest(['major_id' => request('major_id') ?? null])
                ->with($with)
                ->withCount('teams');
            return $data;
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
        if (!($data = $this->getList()->where('type', request('type') ?? 0)->paginate(request('limit') ?? 10))) return abort(404);
        return view('pages.contest.index', [
            'contests' => $data,
            'majors' => Major::where('parent_id', 0)->get(),
            'contest_type_text' =>  request('type') == 1 ? 'test năng lực' : 'cuộc thi'
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
                "payload" => $data->where('type',config('util.TYPE_CONTEST'))->paginate(request('limit') ?? 9),
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
                "payload" => $data->where('type',config('util.TYPE_TEST'))->paginate(request('limit') ?? 9),
            ]
        );
    }


    public function create()
    {
        $this->checkTypeContest();
        $majors = Major::all();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        return view('pages.contest.form-add', compact('majors', 'contest_type_text'));
    }
    public function store(Request $request)
    {
        $this->checkTypeContest();
        $rule =   [
            'name' => 'required|max:255|unique:contests,name',
            'top1' => 'required|numeric',
            'top2' => 'required|numeric',
            'top3' => 'required|numeric',
            'leave' => 'required|numeric',
            'img' => 'required|mimes:jpeg,png,jpg|max:10000',
            'date_start' => 'required|date',
            'register_deadline' => 'required|date',
            'description' => 'required',
        ];
        if (request('type') == config('util.TYPE_CONTEST')) $rule = array_merge($rule, [
            'max_user' => 'required|numeric',
            'start_register_time' => 'required|date',
            'end_register_time' => 'required|date',
        ]);
        $validator = Validator::make(
            $request->all(),
            $rule,
            [
                'top1.required' => 'Chưa nhập trường này !',
                'top1.numeric' =>  'Sai định dạng !',
                'top2.required' => 'Chưa nhập trường này !',
                'top2.numeric' =>  'Sai định dạng !',
                'top3.required' => 'Chưa nhập trường này !',
                'top3.numeric' =>  'Sai định dạng !',
                'leave.required' => 'Chưa nhập trường này !',
                'leave.numeric' =>  'Sai định dạng !',

                'name.required' => 'Chưa nhập trường này !',
                'max_user.required' => 'Chưa nhập trường này !',
                'max_user.numeric' =>  'Sai định dạng !',
                'name.unique' => 'Tên cuộc thi đã tồn tại !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'img.mimes' => 'Sai định dạng !',
                'img.required' => 'Chưa nhập trường này !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'date_start.required' => 'Chưa nhập trường này !',
                'date_start.date' => 'Sai định dạng !',
                'start_register_time.required' => 'Chưa nhập trường này !',
                'start_register_time.date' => 'Sai định dạng !',

                'end_register_time.required' => 'Chưa nhập trường này !',
                'end_register_time.date' => 'Sai định dạng !',
                'register_deadline.required' => 'Chưa nhập trường này !',
                'register_deadline.date' => 'Sai định dạng !',
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
            $contest->max_user = $request->max_user ?? 9999;
            $contest->date_start = $request->date_start;
            $contest->start_register_time = $request->start_register_time ?? null;
            $contest->end_register_time = $request->end_register_time ?? null;
            $contest->register_deadline = $request->register_deadline;
            $contest->description = $request->description;
            $contest->post_new = $request->post_new;
            $contest->major_id = $request->major_id;
            $contest->type = request('type') ?? 0;
            $contest->status = config('util.ACTIVE_STATUS');
            $rewardRankPoint = json_encode(array(
                'top1' => $request->top1,
                'top2' => $request->top2,
                'top3' => $request->top3,
                'leave' => $request->leave,
            ));
            $contest->reward_rank_point =  $rewardRankPoint;
            $contest->save();
            DB::commit();
            return Redirect::route('admin.contest.show', ['id' => $contest->id])->with('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                if (Storage::disk('s3')->has($filename)) Storage::disk('s3')->delete($filename);
            }
            DB::rollBack();
            return Redirect::back()->with('error', 'Thêm mới thất bại !');
        }



        // dd($request->all());
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
        $major = Major::orderBy('id', 'desc')->get();
        $contest_type_text = request('type') == 1 ? 'test năng lực' : 'cuộc thi';
        $contest = $this->getContest($id)->first();
        if ($contest->type != request('type')) abort(404);
        $rewardRankPoint = json_decode($contest->reward_rank_point);
        if ($contest) {
            return view('pages.contest.edit', compact('contest', 'major', 'rewardRankPoint', 'contest_type_text'));
        } else {
            return view('error');
        }
    }

    public function update(Request $request, $id)
    {
        $this->checkTypeContest();
        $rule = [
            'name' => 'required|unique:contests,name,' . $id . '',
            'img' => 'mimes:jpeg,png,jpg|max:10000',
            'date_start' => "required",
            'register_deadline' => "required|after:date_start",
            'description' => "required",
            'major_id' => "required",

        ];
        if (request('type') == config('util.TYPE_CONTEST')) $rule = array_merge($rule, [
            'max_user' => 'required|numeric',
            'start_register_time' => 'required|date|before:end_register_time',
            'end_register_time' => 'required|date|after:start_register_time',
        ]);
        $validator = Validator::make(
            $request->all(),
            $rule,
            [
                'max_user.required' => 'Chưa nhập trường này !',
                'max_user.numeric' =>  'Sai định dạng !',

                'img.mimes' => 'Sai định dạng !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                "name.required" => "Tường name không bỏ trống !",
                "name.unique" => "Tên cuộc thi đã tồn tại !",
                "date_start.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                "register_deadline.required" => "Tường thời gian kết thúc không bỏ trống !",
                "register_deadline.after" => "Tường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                "description.required" => "Tường mô tả không bỏ trống !",
                "major_id.required" => "Tường cuộc thi tồn tại !",

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
            $rewardRankPoint = json_encode(array(
                'top1' => $request->top1,
                'top2' => $request->top2,
                'top3' => $request->top3,
                'leave' => $request->leave,
            ));
            $contest->reward_rank_point =  $rewardRankPoint;
            $contest->update($request->all());

            Db::commit();
            // return Redirect::route('admin.contest.list');
            return redirect(route('admin.contest.list') . '?type=' . request('type') ?? 0);
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
        $contest =  Contest::find($id)->load(['judges', 'rounds' => function ($q) use ($id) {
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

    public function show_test_capacity(Request $request, Contest $contest , $id)
    {
        if(!$contest::where('type' , 1)->whereId($id)->exists()) abort(404);
        $test_capacity = $contest::where('type' , 1)
                                ->whereId($id)
                                ->with([
                                    'rounds' => function ($q)
                                    {
                                        return $q -> with(['exams']) -> withCount('exams');
                                    }
                                ])
                                ->first();
        $skills = Skills::all();
        return view('pages.contest.detail-capacity.detail',[
            'test_capacity' => $test_capacity,
            'skills' => $skills
        ]);
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
        $contest = Contest::find($id_contest);
        if (!is_null($contest)) {
            return $this->editTeamContest($request, $id_team, $id_contest, Redirect::route('admin.contest.detail.team', ['id' => $id_contest]), Redirect::back());
        } else {
            return Redirect::back();
        }
    }
    public function userTeamRound($roundId)
    {
        $team_id = 0;
        $user_id = auth('sanctum')->user()->id;
        $round = Round::find($roundId)->load('teams');
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
            $team = Team::find($team_id)->load('members');
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
        $contest = Contest::findOrFail($id)->load([
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
        if (!$contest = $this->contest::find($id)) abort(404);
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

    private function updateUserAddPoint($users, $id, $point)
    {
        foreach ($users as $user) {
            if (!$contestUser = ContestUser::where('contest_id', $id)
                ->where('user_id', $user->id)
                ->first()) $contestUser = ContestUser::create([
                'contest_id' => $id,
                'user_id' => $user->id,
                'reward_point' => 0
            ]);
            $contestUser->reward_point = $contestUser->reward_point + $point;
            $contestUser->save();
        };
    }
}



//