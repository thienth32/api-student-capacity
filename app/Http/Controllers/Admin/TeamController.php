<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use TUploadImage;
    public function create()
    {
        $contests = Contest::all();
        return view('pages.team.form-add', compact('contests'));
    }
    public function store(Request $request)
    {

        // dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'required|max:10000',
                'contest_id' => 'required|numeric',
                "*.user_id" => 'required',
            ],
            [
                "*.user_id" => 'Chưa có thành viên trong đội !',

                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'image.required' => 'Chưa nhập trường này !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $team = new Team();
            // if ($request->has('image')) {
            //     $fileImage =  $request->file('image');
            //     $image = $this->uploadFile($fileImage);
            // $team->image = $image;
            $team->image = 'dsfidsifsdofisd';
            // }
            $user_id = $request->user_id;
            $team->name = $request->name;
            $team->contest_id = $request->contest_id;
            $team->save();
            $team->members()->sync($user_id);
            Db::commit();

            return redirect()->route('admin.round.list');
        } catch (Exception $ex) {
            Db::rollBack();
            dd($ex);
        }
    }

    public function edit($id)
    {
        $userArray = [];
        $users = User::all();
        $contests = Contest::all();
        $team = Team::find($id);
        foreach ($users as $user) {
            foreach ($team->members as $me) {
                if ($user->id == $me->id) {
                    array_push($userArray, [
                        'id_user' => $user->id,
                        'email_user' => $user->email
                    ]);
                }
            }
        }
        return view('pages.team.form-edit', compact('contests', 'team', 'userArray'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'max:10000',
                'contest_id' => 'required|numeric',
                "*.user_id" => 'required',
            ],
            [
                "*.user_id" => 'Chưa có thành viên trong đội !',
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $team = Team::find($id);
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
                $user_id = $request->user_id;
                $team->members()->sync($user_id);
                $team->name = $request->name;
                $team->contest_id = $request->contest_id;
                $team->save();
                Db::commit();

                return Redirect::back();
            }
        } catch (Exception $ex) {
            Db::rollBack();
            return response()->json([
                "payload" => $ex
            ], 500);
        }
    }
}