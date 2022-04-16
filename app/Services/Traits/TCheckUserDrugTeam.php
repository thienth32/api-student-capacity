<?php

namespace App\Services\Traits;

use App\Models\Contest;
use App\Models\Team;

trait TCheckUserDrugTeam
{
    public function  checkUserDrugTeam($contest_id, $user_id = [])
    {
        $arrUserPass = [];
        $arrUserNotPass = [];

        $contest = Contest::find($contest_id)->load('teams');
        foreach ($user_id as $userId) {
            $flag = false;

            foreach ($contest->teams as  $team) {
                foreach ($team->members as $user) {
                    if ($user->id == $userId) $flag = true;
                    // dump($user);
                }
            }
            if ($flag) {
                array_push($arrUserNotPass, $userId);
            } else {
                array_push($arrUserPass, $userId);
            }
        }
        return [
            'user-pass' => $arrUserPass,
            'user-not-pass' => $arrUserNotPass,
        ];
    }
}