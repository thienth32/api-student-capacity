<?php

namespace App\Services\Modules\MUser;

use App\Models\Contest;
use App\Models\ResultCapacity;
use App\Models\User as ModelsUser;

class User implements MUserInterface
{
    public function __construct(
        private  ModelsUser $user,
        private Contest $contest,
        private ResultCapacity $resultCapacity
    ) {
    }

    public function contestJoined()
    {
        $contestID = [];
        $user_id = auth('sanctum')->user()->id;
        if (!(request()->has('type'))  || request('type') == config('util.TYPE_CONTEST')) {
            $contests = $this->user::find($user_id)->teams()->get()
                ->map(function ($val, $key) {
                    return [
                        'id_contest' => $val->contest->id,
                    ];
                });
            $makeHidden = [
                "created_at",
                "updated_at", "deleted_at", 'teams', 'reward_rank_point', 'description', 'major_id', 'post_new'
            ];
        }
        if (request()->has('type') && request('type') == config('util.TYPE_TEST')) {
            $contests = $this->resultCapacity::where('user_id', $user_id)
                ->has('contests')->with(['contests' => function ($q) {
                    $q->select(['contests.id']);
                    $q->setEagerLoads([]);
                    return $q;
                }])->get()->map(function ($val, $key) {
                    return [
                        'id_contest' => $val->contests->id,
                    ];
                });
            $makeHidden = [
                'max_user', "created_at",
                "updated_at", "deleted_at",
                "start_register_time",
                "end_register_time",
                "status_user_has_join_contest",
                "user_wishlist",
                'teams', 'reward_rank_point', 'description', 'major_id', 'post_new'
            ];
        }
        foreach ($contests as $contest) {
            array_push($contestID, $contest['id_contest']);
        }
        $contestID = array_unique($contestID);
        $contest = $this->contest::whereIn('id', $contestID)
            ->when(request('type'), function ($q) {
                $q->hasRequest(['type' => request('type')]);
                $q->with(['skills:name,short_name']);
                $q->withCount(['rounds',  'userCapacityDone']);
                return $q;
            })
            ->when((!(request()->has('type'))  || request('type') == config('util.TYPE_CONTEST')), function ($q) {
                $q->withCount(['teams']);
            })
            ->search(request('q') ?? null, ['name'])
            ->status(request('status'))
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
            ->paginate(request('limit') ?? 10);
        $contest->setCollection($contest->getCollection()->makeHidden($makeHidden));
        return $contest;
    }

    public function getTotalStudentAcount()
    {
        return $this->user::with('roles')
            ->whereHas('roles', function ($q) {
                $q->where('id', config('util.STUDENT_ROLE'));
            })->count();
    }
}