<?php

namespace App\Services\Modules\MContest;

use App\Models\JudgeRound;
use App\Models\Major;
use App\Models\Contest as ModelContest;
use App\Models\Team;
use App\Models\Judge;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;

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
        $whereDate = ['date_start', 'register_deadline', 'start_register_time', 'end_regidter_time'];
        if (request()->has('type') && request('type') == 1) $whereDate = ['date_start', 'register_deadline'];

        if ($flagCapacity)
            $with = [
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
            if ($request->has('q')) $contest->search($request->q ?? null, ['name'], true);
            if ($request->has('miss_date')) $contest->missingDate('register_deadline', $request->miss_date ?? null, $now->toDateTimeString())
                ->orWhere('status', '>', 1);
            if ($request->has('pass_date')) $contest->passDate('register_deadline', $request->pass_date ?? null, $now->toDateTimeString())
                ->where('status', '<=', 1);
            if ($request->has('registration_date')) $contest->registration_date('end_register_time', $request->registration_date ?? null, $now->toDateTimeString());
            if ($request->has('status')) $contest->status($request->status);
            if ($request->has('start_time') && $request->has('end_time')) $contest->hasDateTimeBetween($whereDate, $request->start_time ?? null, $request->end_time ?? null);
            if ($request->has('major_id')) $contest->hasRequest(['major_id' => $request->major_id ?? null]);
        });
        if ($request->has('sort')) $contest->sort(($request->sort == 'asc' ? 'asc' : 'desc'), $request->sort_by ?? null, 'contests');
        return $contest
            ->with($with)
            ->withCount(['teams', 'rounds']);
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

    public function apiIndex($flagCapacity = false)
    {
        return $this->getList($flagCapacity, request())
            ->where('type', $flagCapacity ?  config('util.TYPE_TEST') : config('util.TYPE_CONTEST'))
            ->paginate(request('limit') ?? 9);
    }

    public function getConTestCapacityByDateTime()
    {
        return $this->contest::where("register_deadline", ">=", request("date"))
            ->orderBy("register_deadline", "asc")
            ->get();
    }

    public function store($filename, $request)
    {

        $contest = new $this->contest();
        $contest->img = $filename;
        $contest->name = $request->name;
        $contest->img = $filename;
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
            'enterprise',
            'teams' => function ($q) {
                return $q
                    ->with('members')
                    ->withCount('members');
            },
            'rounds' => function ($q) {
                return $q->with([
                    'teams' => function ($q) {
                        return $q->with('members');
                    },
                    'judges' => function ($q) {
                        return $q->with('user');
                    }
                ]);
            },
            'judges'
        ];
        if ($type == config('util.TYPE_TEST')) $with = [
            'rounds',
            'recruitmentEnterprise',
            'userCapacityDone' => function ($q) {
                return $q->with('user');
            }
        ];
        $contest = $this->whereId($id, $type)
            ->with(
                $with
            )
            ->withCount('rounds')
            ->first();
        return $contest;
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
                ); //
            }
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

    public function update($contest, $data)
    {
        $contest->update($data);
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
}