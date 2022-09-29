<?php

namespace App\Http\Controllers\Admin;

use App\Exports\QuestionsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\ImportQuestion;
use App\Imports\QuestionsImport;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Skill;
use App\Services\Modules\MQuestion\MQuestionInterface;
use App\Services\Modules\MSkill\MSkillInterface;
use App\Services\Traits\TStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    use TStatus;
    protected $skillModel;
    protected $questionModel;
    protected $answerModel;
    protected $examModel;
    public function __construct(
        Skill $skill,
        Question $question,
        Answer $answer,
        Exam $exam,
        private MSkillInterface $skillRepo,
        private MQuestionInterface $questionRepo
    ) {
        $this->skillModel = $skill;
        $this->questionModel = $question;
        $this->answerModel = $answer;
        $this->examModel = $exam;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $data = $this->questionModel::when(request()->has('question_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->status(request('status'))
            ->search(request('q') ?? null, ['content'])
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'questions')
            ->whenWhereHasRelationship(request('skill') ?? null, 'skills', 'skills.id', (request()->has('skill') && request('skill') == 0) ? true : false)
            // ->hasRequest(['rank' => request('level') ?? null, 'type' => request('type') ?? null]);
            ->when(request()->has('level'), function ($q) {
                $q->where('rank', request('level'));
            })
            ->when(request()->has('type'), function ($q) {
                $q->where('type', request('type'));
            });
        $data->with(['skills', 'answers']);
        return $data;
    }

    public function index()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 10))) return abort(404);

        // dd($questions);
        return view('pages.question.list', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    public function indexApi()
    {
        try {
            if (!($questions = $this->getList()->take(request('take') ?? 10)->get()))
                throw new \Exception("Question not found");
            return response()->json([
                'status' => true,
                'payload' => $questions,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Hệ thống đã xảy ra lỗi ! ' . $th->getMessage(),
            ], 404);
        }
    }

    public function create()
    {

        $skills = $this->skillModel::select('name', 'id')->get();
        return view(
            'pages.question.add',
            [
                'skills' => $skills
            ]
        );
    }

    public function store(Request $request)
    {
        // dump(count($request->answers));
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required',
                'type' => 'required|numeric',
                'status' => 'required|numeric',
                'rank' => 'required|numeric',
                'skill' => 'required',
                'skill.*' => 'required',
                'answers.*.content' => 'required',
                // 'answers.*.is_correct' => 'required'
            ],
            [
                'answers.*.content.required' => 'Chưa nhập trường này !',
                // 'answers.*.is_correct.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                'type.required' => 'Chưa nhập trường này !',
                'type.numeric' => 'Sai định dạng !',
                'status.required' => 'Chưa nhập trường này !',
                'status.numeric' => 'Sai định dạng !',
                'rank.required' => 'Chưa nhập trường này !',
                'rank.numeric' => 'Sai định dạng !',
                'skill.required' =>  'Chưa nhập trường này !',
                'skill.*.required' =>  'Chưa nhập trường này !',
            ]
        );
        if ($validator->fails() || !isset($request->answers)) {
            if (!isset($request->answers)) {
                return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            } else {
                if (count($request->answers) <= 2) return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $question = $this->questionModel::create([
                'content' => $request->content,
                'type' =>  $request->type,
                'status' =>  $request->status,
                'rank' =>  $request->rank,
            ]);
            $question->skills()->syncWithoutDetaching($request->skill);
            foreach ($request->answers as  $value) {
                if ($value['content'] != null) {
                    $this->answerModel::create([
                        'content' => $value['content'],
                        'question_id' => $question->id,
                        'is_correct' => $value['is_correct'][0] ?? 0
                    ]);
                }
            }
            DB::commit();
            return Redirect::route('admin.question.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function show(Question $questions)
    {
        //
    }

    public function edit(Question $questions, $id)
    {
        $skills = $this->skillModel::select('name', 'id')->get();
        $question = $this->questionModel::find($id)->load(['answers', 'skills']);
        // dd($question);
        return view('pages.question.edit', [
            'skills' => $skills,
            'question' => $question,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'content' => 'required|unique:questions,content,' . $id . '',
                'content' => 'required',
                'type' => 'required|numeric',
                'status' => 'required|numeric',
                'rank' => 'required|numeric',
                'skill' => 'required',
                'skill.*' => 'required',
                'answers.*.content' => 'required',
            ],
            [
                'answers.*.content.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                // 'content.unique' => 'Nội dung đã tồn tại !',
                'type.required' => 'Chưa nhập trường này !',
                'type.numeric' => 'Sai định dạng !',
                'status.required' => 'Chưa nhập trường này !',
                'status.numeric' => 'Sai định dạng !',
                'rank.required' => 'Chưa nhập trường này !',
                'rank.numeric' => 'Sai định dạng !',
                'skill.required' =>  'Chưa nhập trường này !',
                'skill.*.required' =>  'Chưa nhập trường này !',
            ]
        );

        if ($validator->fails() || count($request->answers) <= 2) {
            if (count($request->answers) <= 2) {
                return redirect()->back()->withErrors($validator)->with('errorAnswerConten', 'Phải ít nhất 3 đáp án !!')->withInput($request->input());
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        // dd($request->all());
        try {
            $question = $this->questionModel::find($id);
            $question->update([
                'content' => $request->content,
                'type' =>  $request->type,
                'status' =>  $request->status,
                'rank' =>  $request->rank,
            ]);
            $question->skills()->sync($request->skill);
            foreach ($request->answers as  $value) {
                if (isset($value['answer_id'])) {
                    $this->answerModel::find($value['answer_id'])->forceDelete();
                }
            }
            foreach ($request->answers as  $value) {
                if ($value['content'] != null) {
                    $this->answerModel::create([
                        'content' => $value['content'],
                        'question_id' => $question->id,
                        'is_correct' => $value['is_correct'][0] ?? 0
                    ]);
                }
            }
            DB::commit();
            return Redirect::route('admin.question.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function destroy(Question $questions, $id)
    {
        $this->questionModel::find($id)->delete();
        return Redirect::route('admin.question.index');
    }

    public function getModelDataStatus($id)
    {
        return $this->questionModel::find($id);
    }

    public function softDeleteList()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 5))) return abort(404);
        // dd($questions);
        return view('pages.question.list-soft-delete', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }
    public function delete($id)
    {
        try {
            $this->questionModel::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function restoreDelete($id)
    {
        try {
            $this->questionModel::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function save_questions(Request $request)
    {
        try {
            $ids = [];
            $exams = $this->examModel::whereId($request->exam_id)->first();
            foreach ($request->question_ids ?? [] as $question_id) {
                array_push($ids, (int)$question_id['id']);
            }
            $exams->questions()->sync($ids);
            return response()->json([
                'status' => true,
                'payload' => 'Cập nhật trạng thái thành công  !',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng câu hỏi  ! ' . $th->getMessage(),
                'data' => $request->all(),
            ]);
        }
    }

    public function remove_question_by_exams(Request $request)
    {
        try {
            $exams = $this->examModel::whereId($request->exam_id)->first();
            $exams->questions()->detach($request->questions_id);
            return response()->json([
                'status' => true,
                'payload' => 'Cập nhật trạng thái thành công  !',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể xóa câu hỏi  !',
            ]);
        }
    }
    public function import(ImportQuestion $request)
    {
        try {
            Excel::import(new QuestionsImport(), $request->ex_file);
            return response()->json([
                "status" => true,
                "payload" => "Thành công "
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "errors" => [
                    "ex_file" => $th->getMessage()
                ]
            ], 400);
        }
    }

    public function importAndRunExam(ImportQuestion $request, $exam_id)
    {
        try {
            Excel::import(new QuestionsImport($exam_id), $request->ex_file);
            return response()->json([
                "status" => true,
                "payload" => "Thành công "
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "errors" => [
                    "ex_file" => $th->getMessage()
                ]
            ], 400);
        }
    }

    public function exportQe()
    {
        $point = [
            [1, 2, 3],
            [2, 5, 9]
        ];
        $data = (object) array(
            'points' => $point,
        );
        $export = new QuestionsExport([$data]);
        return Excel::download($export, 'abc.xlsx');
        // return Excel::download(new QuestionsExport, 'question.xlsx');
        // return Excel::download(new QuestionsExport, 'invoices.xlsx', true, ['X-Vapor-Base64-Encode' => 'True']);
    }

    public function skillQuestionApi()
    {
        $data = $this->questionRepo->getQuestionSkill();
        return $this->responseApi(true, $data);
    }
}