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
        $user = $this->user::find($user_id)->load('teams');
        if (!(request()->has('type'))  || request('type') == config('util.TYPE_CONTEST')) {
            foreach ($user->teams as $team) {
                if ($team->contest) {
                    array_push($contestID, $team->contest->id);
                }
            }
        }
        if (request()->has('type') && request('type') == config('util.TYPE_TEST')) {
            $resultCapacitys = $this->resultCapacity::where('user_id', $user_id)
                ->with(['contests' => function ($q) {
                    return $q->select(['contests.id']);
                }])->get();
            foreach ($resultCapacitys as $data) {
                if ($data->contests) {
                    array_push($contestID, $data->contests->id);
                }
            }
        }
        $contestID = array_unique($contestID);
        $contest = $this->contest::whereIn('id', $contestID)
            ->when(request('type'), function ($q) {
                $q->hasRequest(['type' => request('type')]);
                $q->with(['rounds', 'skills', 'userCapacityDone']);
            })
            ->when((!(request()->has('type'))  || request('type') == config('util.TYPE_CONTEST')), function ($q) {
                $q->withCount(['teams']);
            })
            ->search(request('q') ?? null, ['name', 'description'])
            ->status(request('status'))
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
            ->get();
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