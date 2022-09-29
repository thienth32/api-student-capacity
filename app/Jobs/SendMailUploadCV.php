<?php

namespace App\Jobs;

use App\Mail\MailUploadCV;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailUploadCV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $dataMail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataMail)
    {
        $this->dataMail = $dataMail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->dataMail->email)->send(new MailUploadCV($this->dataMail));
    }
}
