<?php

namespace App\Services\Modules\MContest;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Judge;
use App\Models\Major;
use App\Models\JudgeRound;
use Illuminate\Support\Facades\DB;
use App\Services\Traits\TUploadImage;
use App\Http\Resources\ContestDemoList;
use App\Models\Contest as ModelContest;
use App\Http\Resources\CapacityResource;
use App\Http\Resources\ContestResource;
use App\Http\Resources\DetailContestResource;
use App\Http\Resources\RoundDemoListResource;
use App\Http\Resources\DetailCapacityApiResource;

class Contest implements MContestInterface
{
    use TUploadImage;


    public function __construct(
        private ModelContest $contest,
        private Major $major,
        private Team $team,
        private Judge $judge,
        private JudgeRound $judge_round,
        private Carbon $carbon,
    ) {
    }

    private function getList($flagCapacity, $request)
    {
        $with = [];
        $user = auth()->user();
        if (!$flagCapacity)
            $with = [];
        $whereDate = ['date_start', 'register_deadline', 'start_register_time', 'end_register_time'];
        if (request()->has('type') && request('type') == 1) $whereDate = ['date_start', 'register_deadline'];

        if ($flagCapacity)
            $with = [
                'skills:name,short_name',
            ];

        $now = $this->carbon::now('Asia/Ho_Chi_Minh');
        $contest =  $this->contest::when($request->has('contest_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->when(isset($user) && $user->hasRole('judge'), function ($q, $v) use ($user) {
                return $q->whereIn('id', array_unique($this->judge::where('user_id', $user->id)
                    ->pluck('contest_id')
                    ->toArray()));
            });

        $contest->where(function ($contest) use ($request, $now, $whereDate) {
            if ($request->has('qq')) $contest->searchKeyword($request->qq ?? null, ['name'], true);
            if ($request->has('q')) $contest->search($request->q ?? null, ['name'], true);
            if ($request->has('miss_date')) $contest->missingDate('register_deadline', $request->miss_date ?? null, $now->toDateTimeString())
                ->orWhere('status', '>', 1);
            if ($request->has('pass_date')) $contest->passDate('register_deadline', $request->pass_date ?? null, $now->toDateTimeString())
                ->where('status', '<=', 1);
            if ($request->has('registration_date')) $contest->registration_date('end_register_time', $request->registration_date ?? null, $now->toDateTimeString());
            if ($request->has('status')) $contest->status($request->status);
            if ($request->has('start_time') && $request->has('end_time')) $contest->hasDateTimeBetween($whereDate, $request->start_time ?? null, $request->end_time ?? null);
            if ($request->has('major_id')) $contest->hasRequest(['major_id' => $request->major_id ?? null]);
            if ($request->has('skill_id')) $contest->whenWhereHasRelationship(request('skill_id') ?? null, 'skills', 'skills.id', (request()->has('skill_id') && request('skill_id') == 0) ? true : false);
        });
        if ($request->has('sort')) $contest->sort(($request->sort == 'asc' ? 'asc' : 'desc'), $request->sort_by ?? null, 'contests');


        return $contest
            ->with($with)
            ->withCount(['teams', 'rounds', 'userCapacityDone']);
    }

    public function index()
    {
        return $this->getList(false, request())
            ->where('type', request('type') ?? 0)
            ->withCount([
                "rounds",
                "teams",
                "contest_users",
                "posts",
                "enterprise",
                "judges"
            ])
            ->orderBy('date_start', 'desc')
            ->paginate(request('limit') ?? 5);
    }

    public function capacityResourceCollection($data)
    {
        return  CapacityResource::collection($data)->response()->getData(true);
    }
    public function apiIndex($flagCapacity = false)
    {
        if ($flagCapacity) {
            $data = $this->getList($flagCapacity, request())
                ->where('type', $flagCapacity ?  config('util.TYPE_TEST') : config('util.TYPE_CONTEST'))
                ->where('status', 1)
                ->orderBy('date_start', 'desc')
                ->paginate(request('limit') ?? 9);
            return  $this->capacityResourceCollection($data);
        }
        if (!$flagCapacity) {
            $data = $this->getList($flagCapacity, request())
                ->where('type', $flagCapacity ?  config('util.TYPE_TEST') : config('util.TYPE_CONTEST'))
                ->orderBy('date_start', 'desc')
                ->get();
            return  ContestResource::collection($data);
        }
    }

    public function getConTestCapacityByDateTime()
    {
        return $this->contest::where("register_deadline", ">=", request("date"))
            ->orderBy("register_deadline", "asc")
            ->get();
    }

