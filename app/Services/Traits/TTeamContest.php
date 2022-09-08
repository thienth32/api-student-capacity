<?php

namespace App\Services\Traits;

use App\Models\Contest;
use App\Models\Member;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


trait TTeamContest
{

    use TCheckUserDrugTeam;
    function addTeamContest($request, $contest_id = null, $backViewSuccess, $backViewFailure)
    {
        if ($contest_id == null) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'image' => 'required|max:10000',
                    'contest_id' => 'required|numeric',
                ],
                [
                    'name.required' => 'Chưa nhập trường này !',
                    'name.max' => 'Độ dài kí tự không phù hợp !',
                    'image.required' => 'Chưa nhập trường này !',
                    'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                    'contest_id.required' => 'Chưa nhập trường này !',
                    'contest_id.numeric' => 'Sai định dạng !',
                ]
            );
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255',
                    'image' => 'required|max:10000',
                ],
                [
                    'name.required' => 'Chưa nhập trường này !',
                    'name.max' => 'Độ dài kí tự không phù hợp !',
                    'image.required' => 'Chưa nhập trường này !',
                    'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                ]
            );
        }
        if (isset($request->user_id)) {
            $userArr = User::select('id as id_user', 'name as name_user', 'email as email_user')->whereIn('id', $request->user_id)->get();
        }
        if ($validator->fails() || !isset($request->user_id)) {
            if (!isset($request->user_id)) {
                return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội !!')->withInput($request->input());
            } else {
                return redirect()->back()->with('userArray', $userArr)->withErrors($validator)->withInput($request->input());
            }
        }
        $teamCheck = Team::where(
            'contest_id',
            ($contest_id == null ? $request->contest_id : $contest_id)
        )->where('name', trim($request->name))->get();
        if (count($teamCheck) > 0) return
            redirect()
            ->back()
            ->with('errorName', 'Tên đội đã tồn tại trong cuộc thi !!')
            ->with('userArray', $userArr)
            ->withInput($request->input());
        // dd('Dừng');
        DB::beginTransaction();
        try {
            $member = [];
            $result = $this->checkUserDrugTeam(($contest_id == null ? $request->contest_id : $contest_id), $request->user_id);

            // foreach ($result['user-pass'] as $key => $userPass) {
            //     array_push($member, [
            //         $userPass,
            //         44,
            //         // 'bot' => $result['user-pass'][array_rand($result['user-pass'])],
            //     ]);
            // }
            // dump($member);
            // die;
            $team = new Team();
            if ($request->has('image')) {
                $fileImage =  $request->file('image');
                $image = $this->uploadFile($fileImage);
                $team->image = $image;
            }
            $team->name = $request->name;
            $team->contest_id = ($contest_id == null ? $request->contest_id : $contest_id);
            $team->save();
            foreach ($result['user-pass'] as $key => $userPass) {
                array_push($member, [
                    'user_id' => $userPass,
                    'team_id' => $team->id,
                    'bot' => (($userPass == $request->bot_user) ? 1 : null),
                ]);
            }
            Member::insert($member);
            DB::commit();
            return $backViewSuccess;
        } catch (Exception $ex) {
            Db::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('s3')->has($fileImage)) Storage::disk('s3')->delete($fileImage);
            }
            return $backViewFailure;
        }
    }

    function editTeamContest($request, $id_team, $contest_id = null, $backViewSuccess, $backViewFailure)
    {
        $member = [];
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',

                'image.mimes' => 'Sai định dạng ảnh !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if (isset($request->user_id)) {
            $userArr = User::select('id as id_user', 'name as name_user', 'email as email_user')->whereIn('id', $request->user_id)->get();
        }
        if ($validator->fails() || !isset($request->user_id)) {
            if (!isset($request->user_id)) {
                return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội !!')->withInput($request->input());
            } else {
                return redirect()->back()->with('userArray', $userArr)->withErrors($validator)->withInput($request->input());
            }
        }
        $teamChecks = Team::where(
            'contest_id',
            ($contest_id == null ? $request->contest_id : $contest_id)
        )->where('name', trim($request->name))->get();
        foreach ($teamChecks as $teamCheck) {
            if ($teamCheck->id != $id_team) return
                redirect()
                ->back()
                ->with('errorName', 'Tên này đã tồn tại trong cuộc thi !!')
                ->with('userArray', $userArr)
                ->withInput($request->input());
        }

        DB::beginTransaction();
        try {
            $result = $this->checkUserDrugTeam(($contest_id == null ? $request->contest_id : $contest_id), $request->user_id, $id_team ?? null);
            $team = Team::find($id_team);
            if (is_null($team)) {
                return response()->json([
                    "payload" => 'Không tồn tại trong cơ sở dữ liệu !'
                ], 500);
            } else {
                if ($request->has('image')) {
                    $fileImage =  $request->file('image');
                    $image = $this->uploadFile($fileImage, $team->image);
                    $team->image = $image;
                }
                // $user_id = $result['user-pass'];
                // $team->users()->sync($user_id);

                $team->name = $request->name;
                $team->contest_id = ($contest_id == null ? $request->contest_id : $contest_id);
                $team->save();
                $team->users()->detach();
                foreach ($result['user-pass'] as $key => $userPass) {
                    array_push($member, [
                        'user_id' => $userPass,
                        'team_id' => $team->id,
                        'bot' => (($userPass == $request->bot_user) ? 1 : null),
                    ]);
                }
                Member::insert($member);
                Db::commit();

                return $backViewSuccess;
            }
        } catch (Exception $ex) {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('s3')->has($fileImage)) Storage::disk('s3')->delete($fileImage);
            }
            Db::rollBack();
            dd($ex);
            return $backViewFailure;
        }
    }
}