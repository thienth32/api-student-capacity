<?php

namespace App\Services\Modules\MResultCapacityDetail;

interface MResultCapacityDetailInterface
{

    public function create($data = []);

    public function getHistoryByResultCapacityId($id);
}