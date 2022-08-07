<?php

namespace App\Services\Modules\MRoundTeam;

use App\Models\RoundTeam as ModelsRoundTeam;

class RoundTeam
{

    public function __construct(private ModelsRoundTeam $model)
    {
    }


    public function where($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with);
    }
}