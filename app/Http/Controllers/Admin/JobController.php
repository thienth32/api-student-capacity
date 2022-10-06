<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\JobRequest;
use App\Jobs\GameTypePlay;
use App\Models\JobQueue;
use App\Services\Modules\MExam\MExamInterface;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(
        public MExamInterface $examRepo,
    ) {
    }

    public function index()
    {
        $data = [];
        $data['exams'] = $this->examRepo->getCapacityPlayGameOnline();
        $data['jobs_in_process'] = [
            'id' => '_inprocess',
            'title' => 'Đang chờ'
        ];
        $data['jobs_in_error'] = [
            'id' => '_error',
            'title' => 'Công việc lỗi <a href="' . route('admin.job.destroy') . '" class="btn btn-danger">Xóa toàn bộ</a>'
        ];
        $data['jobs_in_working'] = [
            'id' => '_working',
            'title' => 'Công việc đang chạy'
        ];
        $data['jobs_in_process']['item'] = JobQueue::where('status', 0)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model
            ];
        });
        $data['jobs_in_working']['item'] = JobQueue::where('status', 1)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model
            ];
        });
        $data['jobs_in_error']['item'] = JobQueue::where('status', 3)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model . " -Error :" . $q->error
            ];
        });
        return view('pages.job.index', $data);
    }

    public function destroy()
    {
        $jobs = JobQueue::where('status', 3)->get();
        foreach ($jobs as $job) {
            $job->delete();
        }
        return redirect()->back();
    }

    public function store(JobRequest $request)
    {
        $dataCreate = [
            "status" => 1
        ];
        switch ($request->type) {
            case 'game_type_1':
                $dataCreate['on_date'] = $request->on_date;
                $dataCreate['token_queue'] = uniqid();
                $dataCreate['config'] = json_encode([
                    "model" => "GAME_TYPE_1",
                ]);
                dispatch(new GameTypePlay($request->exam_code, "GAME_TYPE_1", $request->time, $dataCreate['token_queue']))->onQueue($dataCreate['token_queue']);
                break;
            case 'game_type_2':
                $dataCreate['on_date'] = $request->on_date;
                $dataCreate['token_queue'] = uniqid();
                $dataCreate['config'] = json_encode([
                    "model" => "GAME_TYPE_2",
                ]);
                dispatch(new GameTypePlay($request->exam_code, "GAME_TYPE_2", $request->time, $dataCreate['token_queue']))->onQueue($dataCreate['token_queue']);
                break;
            default:
                abort(404);
                break;
        }

        JobQueue::create($dataCreate);

        return redirect()->back()->with('success', 'Thành công ');
    }
}