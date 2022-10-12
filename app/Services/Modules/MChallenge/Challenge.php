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
        return $this->model::with($with)->latest()->paginate($data['limit'] ?? 10);
    }

    public function createChallenege($data)
    {
        $data = $this->model::create($data);
        return $data;
    }

    public function apiShow($id, $with = [])
    {
        return $this->model::with($with)->whereId($id)->first();
    }
}