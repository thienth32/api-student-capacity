<?php

namespace App\Services\Modules\MRoundTeam;

use App\Models\RoundTeam as ModelsRoundTeam;

interface MRoundTeamInterface
{
    public function where($param = [], $with = []);

    public function getRoundTeamByRoundId($id, $with);
}