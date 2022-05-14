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
use Illuminate\Support\Facades\Storage;
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
                    if ($user->id == $user_id) {
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
            $takeExamCheck = TakeExams::where('round_team_id', $teamRound->id)->first();
            // dd($takeExamCheck);
            if (is_null($takeExamCheck)) {
                $exams = Exams::all()->random()->id;
                if (is_null($exams)) return response()->json([
                    'status' => false,
                    'payload' => "Đề thi chưa cập nhập !!"
                ]);
                $takeExamModel = TakeExams::create([
                    'exam_id' => $exams,
                    'round_team_id' => $teamRound->id,
                    'status' => config('util.TAKE_EXAM_STATUS_UNFINISHED')
                ]);
                DB::commit();
                $takeExam = TakeExams::find($takeExamModel->id);
                // dd($takeExam);
                if (Storage::disk('s3')->has($takeExam->exam->external_url)) {
                    # code...
                    $urlExam = Storage::disk('s3')->temporaryUrl($takeExam->exam->external_url, now()->addMinutes(5));
                } else {
                    $urlExam = $takeExam->exam->external_url;
                }
                return response()->json([
                    'status' => true,
                    'payload' => $takeExam,
                    'exam' => $urlExam
                ]);
            }
            if (Storage::disk('s3')->has($takeExamCheck->exam->external_url)) {
                # code...
                $urlExam = Storage::disk('s3')->temporaryUrl($takeExamCheck->exam->external_url, now()->addMinutes(5));
            } else {
                $urlExam = $takeExamCheck->exam->external_url;
            }
            return response()->json([
                'status' => true,
                'payload' => $takeExamCheck,
                'exam' => $urlExam
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            dd($th);
        }
    }
    public function takeExamStudentSubmit(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'result_url' => 'url',
                'file_url' => 'file|mimes:zip,docx,word'
            ],
            [
                'result_url.url' => 'Sai định dạng !!!',
                'file_url.mimes' => 'Định dạng phải là : zip, docx, word !!!',
                'file_url.file' => 'Sai định dạng !!!',
                'id.required' => 'Thiếu id !',
            ]
        );
        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);

        try {
            $takeExam = TakeExams::find($request->id);
            if (is_null($takeExam)) return response()->json([
                'status' => false,
                'payload' => 'Không tồn tại trên hệ thống !!',
            ]);
            if ($request->hasFile('file_url')) {
                $fileUrl = $request->file('file_url');
                $filename = $this->uploadFile($fileUrl);
                $takeExam->file_url = $filename;
            }
            if (request('result_url')) {
                $takeExam->result_url = $request->result_url;
            }
            $takeExam->status = config('util.TAKE_EXAM_STATUS_COMPLETE');
            $takeExam->save();
            return response()->json([
                'status' => true,
                'payload' => 'Nộp bài thành công !!',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            dd($th);
        }
    }
}