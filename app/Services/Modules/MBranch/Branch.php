<?php

namespace App\Services\Modules\MBranch;

use App\Models\Contest;
use App\Models\ResultCapacity;
use App\Models\Branch as ModelsBranch;

class User implements MBranchInterface
{
    public function __construct(
        private  ModelsBranch $user,
        private ResultCapacity $resultCapacity
    ) {
    }

}
