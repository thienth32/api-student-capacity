<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Services\Modules\MAnswer\Answer;
use App\Services\Modules\MContest\Contest;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\Question;
use App\Services\Modules\MResultCapacity\MResultCapacityInterface;
use App\Services\Modules\MResultCapacityDetail\MResultCapacityDetailInterface;
use App\Services\Modules\MRound\Round;
use App\Services\Modules\MRoundTeam\RoundTeam;
use App\Services\Modules\MTakeExam\TakeExam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TakeExamController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(
        private Round $round,
        private MExamInterface $exam,
        private Contest $contest,
        private  Team $team,
        private  RoundTeam $roundTeam,
        private  TakeExam $takeExam,
        private  MResultCapacityInterface $resultCapacity,
        private  Question $question,
        private Answer $answer,
        private MResultCapacityDetailInterface $resultCapacityDetail
    ) {
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
        $round = $this->round->find($request->round_id, ['teams']);
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
                return $this->responseApi(true, ['error' => 'Bạn không thuộc đội thi nào trong cuộc thi !!']);
            $teamRound = $this->roundTeam->where(['team_id' => $team_id, 'round_id' => $request->round_id])->first();
            if (is_null($teamRound)) return $this->responseApi(true, ['error' => 'Đội thi của bạn đang chờ phê duyệt !!']);
            $takeExamCheck = $this->takeExam->findBy(['round_team_id' => $teamRound->id], ['exam']);
            if (is_null($takeExamCheck)) {
                if (count($this->exam->whereGet(['round_id' => $request->round_id, 'type' => 0])) == 0)
                    return $this->responseApi(true, ['error' => "Đề thi chưa cập nhập !!"]);
                $exams = $this->exam->whereGet(['round_id' => $request->round_id, 'type' => 0])->random()->id;
                if (is_null($exams))
                    return $this->responseApi(true, ['error' => "Đề thi chưa cập nhập !!"]);
                $takeExamModel = $this->takeExam->create([
                    'exam_id' => $exams,
                    'round_team_id' => $teamRound->id,
                    'status' => config('util.TAKE_EXAM_STATUS_UNFINISHED'),
                ]);
                DB::commit();
                $takeExam = $this->takeExam->find($takeExamModel->id);
                return $this->responseApi(true, $takeExam, [
                    'exam' => $takeExam->exam->external_url,
                    'status_take_exam' => $takeExam->status
                ]);
            }
            return $this->responseApi(true, $takeExamCheck);
        } catch (\Throwable $th) {
            // dd($th);
            DB::rollBack();
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/v1/take-exam/student-submit",
     *     description="",
     *     tags={"TakeExam","Contest","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="id",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="result_url",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="file_url",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function takeExamStudentSubmit(Request $request, DB $dB)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required',
                'result_url' => 'url',
                'file_url' => 'file|mimes:zip,docx,word,rar,rtf'
            ],
            [
                'result_url.url' => 'Sai định dạng !!!',
                'file_url.mimes' => 'Định dạng phải là : zip, docx, word, rtf !!!',
                'file_url.file' => 'Sai định dạng !!!',
                'id.required' => 'Thiếu id !',
            ]
        );
        if ($validate->fails())
            return $this->responseApi(false, ['error' => $validate->errors()]);
        $dB::beginTransaction();
        try {
            $takeExam = $this->takeExam->find($request->id);
            if (is_null($takeExam))
                return $this->responseApi(false, 'Không tồn tại trên hệ thống !!');
            if ($takeExam->status == config('util.TAKE_EXAM_STATUS_COMPLETE') && empty($request->result_url) && empty($request->file_url)) {
                if (Storage::disk('s3')->has($takeExam->file_url ?? "Default")) Storage::disk('s3')->delete($takeExam->file_url);
                $takeExam->file_url = null;
                $takeExam->result_url = null;
                $takeExam->status = config('util.TAKE_EXAM_STATUS_UNFINISHED');
                $mesg = 'Hủy bài thành công !!';
            } else {
                if ($request->has('file_url')) {
                    $fileUrl = $request->file('file_url');
                    $filename = $this->uploadFile($fileUrl);
                    $takeExam->file_url = $filename;
                } else {
                    if (Storage::disk('s3')->has($takeExam->file_url ?? "Default")) Storage::disk('s3')->delete($takeExam->file_url);
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
                $mesg = 'Nộp bài thành công !!';
            }
            $takeExam->save();
            $dB::commit();
            return $this->responseApi(true, $mesg, ['takeExam' => $takeExam]);
        } catch (\Throwable $th) {
            $dB::rollBack();
            dump($th);
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }

    private function getContest($id, $type = 0)
    {
        try {
            $contest = $this->contestModel->whereId($id, $type);
            return $contest;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/v1/take-exam/check-student-capacity",
     *     description="",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="round_id",
     *                  ),
     *              
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function checkStudentCapacity(Request $request)
    {
        $user_id = auth('sanctum')->user()->id;
        $validate = Validator::make(
            $request->all(),
            [
                'round_id' => 'required|integer',
            ],
            [
                'round_id.required' => 'Chưa nhập trường này !',
                'round_id.integer' => 'Sai định dạng !',
            ]
        );
        if ($validate->fails())
            return $this->responseApi(true, $validate->errors());
        try {
            $round = $this->round->find($request->round_id);
            if (is_null($round)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $exam = $this->exam->whereGet(['round_id' => $request->round_id])->pluck('id');
            if (is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $resultCapacity = $this->resultCapacity->whereInExamUser($exam, $user_id);
            if ($resultCapacity) {
                if ($resultCapacity->status == config('util.STATUS_RESULT_CAPACITY_DOING')) {
                    return $this->responseApi(true, config('util.STATUS_RESULT_CAPACITY_DOING'), ['message' => "Đang làm !!"]);
                } else {
                    return $this->responseApi(true, config('util.STATUS_RESULT_CAPACITY_DONE'), ['result' => $resultCapacity, 'message' => "Đã làm !!"]);
                }
            } else {
                return $this->responseApi(false, "Chưa làm !!");
            }
        } catch (\Throwable $th) {
            // dd($th);
            return $this->responseApi(false, 'Lỗi hệ thống !!');
        }
    }


    /**
     * 
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity",
     *     description="Trả về đề bài test năng lực , nếu lần đầu làm sẽ tạo bản ghi mới với trạng thái là đang làm  , nếu đang làm dở sẽ trả vè bài làm trước đó ",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="round_id",
     *                  ),
     *              
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */

    public function takeExamStudentCapacity(Request $request, DB $dB)
    {
        $user_id = auth('sanctum')->user()->id;
        $validate = Validator::make(
            $request->all(),
            [
                'round_id' => 'required|integer',
            ],
            [
                'round_id.required' => 'Chưa nhập trường này !',
                'round_id.integer' => 'Sai định dạng !',
            ]
        );
        if ($validate->fails())
            return $this->responseApi(true, $validate->errors());
        $dB::beginTransaction();
        try {
            $round = $this->round->find($request->round_id);
            if (is_null($round)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $exam = $this->exam->whereGet(['round_id' => $request->round_id])->pluck('id');
            if (is_null($exam)) return $this->responseApi(false, 'Lỗi truy cập hệ thống !!');
            $resultCapacity = $this->resultCapacity->whereInExamUser($exam, $user_id);
            if ($resultCapacity) {
                $exam = $this->exam->find($resultCapacity->exam_id);
            } else {
                $exam = $this->exam->where(['round_id' => $request->round_id])->inRandomOrder()->first();
                $resultCapacityNew =  $this->resultCapacity->create([
                    'scores' => 0,
                    'status' => config('util.STATUS_RESULT_CAPACITY_DOING'),
                    'exam_id' => $exam->id,
                    'user_id' => $user_id,
                    'type' => $exam->type
                ]);
            }
            $exam->load(['questions' => function ($q) {
                return $q->with([
                    'answers' => function ($q) {
                        return $q->select(['id', 'content', 'question_id']);
                    }
                ]);
            }]);
            $dB::commit();
            if ($resultCapacity) {
                return $this->responseApi(true, $exam, ['exam_at' => $resultCapacity->created_at]);
            } else {
                return $this->responseApi(true, $exam, ['exam_at' => $resultCapacityNew->created_at]);
            }
        } catch (\Throwable $th) {
            $dB::rollBack();
            return $this->responseApi(false, 'Lỗi hệ thống !!');
            // dd($th);
        }
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity-submit",
     *     description="",
     *     tags={"TakeExam","Capacity","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="string",
     *                      property="exam_id",
     *                  ),
     *                   @OA\Property(
     *                      type="string",
     *                      property="data",
     *                  ),
     *              
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function takeExamStudentCapacitySubmit(Request $request, DB $db)
    {
        $falseAnswer = 0;
        $trueAnswer = 0;
        $score = 0;
        $user_id = auth('sanctum')->user()->id;
        $exam = $this->exam->findById($request->exam_id, ['questions'], ['max_ponit', 'ponit'], false);
        $score_one_question = $exam->max_ponit / $exam->questions_count;
        $donotAnswer = $exam->questions_count - count($request->data);
        foreach ($request->data as $key => $data) {
            if ($data['type'] == 0) {
                if ($data['answerId'] == null) {
                    $donotAnswer += 1;
                } else {
                    $answer = $this->answer->findById(
                        $data['answerId'],
                        [
                            'question_id' => $data['questionId'],
                            'is_correct' => config('util.ANSWER_TRUE'),
                        ]
                    );
                    if ($answer && $data['answerId'] === $answer->id) {
                        $score += $score_one_question;
                        $trueAnswer += 1;
                    } else {
                        $falseAnswer += 1;
                    }
                }
            } else {
                if (count($data['answerIds']) > 0 && count($data['answerIds']) <= 1) {
                    $falseAnswer += 1;
                } else if (count($data['answerIds']) <= 0) {
                    $donotAnswer += 1;
                } else {
                    $answer = $this->answer->whereInId(
                        $data['answerIds'],
                        [
                            'question_id' => $data['questionId'],
                            'is_correct' => config('util.ANSWER_TRUE'),
                        ]
                    );
                    if (count($data['answerIds']) === count($answer)) {
                        $score += $score_one_question;
                        $trueAnswer += 1;
                    } else {
                        $falseAnswer += 1;
                    }
                }
            }
        }
        $resultCapacity =  $this->resultCapacity->findByUserExam($user_id, $request->exam_id);
        $db::beginTransaction();
        try {
            $resultCapacity->update([
                'scores' => $score,
                'status' => config('util.STATUS_RESULT_CAPACITY_DONE'),
                'donot_answer' => $donotAnswer,
                'false_answer' => $falseAnswer,
                'true_answer' => $trueAnswer,
            ]);
            foreach ($request->data as $data) {
                if ($data['type'] == 0) {
                    $this->resultCapacityDetail->create([
                        'result_capacity_id' => $resultCapacity->id,
                        'question_id' => $data['questionId'],
                        'answer_id' => $data['answerId'],
                    ]);
                } else {
                    foreach ($data['answerIds'] as  $dataAns) {
                        $this->resultCapacityDetail->create([
                            'result_capacity_id' => $resultCapacity->id,
                            'question_id' => $data['questionId'],
                            'answer_id' => $dataAns,
                        ]);
                    }
                }
            }
            $db::commit();
            return $this->responseApi(
                true,
                $resultCapacity,
                [
                    'exam' => $exam,
                    'score' => $score,
                    'donotAnswer' => $donotAnswer,
                    'falseAnswer' => $falseAnswer,
                    'trueAnswer' => $trueAnswer
                ]
            );
        } catch (\Throwable $th) {
            $db::rollBack();
            dd($th);
        }
    }


    /**
     * 
     * @OA\Post(
     *     path="/api/v1/take-exam/student-capacity-history",
     *     description="",
     *     tags={"TakeExam","TakeExamHistory","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="result_capacity_id",
     *                  ),
     *                  
     *              
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function takeExamStudentCapacityHistory(Request $request)
    {
        $resultCapacity =  $this->resultCapacity->where(['id' => $request->result_capacity_id]);
        $exam = $this->exam->find($resultCapacity->exam_id);
        $exam->load([
            'questions' => function ($q) use ($resultCapacity) {
                return $q->with([
                    'answers',
                    'resultCapacityDetail' => function ($q)  use ($resultCapacity) {
                        return $q
                            ->where('result_capacity_id', $resultCapacity->id);
                        // ->selectRaw('result_capacity_detail.answer_id as answer_id, question_id')
                        // ->groupBy('question_id');
                    }
                ]);
            }
        ]);
        return $this->responseApi(true, $resultCapacity, ['exam' => $exam]);
    }
}