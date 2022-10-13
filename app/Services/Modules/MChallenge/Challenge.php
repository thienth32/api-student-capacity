<?php

namespace App\Services\Modules\MChallenge;

use App\Models\Challenge as ModelsChallenge;
use App\Models\ResultCode;

class Challenge implements MChallengeInterface
{
    public function __construct(private ModelsChallenge $model, private ResultCode $resultCode)
    {
    }

    public function getChallenge($id, $with = [])
    {
        return $this->model::whereId($id)->with($with)->first();
    }

    public function getChallenges($data, $with = [], $flagApi = false)
    {
        return $this->model::when(
            $flagApi,
            function ($q) {
                return $q->where('status', 1);
            }
        )
            ->with($with)
            ->latest()
            ->paginate($data['limit'] ?? 10);
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

    public function rating($id, $type_id)
    {
        $result = $this->resultCode::where('challenge_id', $id)
            ->where('code_language_id', $type_id)
            ->orderBy('point', 'desc')
            ->get();
        return $result;
    }

    public function updateStatus($id, $status)
    {
        return $this->model::find($id)->update(['status' => $status]);
    }
}