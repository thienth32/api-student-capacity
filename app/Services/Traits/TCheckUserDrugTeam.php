<?php

namespace App\Services\Traits;

use App\Models\Contest;
use App\Models\Team;

trait TCheckUserDrugTeam
{
    function  checkUserDrugTeam($contest_id, $user_id = [], $team_id = null)
    {
        $arrUserPass = [];
        $arrUserNotPass = [];
        $contest = Contest::find($contest_id)->load('teams');
        foreach ($user_id as $userId) {
            $flag = false;
            foreach ($contest->teams as  $team) {
                if (!is_null($team_id)) {
                    if (Team::find($team_id)->id != $team->id) {
                        foreach ($team->members as $user) {
                            if ($user->id == $userId) $flag = true;
                        }
                    }
                } else {
                    foreach ($team->members as $user) {
                        if ($user->id == $userId) $flag = true;
                    }
                }
            }
            if ($flag) {
                array_push($arrUserNotPass, $userId);
            } else {
                array_push($arrUserPass, $userId);
            }
        }
        return [
            'user-pass' => $arrUserPass, // được thêm
            'user-not-pass' => $arrUserNotPass, // ko dc thêm
        ];
    }
}