<?php

namespace App\Services\Modules\MTestCase;

interface MTestCaseInterfave
{
    public function createTestCase($data);

    public function updateTestCase($data);

    public function removeRecod($listIds, $challenge_id);
}