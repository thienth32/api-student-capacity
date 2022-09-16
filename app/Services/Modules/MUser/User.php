<?php

namespace App\Services\Modules\MUser;

use App\Models\Contest;
use App\Models\User as ModelsUser;

class User implements MUserInterface
{
    public function __construct(
        private  ModelsUser $user,
        private Contest $contest
    ) {
    }

    public function contestJoined()
    {
        $contestID = [];
        $user_id = auth('sanctum')->user()->id;
        $user = $this->user::find($user_id)->load('teams');
        foreach ($user->teams as $team) {
            if ($team->contest) {
                array_push($contestID, $team->contest->id);
            }
        }
        $contest = $this->contest::whereIn('id', $contestID)
            ->when(request('type'), function ($q) {
                $q->hasRequest(['type' => request('type')]);
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