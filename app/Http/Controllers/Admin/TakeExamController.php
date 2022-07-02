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
use App\Models\Contest;
use App\Models\Team;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TakeExamController extends Controller
{
    use TUploadImage;
    private $contest;
    private $examModel;
    private $roundModel;
    private $teamModel;


    public function __construct(Contest $contest, Round $round, Exams $exams, Team $team)
    {
        $this->roundModel = $round;
        $this->contest = $contest;
        $this->examModel = $exams;
        $this->teamModel = $team;
    }
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
                if ($team->users) {
                    foreach ($team->users as $user) {
                        if ($user->id == $user_id) {
                            $checkUserTeam = true;
                            $team_id = $team->id;
                        }
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
                'payload' => 'Đội thi của bạn đang chờ phê duyệt !!'
            ]);
            $takeExamCheck = TakeExams::where('round_team_id', $teamRound->id)->first();

            if (is_null($takeExamCheck)) {
                if (count(Exams::all()) == 0) return response()->json([
                    'status' => false,
                    'payload' => "Đề thi chưa cập nhập !!"
                ]);
                $exams = Exams::all()->random()->id;
                if (is_null($exams)) return response()->json([
                    'status' => false,
                    'payload' => "Đề thi chưa cập nhập !!"
                ]);
                $takeExamModel = new TakeExams();
                $takeExamModel->exam_id = $exams;
                $takeExamModel->round_team_id = $teamRound->id;
                $takeExamModel->status = config('util.TAKE_EXAM_STATUS_UNFINISHED');
                $takeExamModel->save();
                DB::commit();
                $takeExam = TakeExams::find($takeExamModel->id);
                if (Storage::disk('s3')->has($takeExam->exam->external_url)) {
                    $urlExam = Storage::disk('s3')->temporaryUrl($takeExam->exam->external_url, now()->addMinutes(5));
                } else {
                    $urlExam = $takeExam->exam->external_url;
                }
                return response()->json([
                    'status' => true,
                    'payload' => $takeExam,
                    'exam' => $urlExam,
                    'status_take_exam' => $takeExam->status
                ]);
            }
            if (Storage::disk('s3')->has($takeExamCheck->exam->external_url)) {
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
            return response()->json([
                'status' => false,
                'payload' => "Đang lỗi !!"
            ]);
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
            if ($request->has('file_url')) {
                $fileUrl = $request->file('file_url');
                $filename = $this->uploadFile($fileUrl);
                $takeExam->file_url = $filename;
            } else {
                if (Storage::disk('s3')->has($takeExam->file_url)) Storage::disk('s3')->delete($takeExam->file_url);
                $takeExam->file_url = null;
            }
            if (request('result_url')) {
                $takeExam->result_url = $request->result_url;
            } else {
                $takeExam->result_url = null;
            }
            if (!request('file_url') && !request('result_url')) {
                $takeExam->status = config('util.TAKE_EXAM_STATUS_UNFINISHED');
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
            return response()->json([
                'status' => false,
                'payload' => 'Lỗi hệ thống !!',
            ]);
        }
    }
    private function getContest($id, $type = 0)
    {
        try {
            $contest = $this->contest::where('id', $id)->where('type', $type);
            return $contest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function takeExamStudentCapacity(Request $request)
    {
        $user = auth('sanctum')->user();
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

//        $teamCheck =  $this->teamModel::where(
//            'contest_id',
//            $request->contest_id
//        )->where('name', trim($request->name))->get();
//        if (count($teamCheck) > 0) return response()->json([
//            'status' => false,
//            'payload' => 'Tên đã tồn tại trong cuộc thi !!'
//        ]);

        $round = $this->roundModel::find($request->round_id);
        if (is_null($round)) return response()->json([
            'status' => false,
            'payload' => 'Lỗi truy cập !!'
        ]);
        $exam = $this->examModel::where('round_id', $request->round_id)->inRandomOrder()->first();
        if (is_null($exam)) return response()->json([
            'status' => false,
            'payload' => 'Lỗi truy cập !!'
        ]);

        $exam->load(['questions' => function ($q) {
            return $q->with([
                'answers' => function ($q) {
                    return $q->select(['id', 'content', 'question_id']);
                }
            ]);
        }]);
        return response()->json([
            'status' => true,
            'payload' => $exam
        ]);
    }
}
