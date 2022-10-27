<?php

namespace App\Services\Modules\MResultCode;

use App\Models\ResultCode as ModelsResultCode;

class ResultCode implements MResultCodeInterface
{
    public function __construct(private ModelsResultCode $model)
    {
    }

    public function getResultCode($id, $with = [])
    {
        return $this->model::whereId($id)->with($with)->first();
    }

    public function getResultCodeByAuthAndChallenge($challenge_id, $with = [])
    {
        return $this->model::where('user_id', auth('sanctum')->id())
            ->where("challenge_id", $challenge_id)
            ->with($with)
            ->first();
    }

    public function createResultCode($data)
    {
        $model = $this->model->create($data);
        return $model;
    }

    public function updateResultCode($model, $data)
    {
        $data = $model->update($data);
        return $data;
    }
}