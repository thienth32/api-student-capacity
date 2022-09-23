<?php

namespace App\Services\Modules\MTeam;

interface MTeamInterface
{
    public function getTotalTeamActive();

    public function getTeamByContestId($id);

    public function getTeamById($id, $with = []);

    public function getAllTeam($params = [], $with = []);

    public function updateTeam($id, $data);
    public function find($id);
}