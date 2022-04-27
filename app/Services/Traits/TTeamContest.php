<?php

namespace App\Services\Traits;

use App\Models\Team;
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
                    'name' => 'required|unique:teams|max:255',
                    'image' => 'required|max:10000',
                    'contest_id' => 'required|numeric',
                ],
                [
                    'name.required' => 'Chưa nhập trường này !',
                    'name.max' => 'Độ dài kí tự không phù hợp !',
                    'name.unique' => 'Tên đã tồn tại !',
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
                    'name' => 'required|unique:teams|max:255',
                    'image' => 'required|max:10000',
                ],
                [
                    'name.required' => 'Chưa nhập trường này !',
                    'name.max' => 'Độ dài kí tự không phù hợp !',
                    'name.unique' => 'Tên đã tồn tại !',
                    'image.required' => 'Chưa nhập trường này !',
                    'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                ]
            );
        }
        if ($validator->fails()) {
            if (!($request->has('user_id'))) {
                return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội !!')->withInput($request->input());
            } else {
                return redirect()->back()->withErrors($validator)->withInput($request->input());
            }
        }
        DB::beginTransaction();
        try {
            $result = $this->checkUserDrugTeam(($contest_id == null ? $request->contest_id : $contest_id), $request->user_id);
            $team = new Team();
            if ($request->has('image')) {
                $fileImage =  $request->file('image');
                $image = $this->uploadFile($fileImage);
                $team->image = $image;
            }
            $team->name = $request->name;
            $team->contest_id = ($contest_id == null ? $request->contest_id : $contest_id);
            $team->save();
            $team->members()->syncWithoutDetaching($result['user-pass']);
            DB::commit();
            return $backViewSuccess;
        } catch (Exception $ex) {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($fileImage)) Storage::disk('google')->delete($filename);
            }
            Db::rollBack();
            return $backViewFailure;
        }
    }

    function editTeamContest($request, $id_team, $contest_id = null, $backViewSuccess, $backViewFailure)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:teams,name,' . $id_team . '|max:255',
                'image' => 'mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'name.unique' => 'Tên đã tồn tại !',
                'name.mimes' => 'Sai định dạng ảnh !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if ($validator->fails()) {
            if (!($request->has('user_id'))) {
                return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội !!')->withInput($request->input());
            } else {
                return redirect()->back()->withErrors($validator)->withInput($request->input());
            }
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
                $user_id = $result['user-pass'];
                $team->users()->sync($user_id);
                $team->name = $request->name;
                $team->contest_id = ($contest_id == null ? $request->contest_id : $contest_id);
                $team->save();
                Db::commit();

                return $backViewSuccess;
            }
        } catch (Exception $ex) {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($fileImage)) Storage::disk('google')->delete($filename);
            }
            Db::rollBack();
            return $backViewFailure;
        }
    }
}