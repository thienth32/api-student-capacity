<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Round;
use App\Models\RoundTeam;
use App\Models\TakeExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Team;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TakeExamController extends Controller
{
    use TUploadImage, TResponse;
    private $contest;
    private $examModel;
    private $roundModel;
    private $teamModel;
    private $roundTeamModel;
    private $takeExamModel;


    public function __construct(
        Contest $contest,
        Round $round,
        Exam $exams,
        Team $team,
        RoundTeam $roundTeam,
        TakeExam $takeExam
    ) {
        $this->roundModel = $round;
        $this->contest = $contest;
        $this->examModel = $exams;
        $this->teamModel = $team;
        $this->roundTeamModel = $roundTeam;
        $this->takeExamModel = $takeExam;
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
        if ($validate->fails()) return $this->responseApi(true,  $validate->errors());

        $round = $this->roundModel::find($request->round_id)->load('teams');
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
                return $this->responseApi(false, 'Bạn không thuộc đội thi nào trong cuộc thi !!');

            $teamRound = $this->roundTeamModel::where('team_id', $team_id)
                ->where('round_id', $request->round_id)
                ->first();
            if (is_null($teamRound)) return $this->responseApi(false, 'Đội thi của bạn đang chờ phê duyệt !!');

            $takeExamCheck = $this->takeExamModel::where('round_team_id', $teamRound->id)->first();

            if (is_null($takeExamCheck)) {
                if (count($this->examModel::where('type', 0)->get()) == 0)
                    return $this->responseApi(false, "Đề thi chưa cập nhập !!");

                $exams = $this->examModel::where('type', 0)->get()->random()->id;
                if (is_null($exams))
                    return $this->responseApi(false, "Đề thi chưa cập nhập !!");


                $takeExamModel = $this->takeExamModel::create([
                    'exam_id' => $exams,
                    'round_team_id' => $teamRound->id,
                    'status' => config('util.TAKE_EXAM_STATUS_UNFINISHED'),
                ]);
                DB::commit();
                $takeExam = $this->takeExamModel::find($takeExamModel->id);
                if (Storage::disk('s3')->has($takeExam->exam->external_url)) {
                    $urlExam = Storage::disk('s3')->temporaryUrl($takeExam->exam->external_url, now()->addMinutes(5));
                } else {
                    $urlExam = $takeExam->exam->external_url;
                }
                return $this->responseApi(true, $takeExam, [
                    'exam' => $urlExam,
                    'status_take_exam' => $takeExam->status
                ]);
            }
            if (Storage::disk('s3')->has($takeExamCheck->exam->external_url)) {
                $urlExam = Storage::disk('s3')->temporaryUrl($takeExamCheck->exam->external_url, now()->addMinutes(5));
            } else {
                $urlExam = $takeExamCheck->exam->external_url;
            }
            return $this->responseApi(true, $takeExamCheck, ['exam' => $urlExam]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            return $this->responseApi(false, 'Lỗi hệ thống !!');
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
        if ($validate->fails())
            return $this->responseApi(true, $validate->errors());


        try {
            $takeExam = $this->takeExamModel::find($request->id);
            if (is_null($takeExam))
                return $this->responseApi(false, 'Không tồn tại trên hệ thống !!');

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
            return $this->responseApi(false, 'Nộp bài thành công !!');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('..--..');
            Log::info($th->getMessage());
            Log::info('..--..');
            return $this->responseApi(false, 'Lỗi hệ thống !!');
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
        if ($validate->fails())
            return $this->responseApi(true, $validate->errors());


        //        $teamCheck =  $this->teamModel::where(
        //            'contest_id',
        //            $request->contest_id
        //        )->where('name', trim($request->name))->get();
        //        if (count($teamCheck) > 0) return response()->json([
        //            'status' => false,
        //            'payload' => 'Tên đã tồn tại trong cuộc thi !!'
        //        ]);

        $round = $this->roundModel::find($request->round_id);
        if (is_null($round)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
        $exam = $this->examModel::where('round_id', $request->round_id)->inRandomOrder()->first();
        if (is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');

        $exam->load(['questions' => function ($q) {
            return $q->with([
                'answers' => function ($q) {
                    return $q->select(['id', 'content', 'question_id']);
                }
            ]);
        }]);
        return $this->responseApi(true, $exam);
    }
}