<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Result;
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
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';

        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $query = Team::where('name', 'like', "%$keyword%");
        if ($contest != null) {
            $query->where('contest_id', $contest);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        return $query;
    }

    // Danh sách teams phía client
    public function Api_ListTeam(Request $request)
    {
        $pageNumber = $request->has('page') ? $request->page : 1;
        $pageSize = $request->has('pageSize') ? $request->pageSize : config('util.HOMEPAGE_ITEM_TEAM');
        $offset = ($pageNumber - 1) * $pageSize;
        $dataTeam = $this->getList($request)->skip($offset)->take($pageSize)->get();
        $dataTeam->load('members');
        return response()->json([
            'status' => true,
            'payload' => $dataTeam->toArray()
        ]);
    }
    //Api sách team
    public function ApiContestteams(Request $request)
    {

        $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        $dataTeam->load('members');
        $dataTeam->load('contest');

        return response()->json([
            'status' => true,
            'dataTeam' => $dataTeam->toArray()
        ]);
    }
    // Danh sách teams phía view1
    public function ListTeam(Request $request)
    {

        $Contest = Contest::orderBy('id', 'DESC')->get();
        $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        $dataTeam->load('members');

        //        foreach($dataTeam as $team){
        //             foreach($team->members as $member){
        // foreach( $member->user as $user){
        // var_dump($user->name);
        // }
        //             }
        //        }
        //        die;
        return view('teams.listTeam', [
            'dataTeam' => $dataTeam,
            'Contest' => $Contest
        ]);
    }


    //xóa Teams
    public function deleteTeam($id)
    {

        $dataResult = Result::where('team_id', $id)->get();
        // return $dataResult;
        foreach ($dataResult as $valueResult) {
            Result::destroy($valueResult->id);
        }
        if (Team::destroy($id)) {
            return response()->json([
                'status' => true,

            ]);
        } else {
            return response()->json([
                'status' => false,

            ]);
        }
    }
    // Add team phía client
    public function Api_addTeam(Request $request)
    {


        $listUser = $request->has('users') ? $request->users : [];
        //        foreach($listUser as $value){
        // var_dump($value['email']);
        //        }

        $validate = validator::make(
            $request->all(),
            [
                'name' => 'required',
                'image' => 'required|max:500',
            ],
            [
                'name.required' => 'Hãy nhập tên nhóm',
                'image.required' => 'Hãy Nhập ảnh nhóm',
                'image.max' => 'File ảnh quá lớn'
            ]
        );
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validate->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $team = Team::create($request->all());
            if ($team) {

                foreach ($listUser as $value) {

                    $user = User::where('email', $value['email'])->first();

                    Member::create([
                        'user_id' => $user->id,
                        'team_id' => $team->id
                    ]);
                }
                DB::commit();

                return response()->json([
                    'status' => true,
                    'payload' => $team,
                ]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'lỗi'
            ]);
        }
    }
}