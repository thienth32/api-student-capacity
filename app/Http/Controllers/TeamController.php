<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Result;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $query = Team::where('contest_id', $contest)->where('name', 'like', "%$keyword%");
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
        $pageSize = $request->has('pageSize') ? $request->pageSize : config('util.HOMEPAGE_ITEM_AMOUNT');
        $offset = ($pageNumber - 1) * $pageSize;
        $dataTeam = $this->getList($request)->skip($offset)->take($pageSize)->get();
        $dataTeam->load('members');
        return response()->json([
            'status' => true,
            'payload' => $dataTeam->toArray()
        ]);
    }

    // Danh sách teams phía view
    public function ListTeam(Request $request)
    {

        $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        $dataTeam->load('members');
        return view('', ['payload' => $dataTeam]);
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
            return view('', ['status' => true]);
        } else {
            return view('', ['status' => false]);
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
