<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exams;
use App\Models\Questions;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Round;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use TUploadImage;
    private $exam;

    public function __construct(Exams $exam)
    {
        $this->exam = $exam;
    }
    public function index($id_round)
    {
        $round = Round::find($id_round);
        $exams = $this->exam::where('round_id', $id_round)->orderByDesc('id')->get()->load('round');

        return view(
            'pages.round.detail.exam.index',
            [
                'round' => $round,
                'exams' => $exams
            ]
        );
    }

    public function create($id_round)
    {
        $round = Round::find($id_round);
        if (is_null($round)) return abort(404);
        return view(
            'pages.round.detail.exam.form-add',
            [
                'round' => $round,
            ]
        );
    }
    public function store(Request $request, $id_round)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|unique:exams,name|min:4|max:255',
                    'description' => 'required|min:4',
                    'max_ponit' => 'required|numeric|min:0|max:1000',
                    'ponit' => 'required|numeric|min:0|max:1000',
                    'external_url' => 'required|mimes:zip,docx,word|file|max:10000',
                ],
                [
                    'name.required' => 'Không bỏ trống trường tên !',
                    'name.unique' => 'Trường tên đã tồn tại trong hệ thống !',
                    'name.min' => 'Trường tên không nhỏ hơn 4 ký tự  !',
                    'description.min' => 'Trường mô tả không nhỏ hơn 4 ký tự  !',
                    'name.max' => 'Trường tên không lớn hơn 255 ký tự  !',
                    'description.required' => 'Không bỏ trống trường mô tả !',
                    'max_ponit.required' => 'Không bỏ trống trường thang điểm !',
                    'max_ponit.numeric' => 'Trường thang điểm phải thuộc dạng số !',
                    'max_ponit.min' => 'Trường thang điểm phải là số dương !',
                    'max_ponit.max' => 'Trường thang điểm không quá 1000 !',

                    'ponit.numeric' => 'Trường điểm phải thuộc dạng số !',
                    'ponit.max' => 'Trường điểm không quá 1000 !',
                    'ponit.min' => 'Trường điểm phải là số dương !',
                    'ponit.required' => 'Không bỏ trống trường điểm !',

                    'external_url.mimes' => 'Trường đề thi không đúng định dạng !',
                    'external_url.required' => 'Không bỏ trống trường đề bài !',
                    'external_url.file' => 'Trường đề bài phải là một file  !',
                    'external_url.max' => 'Trường đề bài dung lượng quá lớn !',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $round = Round::find($id_round);
            if (is_null($round)) return abort(404);
            $filename = $this->uploadFile($request->external_url);
            $dataCreate = array_merge($request->only([
                'name',
                'description',
                'max_ponit',
                'ponit',
            ]), [
                'round_id' => $id_round,
                'external_url' => $filename
            ]);

            $this->exam::create($dataCreate);
            return Redirect::route('admin.exam.index', ['id' => $id_round]);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return abort(404);
        }
    }



    public function destroy($id)
    {
        try {
            $exam = $this->exam::find($id);
            $exam->delete($id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function edit($id_round, $id)
    {

        $round = Round::find($id_round);
        if (is_null($round)) return abort(404);
        $exam = $this->exam::find($id);
        if (is_null($exam)) return abort(404);
        return view(
            'pages.round.detail.exam.form-edit',
            [
                'exam' => $exam,
                'round' => $round,
            ]
        );
    }
    public function update(Request $request, $id_round, $id)
    {
        $examModel = Exams::find($id);
        if (is_null($examModel)) return abort(404);
        $round = Round::find($id_round);
        if (is_null($round)) return abort(404);
        $validator = validator::make(
            $request->all(),
            [
                'name' => 'required|unique:exams,name|min:4|max:255',
                'description' => 'required|min:4',
                'max_ponit' => 'required|numeric|min:0|max:1000',
                'ponit' => 'required|numeric|min:0|max:1000',
                'external_url' => 'mimes:zip,docx,word|file|max:10000',
            ],
            [
                'name.required' => 'Không bỏ trống trường tên !',
                'name.unique' => 'Trường tên đã tồn tại trong hệ thống !',
                'name.min' => 'Trường tên không nhỏ hơn 4 ký tự  !',
                'description.min' => 'Trường mô tả không nhỏ hơn 4 ký tự  !',
                'name.max' => 'Trường tên không lớn hơn 255 ký tự  !',
                'description.required' => 'Không bỏ trống trường mô tả !',
                'max_ponit.required' => 'Không bỏ trống trường thang điểm !',
                'max_ponit.numeric' => 'Trường thang điểm phải thuộc dạng số !',
                'max_ponit.min' => 'Trường thang điểm phải là số dương !',
                'max_ponit.max' => 'Trường thang điểm không quá 1000 !',

                'ponit.numeric' => 'Trường điểm phải thuộc dạng số !',
                'ponit.max' => 'Trường điểm không quá 1000 !',
                'ponit.min' => 'Trường điểm phải là số dương !',
                'ponit.required' => 'Không bỏ trống trường điểm !',

                'external_url.mimes' => 'Trường đề thi không đúng định dạng !',
                'external_url.file' => 'Trường đề bài phải là một file  !',
                'external_url.max' => 'Trường đề bài dung lượng quá lớn !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {

            if ($request->has('external_url')) {
                $fileImage =  $request->file('external_url');
                $external_url = $this->uploadFile($fileImage, $examModel->external_url);
                $examModel->external_url = $external_url;
            }
            $examModel->name = $request->name;
            $examModel->description = $request->description;
            $examModel->max_ponit = $request->max_ponit;
            $examModel->ponit = $request->ponit;
            $examModel->round_id = $id_round;
            $examModel->save();
            DB::commit();
            return Redirect::route('admin.exam.index', ['id' => $id_round]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json([
                'status' => false,
                'payload' => $th
            ]);
        }
    }

    public function get_by_round($id)
    {
        try {
            $exams = Exams::where('round_id',$id)->where('type',1)->with(['questions' => function ($q) {
                return $q -> with('answers');
            }])->get();
            $questions = Questions::with([
                'answers'
            ])->take(10)->get();
            return response() -> json([
                'status' => true,
                'payload' => $exams,
                'question' => $questions
            ]);
        } catch (\Throwable $th) {
             return response() -> json([
                'status' => false,
                'payload' => 'Hệ thống đã xảy ra lỗi '
            ],404);
        }

    }

    public function showQuestionAnswerExams($id)
    {
        //  try {
            $exam = Exams::whereId($id)->where('type',1)->with(['questions' => function ($q) {
                return $q -> with('answers');
            }])->first();
            $questions = Questions::with([
                'answers','skill'
            ])->take(10)->get();
            return response() -> json([
                'status' => true,
                'payload' => $exam->questions,
                'question' => $questions
            ]);
        // } catch (\Throwable $th) {
        //      return response() -> json([
        //         'status' => false,
        //         'payload' => 'Hệ thống đã xảy ra lỗi '
        //     ],404);
        // }
    }
}