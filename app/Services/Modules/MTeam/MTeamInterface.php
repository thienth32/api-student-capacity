<?php

namespace App\Services\Modules\MTeam;

interface MTeamInterface
{
    public function getTotalTeamActive();

    public function getTeamByContestId($id);
}