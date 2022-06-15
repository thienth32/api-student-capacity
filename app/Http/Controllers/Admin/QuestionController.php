<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\Questions;
use App\Models\Skills;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    protected $skillModel;
    protected $questionModel;
    protected $answerModel;
    public function __construct(Skills $skills, Questions $questions, Answers $answers)
    {
        $this->skillModel = $skills;
        $this->questionModel = $questions;
        $this->answerModel = $answers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        try {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $data = $this->questionModel::status(request('status'))
                ->search(request('q') ?? null, ['content'])
                ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'questions')
                ->whenWhereHasRelationship(request('skill') ?? null, 'skills', 'skills.id')
                // ->hasRequest(['rank' => request('level') ?? null, 'type' => request('type') ?? null]);
                ->when(request()->has('level'), function ($q) {
                    $q->where('rank', request('level'));
                })
                ->when(request()->has('type'), function ($q) {
                    $q->where('type', request('type'));
                });

            // ->when(request()->has('skill'), function ($q) {
            //     $q->whereHas('skills', function ($query) {
            //         $query->where('skills.id', request('skill'));
            //     });
            // });

            $data->with('skills');
            return $data;
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function index()
    {
        $skills = $this->skillModel::all();
        if (!($questions = $this->getList()->paginate(request('limit') ?? 5))) return abort(404);

        // dd($questions);
        return view('pages.question.list', [
            'questions' => $questions,
            'skills' => $skills,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        // dd($validator->messages());
        if ($validator->fails()) {
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function edit(Questions $questions, $id)
    {
        $skills = $this->skillModel::select('name', 'id')->get();
        $question = $this->questionModel::find($id)->load(['answers', 'skills']);
        // dd($question);
        return view('pages.question.edit', [
            'skills' => $skills,
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required|unique:questions,content,' . $id . '',
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
                'content.unique' => 'Nội dung đã tồn tại !',
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

        if ($validator->fails()) {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questions  $questions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Questions $questions)
    {
        //
    }


    public function un_status(Request $request)
    {
        try {
            $question = $this->questionModel::find($request->id);
            $question->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status(Request $request)
    {
        try {
            $question = $this->questionModel::find($request->id);
            $question->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }
}