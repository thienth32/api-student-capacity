<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exams;
use App\Models\Round;
use App\Models\RoundTeam;
use App\Models\TakeExams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TakeExamController extends Controller
{

    public function takeExamStudent(Request $request)
    {
        $checkUserTeam = false;
        $team_id = 0;
        $user_id = auth('sanctum')->user()->id;
        $validate = Validator::make(
            $request->all(),
            [
                'round_id' => 'required',
            ],
            [
                'round_id.required' => 'Chưa nhập trường này !',
            ]
        );
        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);
        $round = Round::find($request->round_id)->load('teams');

        DB::beginTransaction();
        try {
            foreach ($round->teams as $team) {
                foreach ($team->users as $user) {
                    // dump($user->toArray());
                    if ($user->id == $user_id) {
                        // dump($team->toArray());
                        $checkUserTeam = true;
                        $team_id = $team->id;
                    }
                }
            }
            if ($checkUserTeam == false)
                return response()->json([
                    'status' => false,
                    'payload' => 'Bạn không thuộc đội thi nào trong cuộc thi !!'
                ]);
            $teamRound = RoundTeam::where('team_id', $team_id)
                ->where('round_id', $request->round_id)
                ->first();
            if (is_null($teamRound)) return response()->json([
                'status' => false,
                'payload' => 'Đội thi của bạn chưa được phê duyệt để được vào vòng thi !!'
            ]);

            $takeExamCheck = TakeExams::where('round_team_id', $teamRound->team_id)->first();
            if (is_null($takeExamCheck)) {
                $exams = Exams::all()->random()->id;
                if (is_null($exams)) return response()->json([
                    'status' => false,
                    'payload' => "Đề thi chưa cập nhập !!"
                ]);
                $takeExamModel = TakeExams::create([
                    'exam_id' => $exams,
                    'round_team_id' => $teamRound->team_id,
                    'status' => config('util.TAKE_EXAM_STATUS_UNFINISHED')
                ]);
                return response()->json([
                    'status' => true,
                    'payload' => $takeExamModel
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'payload' => $takeExamCheck
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            dd($th);
        }
    }
}