<?php

namespace App\Jobs;

use App\Mail\FinnalPass;
use App\Models\JobQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $tokenQueue, public $mails, public $subject, public $content, public $cc = [])
    {
    }

    public function handle()
    {
        try {
            $to = [];
            $mails = explode(',', $this->mails);
            foreach ($mails as $key => $mail) {
                $to[$key]['name'] = explode('@', $mail)[0];
                $to[$key]['email'] = $mail;
            }

            Mail::to($to)
                ->cc($this->cc)
                ->send(new FinnalPass([
                    'subject' => $this->subject,
                    'content' => $this->content,
                ]));
            JobQueue::where('token_queue', $this->tokenQueue)->delete();
        } catch (\Throwable $th) {
            JobQueue::where('token_queue', $this->tokenQueue)
                ->update(['status' => 3, 'error' => 'Mail có mã : ' . $this->subject . ' lỗi ' . $th->getMessage() . $th->getLine() . $th->getFile()]);
        }
    }
}