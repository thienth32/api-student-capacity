<?php

namespace App\Services\Modules\MChallenge;

interface MChallengeInterface
{
    public function getChallenge($id, $with = []);

    public function getChallenges($data, $with = [], $flagApi = false);

    public function createChallenege($data);

    public function apiShow($id, $with = []);

    public function rating($id, $type_id);

    public function updateChallenge($id, $data);
}