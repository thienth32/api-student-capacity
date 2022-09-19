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
        if (empty(request('type'))  || request('type') == config('util.TYPE_CONTEST')) {
            foreach ($user->teams as $team) {
                if ($team->contest) {
                    array_push($contestID, $team->contest->id);
                }
            }
        } else {
            $resultCapacity = $this->resultCapacity::where('user_id', $user_id)
                ->with('contests')->get();
            foreach ($resultCapacity as $data) {
                array_push($contestID, $data->contests->id);
            }
        }
        $contestID = array_unique($contestID);
        // dd($contestID);
        $contest = $this->contest::whereIn('id', $contestID)
            ->when(request('type'), function ($q) {
                $q->hasRequest(['type' => request('type')]);
                $q->with(['rounds', 'skills', 'userCapacityDone']);
            })
            ->search(request('q') ?? null, ['name', 'description'])
            ->status(request('status'))
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
            ->paginate(request('limit') ?? 5);
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