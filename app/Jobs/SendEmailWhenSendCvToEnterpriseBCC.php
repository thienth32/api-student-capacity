<?php

namespace App\Jobs;

use App\Mail\MailToCandidatesWhenSendCvToEnterpriseBCC;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailWhenSendCvToEnterpriseBCC implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidates;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidates)
    {
        //
        $this->candidates = $candidates;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $emailTo = $this->candidates->shift();
        Mail::to($emailTo)
            ->bcc($this->candidates->pluck('email')->toArray())
            ->send(new MailToCandidatesWhenSendCvToEnterpriseBCC());
    }
}
