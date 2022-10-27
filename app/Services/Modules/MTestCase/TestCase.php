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
        if (isset($data['id_test_case'])) unset($data['id_test_case']);
        $data = $this->model::create($data);
        return $data;
    }

    public function updateTestCase($data)
    {
        if ($data['id_test_case'] != 0) {
            $model = $this->model::find($data['id_test_case']);
            unset($data['id_test_case']);
            $model->update($data);
        } else {
            unset($data['id_test_case']);
            $this->createTestCase($data);
        }
    }

    public function removeRecod($listIds, $challenge_id)
    {
        $modelRemove = $this->model::where('challenge_id', $challenge_id)->whereNotIn('id', $listIds)->get();
        foreach ($modelRemove as $model) {
            $model->delete();
        }
    }
}