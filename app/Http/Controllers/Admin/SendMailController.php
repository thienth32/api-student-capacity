<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FinnalPass;
use App\Models\Contest;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    private function senMail($users = [], $data = [])
    {
        Mail::to('kopopi593@gmail.com')->cc($users)->send(new FinnalPass($data));
    }

    private function getUser($data)
    {
        $users = [];
        if (count($data->teams) > 0) {
            foreach ($data->teams as $team) {
                if (count($team->members) == 0) break;
                foreach ($team->members as $user) {
                    array_push($users, $user->email);
                }
            }
        }
        return $users;
    }

    public function sendMailRoundUser(Request $request, $id)
    {
        $request->validate(
            [
                'content' => 'required|min:2',
                'subject' => 'required|min:2',
            ],
            [
                'content.required' => 'Trường nội dung không được bỏ trống !',
                'content.min' => 'Trường nội dung không được nhỏ quá 2 ký tự !',
                'subject.min' => 'Trường tiêu đề không được nhỏ quá 2 ký tự !',
                'subject.required' => 'Trường tiêu đề không được bỏ trống !',
            ]
        );
        $round = Round::findOrFail($id)->load(['teams' => function ($q) {
            return $q->with([
                'members'
            ]);
        }]);
        $users = $this->getUser($round);
        $this->senMail(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
            ]
        );
        return redirect()->back();
    }

    public function sendMailContestUser(Request $request, $id)
    {
        $request->validate(
            [
                'content' => 'required|min:2',
                'subject' => 'required|min:2',
            ],
            [
                'content.required' => 'Trường nội dung không được bỏ trống !',
                'content.min' => 'Trường nội dung không được nhỏ quá 2 ký tự !',
                'subject.min' => 'Trường tiêu đề không được nhỏ quá 2 ký tự !',
                'subject.required' => 'Trường tiêu đề không được bỏ trống !',
            ]
        );
        $contest = Contest::findOrFail($id)->load([
            'teams' => function ($q) {
                return $q->with(['members']);
            }
        ]);
        $users = $this->getUser($contest);
        $this->senMail(
            array_unique($users),
            [
                'content' => $request->content,
                'subject' => $request->subject,
            ]
        );
        dd('Final');
        return redirect()->back();
    }
}