    public function store($filename, $fileBanner, $request, $skills = [])
    {
        $contest = new $this->contest();
        $contest->img = $filename;
        $contest->name = $request->name;
        $contest->image_banner = $fileBanner ?? null;
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
        $rewardRankPoint = json_encode(
            [
                'top1' => $request->top1,
                'top2' => $request->top2,
                'top3' => $request->top3,
                'leave' => $request->leave,
            ]
        );
        $contest->reward_rank_point =  $rewardRankPoint;
        $contest->save();
        if ($contest->type == 1 && count($skills) > 0) $contest->skills()->sync($skills);

        return $contest;
    }

    private function whereId($id, $type)
    {
        return $this->contest::whereId($id)
            ->where('type', $type);
    }

    public function sendMail($id)
    {
        return $this->whereId($id, config('util.TYPE_CONTEST'))
            ->with([
                'judges',
                'teams' => function ($q) {
                    return $q->with(['members']);
                }
            ])
            ->first();
    }

    public function backUpContest($id)
    {
        return $this->contest::withTrashed()->where('id', $id)->restore();
    }

    public function deleteContest($id)
    {
        return $this->contest::withTrashed()->where('id', $id)->forceDelete();
    }

    public function apiShow($id, $type)
    {
        $with = [
            'teams',
            'teams.members:id,name,email,avatar',
            'rounds' => function ($q) {
                return $q->with([
                    'teams:name,image,contest_id',
                    'judges'
                ]);
            },
            'judges:name,avatar,email'
        ];
        $withCount = ['rounds'];
        if ($type == config('util.TYPE_TEST')) {
            $with = [
                'rounds' => function ($q) {
                    $q->orderBy('start_time', 'asc');
                    $q->setEagerLoads([]);
                    return $q;
                },
                'recruitmentEnterprise',
            ];
            $withCount = ['rounds', 'userCapacityDone'];
        }
        $contest = $this->whereId($id, $type)
            ->with($with)
            ->withCount($withCount)
            ->first();
        if ($type == config('util.TYPE_TEST')) return new DetailCapacityApiResource($contest);
        return new DetailContestResource($contest);
    }

