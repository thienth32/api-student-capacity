<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Judge;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JudgeController extends Controller
{

    private $contest;
    private $user;
    public function __construct(Contest $contest, User $user)
    {
        $this->contest = $contest;
        $this->user = $user;
    }
    public function getJudgesContest($contest_id)
    {
        $contest = Contest::find($contest_id);
        $contest->load('judges');
        return view('pages.judges.judges-contest', compact('contest'));
    }

    public function attachJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->syncWithoutDetaching($request->user_id);
            return response()->json(['status' => true, 'payload' => 'Thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }
    public function syncJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->sync($request->user_id);
            return response()->json(['status' => true,  'payload' => 'Thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }

    public function detachJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->detach([$request->user_id]);
            return response()->json(['status' => true,  'payload' => 'Xóa thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }

    public function getJudgesRound($round_id)
    {
        $round = Round::find($round_id);
        $round->load(['judges' => function ($q) {
            return $q->with('user');
        }]);
        $round->load(['contest' => function ($q) {
            return $q->with('judges');
        }]);
        // dd($round->toArray());
        return view('pages.judges.judges-round', compact('round'));
    }

    private function getIdJudges($users)
    {
        $listId = [];
        foreach ($users as $user) {
            if ($judge = Judge::where('user_id', $user['pivot']['user_id'])->where('contest_id', $user['pivot']['contest_id'])->first()) {
                array_push($listId, $judge->id);
            }
        }
        return $listId;
    }

    public function attachRound(Request $request, $id)
    {

        try {
            DB::transaction(function () use ($request, $id, &$listId) {
                $round = Round::with(['judges'])->where('id', $id)->first();
                $round->judges()->syncWithoutDetaching($this->getIdJudges($request->users));
            });

            return response()->json(
                [
                    "status" => true,
                    "Success"
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "Không thể cập nhật !"
                ]
            );
        }
    }

    public function dettachRound(Request $request, $id)
    {
        try {
            $round = Round::with(['judges'])->where('id', $id)->first();
            $round->judges()->detach($request->users);

            return response()->json(
                [
                    "status" => true,
                    "Success"
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "Không thể cập nhật !"
                ]
            );
        }
    }
}
