<?php

namespace App\Services\Modules\MResultCode;

interface MResultCodeInterface
{
    public function getResultCode($id, $with = []);

    public function createResultCode($data);

    public function getResultCodeByAuthAndChallenge($challenge_id, $with = []);

    public function updateResultCode($model, $data);
}