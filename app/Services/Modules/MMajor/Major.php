<?php

namespace App\Services\Modules\MMajor;

class Major implements MMajorInterface
{
    public function __construct(public \App\Models\Major $major)
    { }

    public function getRatingUserByMajorSlug($slug)
    {
        if (!$major = $this->major::whereSlug($slug)
             ->first()
        ) return false;
        $rank = 0;
        $maxPoin = 0;
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
                    'rank' => $rank,
                    'reward_point' => $q->reward_point,
                    'contest_name' => $q->contest->name,
                    'contest' => $q->contest,
                    'user' => $q->user,
                ];
            });
    }
}
