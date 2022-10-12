<?php

namespace App\Services\Modules\MChallenge;

interface MChallengeInterface
{
    public function getChallenge($id, $with = []);

    public function getChallenges($data, $with = []);

    public function createChallenege($data);

    public function apiShow($id, $with = []);
}