    public function show($id, $type)
    {
        $with = [
            'judges',
            'rounds' => function ($q) use ($id) {
                return $q->when( //
                    auth()->check() && auth()->user()->hasRole('judge'),
                    function ($q) use ($id) {
                        $judge = $this->judge::where('contest_id', $id)
                            ->where('user_id', auth()->user()->id)
                            ->with('judge_round')
                            ->first('id');
                        $arrId = [];
                        foreach ($judge->judge_round as $judge_round) {
                            array_push($arrId, $judge_round->id);
                        }
                        return $q->whereIn('id', $arrId);
                    }
                )->with(['judges']); //
            },
            'skills'
        ];
        if ($type == config('util.TYPE_TEST')) $with = [
            'rounds' => function ($q) {
                return $q->with(['exams'])->withCount('results', 'exams', 'posts', 'sliders');
            }
        ];
        try {
            $contest = $this->whereId($id, $type)
                ->with($with)
                ->first();
            return $contest;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function find($id)
    {
        return $this->contest::find($id);
    }

    public function update($contest, $data, $skills = [])
    {
        $contest->update($data);
        if ($contest->type == 1 && count($skills) > 0) $contest->skills()->sync($skills);
    }

    public function getContest()
    {
        return $this->contest;
    }

    public function getContestRunning()
    {
        return $this->contest::where('date_start', '<', date('Y-m-d H:i:'))
            ->where('register_deadline', '>', date('Y-m-d H:i'))
            ->get(['name', 'id']);
    }

    public function getCountContestGoingOn()
    {
        return $this->contest::where('status', config('util.CONTEST_STATUS_GOING_ON'))
            ->count();
    }

    public function getContestByDateNow($date)
    {
        return $this->contest::whereMonth('register_deadline', $date->format("m"))
            ->whereDay('register_deadline', $date->format('d'))
            ->get();
    }

    public function getContestMapSubDays($date)
    {
        return $this->contest::where('register_deadline', '>', $date)
            ->where('status', '<=', config('util.CONTEST_STATUS_GOING_ON'))
            ->orderBy('register_deadline', 'desc')
            ->get()
            ->map(function ($q) {
                return [
                    "start" => $q->date_start,
                    "end" => $q->register_deadline,
                    "content" => ($q->type == 1 ? "Đánh giá năng lực : " : "Cuộc thi : ") .
                        $q->name .
                        " - Đã bắt đầu từ " .
                        Carbon::parse($q->date_start)->diffForHumans() .
                        " - Kết thúc vào " .
                        Carbon::parse($q->register_deadline)->diffForHumans()
                ];
            });
    }

    public function getContestRelated($id_contest)
    {
        $makeHidden = [];
        $contestArrId = [];
        $contest = $this->contest::find($id_contest);
        if (is_null($contest)) throw new \Exception('Cuộc thi này không tồn tại !');
        $data = $this->contest::query();
        if ($contest->type == config('util.TYPE_TEST')) {
            $contest->load(['recruitment' => function ($q) {
                $q->with(['contest']);
                return $q;
            }]);
            foreach ($contest->recruitment as  $recruitment) {
                if ($recruitment->contest) foreach ($recruitment->contest as $contest) {
                    array_push($contestArrId, $contest->id);
                }
            }
            $contestArrId = array_unique($contestArrId);
            unset($contestArrId[array_search($id_contest, $contestArrId)]);
            $data->where('type', $contest->type);
            $data->where(function ($q) use ($contestArrId) {
                return  $q->whereIn('id', $contestArrId);
            });
            // $makeHidden = ['user_wishlist', 'max_user', 'end_register_time', 'status', 'start_register_time', 'status_user_has_join_contest', 'description', 'reward_rank_point', 'post_new', 'deleted_at', 'type', 'major_id', 'created_at', 'updated_at'];
            $withCount = ['rounds', 'userCapacityDone'];
        }
        if ($contest->type == config('util.TYPE_CONTEST')) {
            $data->where(function ($q) use ($contest) {
                $q->where('major_id', $contest->major_id);
                $q->where('type', $contest->type);
                return $q;
            });
            // $makeHidden = ['description', 'reward_rank_point', 'post_new', 'deleted_at', 'type', 'major_id', 'created_at', 'updated_at'];
            $withCount = ['rounds', 'teams'];
        }
        $data = $data->orderBy('id', 'desc')
            ->withCount($withCount)
            ->with(['skills'])
            ->paginate(request('limit') ?? 4);
        if ($contest->type == config('util.TYPE_TEST')) return  $this->capacityResourceCollection($data);

        if ($contest->type == config('util.TYPE_CONTEST'))  return  ContestResource::collection($data);
    }

    public function getContestByIdUpdate($id, $type = 0)
    {
        return $this->contest::with(
            [
                'skills' => function ($q) {
                    return $q->select(["name"]);
                },
                'rounds' => function ($q) use ($type) {
                    return $q
                        ->with([
                            'exams' => function ($q) use ($type) {
                                return $q->where('type', $type);
                            }
                        ]);
                    // ->withCount('exams');
                }
            ]
        )
            ->whereId($id, $type)
            ->first();
    }

    public function getContestDeadlineEnd($with = [])
    {
        return $this->contest::where("register_deadline", "<", date("Y-m-d H:i:s"))
            ->where("status", "<=", config('util.CONTEST_STATUS_GOING_ON'))
            ->where("type", config('util.TYPE_CONTEST'))
            ->with($with)
            ->get();
    }

    public function getContestDone()
    {
        return $this->contest::where("status", config('util.CONTEST_STATUS_DONE'))
            ->where("type", config('util.TYPE_CONTEST'))
            ->orderBy("date_start", "asc")
            ->take(3)
            ->get();
    }

    public function endContestOutDateRegisterDealine()
    {
        $contests = $this->getContestDeadlineEnd(['take_exams']);
        if (count($contests) > 0) {
            foreach ($contests as $contest) {
                $pointAdd = json_decode($contest->reward_rank_point);
                $take_exams = $contest->take_exams()
                    ->with([
                        'teams' => function ($q) use ($contest) {
                            return $q->where('contest_id', $contest->id)->with('users');
                        }
                    ])
                    ->orderByDesc('final_point')
                    ->orderByDesc('updated_at')->get();

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
            }
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

    public function userTopCapacity($id)
    {
        $contest = $this->contest::find($id)->load('user_top');
        return $contest->user_top;
    }

    public function getListDemo()
    {
        $datas = $this->contest::where('type', config('util.TYPE_CONTEST'))
            ->orderBy('date_start', 'desc')
            ->with('rounds')
            ->get();

        return ContestDemoList::collection($datas);
    }



    public function apiShowDemo($id)
    {

        $contest =  $this->contest::find($id)->load([
            'rounds'
        ]);
        return RoundDemoListResource::collection($contest->rounds);
    }
}
