<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMail\RequestSendMail;
use App\Mail\FinnalPass;
use App\Models\Contest;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    private $user;
    private $mail;
    public function __construct(User $user, Mail $mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }
    private function senMail($users = [], $data = [])
    {
        // Mail::to('kopopi593@gmail.com')->cc($users)->send(new FinnalPass($data));
        foreach ($users as $user) {
            $contentNew = '';
            $userFind = $this->user::where('email', $user)->first();
            $contentNew = str_replace('$name', $userFind->name, $data['content']);
            $contentNew = str_replace('$email', $userFind->email, $contentNew);
            $this->mail::to($userFind->email)->send(new FinnalPass([
                'subject' => $data['subject'],
                'content' => $contentNew,
            ]));
        }
    }

    public function sendMailRoundUser(RequestSendMail $request, $id)
    {

        if (!$request->has('users')) return redirect()->back()->withErrors(['users' => 'Tài khoản nhận mail không thể bỏ trống !'])->withInput($request->input());
        $users = $request->users;
        $this->senMail(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
            ]
        );
        return redirect()->back()->with('success', 'Gửi mail thành công ');
    }

    public function sendMailContestUser(RequestSendMail $request, $id)
    {
        if (!$request->has('users')) return redirect()->back()->withErrors(['users' => 'Tài khoản nhận mail không thể bỏ trống !'])->withInput($request->input());
        $users = $request->users;
        $this->senMail(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
            ]
        );
        return redirect()->back()->with('success', 'Gửi mail thành công ');
    }
}
