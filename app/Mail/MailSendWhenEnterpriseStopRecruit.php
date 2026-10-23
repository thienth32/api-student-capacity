<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSendWhenEnterpriseStopRecruit extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data  = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $candidate = $this->data->name;
        $codeRecruitment = $this->data->post->code_recruitment;
        $position = $this->data->post->position;
        $enterprise = $this->data->post->enterprise->name;

        return $this->subject('Thông báo doanh nghiệp đã tuyển đủ số lượng')
            ->view('emails.send-mail-to-candidate-when-stop-recruit', 
                [
                    'candidate' => $candidate,
                    'codeRecruitment' => $codeRecruitment,
                    'position' => $position,
                    'enterprise' => $enterprise
                ]);
    }
}
