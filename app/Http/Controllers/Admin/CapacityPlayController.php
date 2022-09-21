<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Capacity\CapacityPlay;
use App\Services\Modules\MExam\MExamInterface;
use App\Services\Modules\MQuestion\MQuestionInterface;
use Illuminate\Support\Facades\DB;

class CapacityPlayController extends Controller
{
    public function __construct(
        public MExamInterface $examRepo,
        public MQuestionInterface $questionRepo
    ) {
    }

    public function index()
    {
        $exams = $this->examRepo->getExamCapacityPlay();
        return view('pages.capacity-play.index', compact('exams'));
    }

    public function create()
    {
        $data = [];
        $data['questions'] = $this->questionRepo->getAllQuestion();
        return view('pages.capacity-play.create', $data);
    }

    public function store(CapacityPlay $request)
    {
        DB::beginTransaction();
        try {
            $exam  = $this->examRepo->storeCapacityPlay($request);
            DB::commit();
            return redirect()->route('admin.capacit.play.show', ['id' => $exam->id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with("error", "Không thể thêm mới trò chơi ! Lỗi " . $th->getMessage());
        }
    }

    public function show($id)
    {
        $data = [];
        $data['exam'] = $this->examRepo->findById($id);
        return view('pages.capacity-play.show', $data);
    }
}