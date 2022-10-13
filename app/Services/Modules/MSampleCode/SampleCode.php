<?php

namespace App\Services\Modules\MSampleCode;

use App\Models\SampleChallenge;
use Illuminate\Support\Facades\DB;

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

    public function updateSampleCodeBuChallengeId($id, $data)
    {
        DB::table('sample_challenge')->where('challenge_id', $id)->update($data);
    }
}