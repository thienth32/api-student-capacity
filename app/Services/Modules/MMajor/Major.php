<?php

namespace App\Services\Modules\MMajor;

use App\Models\ContestUser;

class Major implements MMajorInterface
{
    public function __construct(public \App\Models\Major $major, public ContestUser $contestUser)
    {
    }

    public function getRatingUserByMajorSlug($slug)
    {
        // $major = $this->major::whereSlug($slug)
        //     ->with([
        //         'contest_user' => function ($q) {
        //             return $q
        //                 ->selectRaw('sum(contest_users.reward_point) as reward_point,contest_users.user_id')
        //                 ->groupBy('contest_users.user_id')
        //                 ->orderByDesc('reward_point');
        //         }
        //     ])
        //     ->first();
        // if ($major == null) return false;

        // return $major
        //     ->contest_user
        //     ->map(function ($q, $index) use (&$rank, &$maxPoin) {
        //         if ($index == 0) {
        //             $maxPoin = $q->reward_point;
        //         }
        //         // **
        //         if ($index == 0) {
        //             $rank = 1;
        //         }
        //         // **
        //         if ($q->reward_point == $maxPoin) {
        //             $rank = $rank;
        //         }
        //         // **
        //         if ($q->reward_point < $maxPoin) {
        //             $rank += 1;
        //         }
        //         // **
        //         if ($q->reward_point < $maxPoin) {
        //             $maxPoin = $q->reward_point;
        //         }
        //         // **
        //         return [
        //             'user_name' => $q->user->name,
        //             'avatar' => $q->user->avatar,
        //             'rank' => $rank,
        //             'reward_point' => $q->reward_point,
        //             'user' => $q->user,
        //         ];
        //     })
        //     ->toArray();
        $rank = 0;
        $maxPoin = 0;
        $major = $this->major::whereSlug($slug)->with(['contest_user', 'contests:id,major_id'])->first();
        $contest = $major->contests->map(function ($data) {
            return $data->id;
        })->toArray();
        return $this->contestUser::whereIn('contest_id', $contest)
            ->selectRaw('sum(contest_users.reward_point) as reward_point,contest_users.user_id')
            ->groupBy('contest_users.user_id')
            ->orderByDesc('reward_point')
            ->with(['user'])
            ->get()
            ->map(function ($q, $index) use (&$rank, &$maxPoin) {
                if ($index == 0) {
                    $maxPoin = $q->reward_point;
                }
                // **
                if ($index == 0) {
                    $rank = 1;
                }
                // **
                if ($q->reward_point == $maxPoin) {
                    $rank = $rank;
                }
                // **
                if ($q->reward_point < $maxPoin) {
                    $rank += 1;
                }
                // **
                if ($q->reward_point < $maxPoin) {
                    $maxPoin = $q->reward_point;
                }
                // **
                return [
                    'user_name' => $q->user->name,
                    'avatar' => $q->user->avatar,
                    'rank' => $rank,
                    'reward_point' => $q->reward_point,
                    'user' => $q->user,
                ];
            });
        return $major
            ->contest_user()
            ->orderByDesc('reward_point')
            ->with('contest')
            ->get()
            ->map(function ($q, $index) use (&$rank, &$maxPoin) {
                if ($index == 0) {
                    $maxPoin = $q->reward_point;
                }
                // **
                if ($index == 0) {
                    $rank = 1;
                }
                // **
                if ($q->reward_point == $maxPoin) {
                    $rank = $rank;
                }
                // **
                if ($q->reward_point < $maxPoin) {
                    $rank += 1;
                }
                // **
                if ($q->reward_point < $maxPoin) {
                    $maxPoin = $q->reward_point;
                }
                // **
                return [
                    'user_name' => $q->user->name,
                    'avatar' => $q->user->avatar,
                    'rank' => $rank,
                    'reward_point' => $q->reward_point,
                    'contest_name' => $q->contest->name,
                    'contest' => $q->contest,
                    'user' => $q->user,
                ];
            });
    }


    public function getRankUserCapacity($slug)
    {
        if (!$major = $this->major::whereSlug($slug)
            ->first()) return false;

        $major->load(
            ['resultCapacity' => function ($q) {
                return $q->where('contests.type', config('util.TYPE_TEST'))
                    ->where('result_capacity.status', config('util.STATUS_RESULT_CAPACITY_DONE'))
                    ->selectRaw('sum(result_capacity.scores) as total_scores, result_capacity.user_id')
                    ->groupBy('result_capacity.user_id')
                    ->orderByDesc('total_scores');
            }]
        );
        $apps = $major->resultCapacity()->paginate(10);
        return  $apps;
        // return  $major->resultCapacity;
    }

    public function getAllMajor($params = [], $with = [])
    {
        return $this->major::hasRequest($params['where'] ?? [])
            ->with($with)
            ->orderBy('id', 'desc')
            ->get();
    }
}