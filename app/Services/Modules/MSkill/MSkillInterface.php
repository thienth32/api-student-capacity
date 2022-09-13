<?php

namespace App\Services\Modules\MSkill;

use Illuminate\Http\Request;

interface MSkillInterface
{
    public function getList(Request $request);

    public function index(Request $request);

    public function find($id);

    public function store($request);

    public function update($request, $id);

    public function getAll();
}