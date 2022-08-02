<?php

namespace App\Services\Modules\MRound;

interface MRoundInterface
{
    public function getList();

    public function index();

    public function apiIndex();

    public function store($request);
}
