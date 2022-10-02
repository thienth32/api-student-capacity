<?php

namespace App\Console\Commands;

use App\Services\Modules\MContest\MContestInterface;
use Illuminate\Console\Command;

class EndContestTask extends Command
{
    protected $signature = 'contest:end';

    protected $description = 'End contest time register dealine ';

    public function handle()
    {
        app(MContestInterface::class)->endContestOutDateRegisterDealine();
        return 0;
    }
}