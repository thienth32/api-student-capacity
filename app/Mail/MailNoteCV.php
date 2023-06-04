<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNoteCV extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $candidate;
    public $post;
    public $content;
    public function __construct($candidate, $post, $content)
    {
        $this->candidate = $candidate;
        $this->post = $post;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Điều chỉnh thông tin ứng tuyển tại hệ thống Beecareer')
            ->view('emails.note-cv', [
                'content' => $this->content,
                'candidate' => $this->candidate,
                'post' => $this->post,
            ]);
    }
}
