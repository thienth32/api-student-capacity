<?php

namespace App\Services\Modules\MSampleCode;

interface MSampleCodeInterface
{
    public function createSampleCode($data);

    public function updateSampleCodeBuChallengeId($id, $data);
}