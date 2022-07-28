<?php

namespace App\Services\Modules\MContest;

use App\Models\Major;
use App\Models\Contest as ModelContest;
use App\Models\Team;
use App\Models\Judge;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;

class Contest
{
    use TUploadImage;


    public function __construct(
        private ModelContest $contest,
        private Major $major,
        private Team $team,
        private Judge $judge,
        private Carbon $carbon,
    ) {
    }

    private function getList($flagCapacity, $request)
    {
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

        $now = $this->carbon::now('Asia/Ho_Chi_Minh');
        return  $this->contest::when($request->has('contest_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->when(auth()->check() && auth()->user()->hasRole('judge'), function ($q) {
                return $q->whereIn('id', array_unique($this->judge::where('user_id', auth()->user()->id)->pluck('contest_id')->toArray()));
            })
            ->search($request->q ?? null, ['name'], true)
            ->missingDate('register_deadline', $request->miss_date ?? null, $now->toDateTimeString())
            ->passDate('register_deadline', $request->pass_date ?? null, $now->toDateTimeString())
            ->registration_date('end_register_time', $request->registration_date ?? null, $now->toDateTimeString())
            ->status($request->status)
            ->sort(($request->sort == 'asc' ? 'asc' : 'desc'), $request->sort_by ?? null, 'contests')
            ->hasDateTimeBetween('date_start', $request->start_time ?? null, $request->end_time ?? null)
            // ->hasDateTimeBetween('end_register_time',request('registration_date'))
            ->hasRequest(['major_id' => $request->major_id ?? null])
            ->with($with)
            ->withCount('teams');
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
            ->paginate(request('limit') ?? 10);
    }

    public function apiIndex($flagCapacity = false)
    {
        return $this->getList($flagCapacity, request())
            ->where('type', config('util.TYPE_CONTEST'))
            ->paginate(request('limit') ?? 9);
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
                return $q->withCount('members');
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
                return $q->with(['exams'])->withCount('exams');
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
}