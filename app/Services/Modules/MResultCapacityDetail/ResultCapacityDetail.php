<?php

namespace App\Services\Modules\MResultCapacityDetail;

use App\Models\ResultCapacityDetail as ModelsResultCapacityDetail;

class ResultCapacityDetail implements MResultCapacityDetailInterface
{
    public function __construct(
        private ModelsResultCapacityDetail $model
    ) {
    }
    public function create($data = [])
    {
        return $this->model::create($data);
    }
}