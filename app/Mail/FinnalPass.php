<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinnalPass extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $subject = $this->data['subject'] ?? '';
        return $this->subject($subject)->view('emails.final-pass', ['data' => $this->data, 'subject' => $subject]);
    }
}