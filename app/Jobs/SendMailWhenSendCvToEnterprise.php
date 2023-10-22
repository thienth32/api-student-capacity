<?php

namespace App\Jobs;

use App\Mail\MailSendCvToEnterprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailWhenSendCvToEnterprise implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $candidate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidate)
    {
        //
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->candidate->email)->send(new MailSendCvToEnterprise($this->candidate));
    }
}
