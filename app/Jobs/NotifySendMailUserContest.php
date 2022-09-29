<?php

namespace App\Jobs;

use App\Mail\FinnalPass;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifySendMailUserContest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $users, public $data)
    {
    }

    public function handle()
    {
        foreach ($this->users as $user) {
            $userFind = User::where('email', $user)->first();
            $content = $this->repLaceParams([
                'name' => $userFind->name,
                'email' => $userFind->email,
            ], $this->data['content']);
            $subject = $this->repLaceParams([
                'name' => $userFind->name,
                'email' => $userFind->email,
            ], $this->data['subject']);
            Mail::to($userFind->email)
                ->cc($this->data['cc'])
                ->send(new FinnalPass([
                    'subject' => $subject,
                    'content' => $content,
                ]));
        }
    }

    public function repLaceParams($dataKey, $content)
    {
        $data = str_replace('$fullName', $dataKey['name'], $content);
        $data = str_replace('$email', $dataKey['email'], $data);
        $strName = explode(' ', $dataKey['name']);
        $data = str_replace('$name', $strName[count($strName) - 1], $data);
        return $data;
    }
}
