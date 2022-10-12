<?php

namespace App\Services\Modules\MChallenge;

use App\Models\Challenge as ModelsChallenge;

class Challenge implements MChallengeInterface
{
    public function __construct(private ModelsChallenge $model)
    {
    }
    public function getChallenge($id, $with = [])
    {
        return $this->model::whereId($id)->with($with)->first();
    }
    public function getChallenges($data, $with = [])
    {
        return $this->model::with($with)->paginate($data['limit'] ?? 10);
    }
}