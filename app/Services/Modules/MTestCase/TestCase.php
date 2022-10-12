<?php

namespace App\Services\Modules\MTestCase;

use App\Models\TestCase as ModelsTestCase;

class TestCase implements MTestCaseInterfave
{
    public function __construct(private ModelsTestCase $model)
    {
    }

    public function createTestCase($data)
    {
        $data = $this->model::create($data);
        return $data;
    }
}