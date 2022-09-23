<?php

namespace App\Services\Modules\MKeyword;

interface MKeywordInterface
{
    public function getList($request);
    public function list();
    public function store($request);
    public function find($id);
}