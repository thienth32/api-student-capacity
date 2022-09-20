<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendMail\RequestSendMail;
use App\Jobs\NotifySendMailUserContest;
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
    // private function senMail($users = [], $data = [])
    // {
    //     foreach ($users as $user) {
    //         $userFind = $this->user::where('email', $user)->first();
    //         $content = $this->repLaceParams([
    //             'name' => $userFind->name,
    //             'email' => $userFind->email,
    //         ], $data['content']);
    //         $subject = $this->repLaceParams([
    //             'name' => $userFind->name,
    //             'email' => $userFind->email,
    //         ], $data['subject']);

    //         $this->mail::to($userFind->email)
    //             ->cc(isset($data['cc']) ? $data['cc'] : [])
    //             ->send(new FinnalPass([
    //                 'subject' => $subject,
    //                 'content' => $content,
    //             ]));
    //     }
    // }

    // public function repLaceParams($dataKey, $content)
    // {
    //     $data = str_replace('$name', $dataKey['name'], $content);
    //     $data = str_replace('$email', $dataKey['email'], $data);
    //     return $data;
    // }

    public function sendMailRoundUser(RequestSendMail $request, $id)
    {
        if (!$request->has('users')) return redirect()->back()->withErrors(['users' => 'Tài khoản nhận mail không thể bỏ trống !'])->withInput($request->input());
        $users = $request->users;
        $cc = isset($request->cc) ? explode(",", $request->cc) : [];
        dispatch(new NotifySendMailUserContest(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
                'cc' => $cc
            ]
        ));
        return redirect()->back()->with('success', 'Gửi mail thành công ');
    }

    public function sendMailContestUser(RequestSendMail $request, $id)
    {
        if (!$request->has('users')) return redirect()->back()->withErrors(['users' => 'Tài khoản nhận mail không thể bỏ trống !'])->withInput($request->input());
        $users = $request->users;
        $cc = isset($request->cc) ? explode(",", $request->cc) : [];
        dispatch(new NotifySendMailUserContest(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
                'cc' => $cc
            ]
        ));
        return redirect()->back()->with('success', 'Gửi mail thành công ');
    }
}