<?php

namespace App\Services\Modules\MRound;

interface MRoundInterface
{
    public function getList();

    public function index();

    public function apiIndex();

    public function store($request);

    public function find($id);

    public function getTeamByRoundId($id, $flagGetAll = false);

    public function where($param);

    public function whereIn($key, $val = []);

    public function results($id);
}