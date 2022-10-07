<?php

namespace App\Console\Commands;

use App\Models\JobQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class WorkJob extends Command
{
    protected $signature = 'work:job';

    protected $description = 'Work job shedule';

    public function handle()
    {
        $data = JobQueue::where('status', 1)->where('on_date', "<", date("Y-m-d H:i:s"))->get();
        foreach ($data as $value) {
            $queue = $value->token_queue;
            Artisan::call("queue:work", [
                "--queue" => $queue,
                "--stop-when-empty" => true,
            ]);
        }
        return 0;
    }
}