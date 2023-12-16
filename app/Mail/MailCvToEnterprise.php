<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailCvToEnterprise extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    public $cvs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post, $cvs)
    {
        $this->post = $post;
        $this->cvs = $cvs;
    }


    public function build()
    {
        $email = $this->subject('[CĐ FPT] GỬI CV ỨNG TUYỂN VỊ TRÍ ' . $this->post->position)
            ->view('emails.cv-to-enterprise', [
                'posts' => $this->post,
            ]);
        foreach ($this->cvs as $cv) {
            $email->attach($cv['path'], [
                'as' => $cv['as'],
                'mime' => $cv['mime']
            ]);
        }
        return $email;
    }
}
