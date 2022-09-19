<?php

namespace App\Services\Modules\MRoundTeam;

use App\Models\RoundTeam as ModelsRoundTeam;

class RoundTeam implements MRoundTeamInterface
{

    public function __construct(private ModelsRoundTeam $model)
    {
    }


    public function where($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with);
    }

    public function getRoundTeamByRoundId($id, $with = [])
    {
        return $this->model::where('round_id', $id)
            ->with($with)
            ->get();
    }
}