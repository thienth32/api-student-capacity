<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait TLog
{
    public function log(Carbon $carbon,Log $log,$message)
    {
        $log::info('---- '.$carbon::now('Asia/Ho_Chi_Minh').' ---');
        $log::info($message);
        $log::info('---- '.$carbon::now('Asia/Ho_Chi_Minh').' ---');
    }
}
