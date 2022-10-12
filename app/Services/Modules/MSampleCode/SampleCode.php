<?php

namespace App\Services\Modules\MSampleCode;

use App\Models\SampleChallenge;

class SampleCode implements MSampleCodeInterface
{
    public function __construct(private SampleChallenge $model)
    {
    }

    public function createSampleCode($data)
    {
        $data = $this->model::create($data);
        return $data;
    }
}