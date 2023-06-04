<?php

namespace App\Jobs;

use App\Mail\MailNoteCV;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailNoteCV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $candidate;
    public $post;
    public $content;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($candidate, $post, $content)
    {
        $this->candidate = $candidate;
        $this->post = $post;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->candidate->email)->send(new MailNoteCV($this->candidate, $this->post, $this->content));
    }
}
