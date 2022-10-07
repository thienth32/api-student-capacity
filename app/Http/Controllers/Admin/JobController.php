<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\JobRequest;
use App\Jobs\GameTypePlay;
use App\Jobs\SendMailQueue;
use App\Mail\FinnalPass;
use App\Models\JobQueue;
use App\Services\Modules\MExam\MExamInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function __construct(
        public MExamInterface $examRepo,
    ) {
    }

    public function getEIdJob()
    {
        return JobQueue::all()->map(function ($q) {
            $data = json_decode($q->config);
            return $data->id;
        })->toArray();
    }

    public function index()
    {


        $data = [];
        $data['exams'] = $this->examRepo->getCapacityPlayGameOnline();
        $data['jobs_in_process'] = [
            'id' => '_inprocess',
            'title' => 'Đang chờ',
            'class' => 'alert,alert-info',
            "dragTo" => ['_working'],
        ];
        $data['jobs_in_error'] = [
            'id' => '_error',
            'class' => 'alert,alert-danger',
            "dragTo" => [],
            'title' => 'Công việc lỗi <a href="' . route('admin.job.destroy') . '" class="text-danger">Xóa toàn bộ</a>'
        ];
        $data['jobs_in_working'] = [
            'id' => '_working',
            'class' => 'alert,alert-success',
            "dragTo" => ['_error'],
            'title' => 'Công việc đang chạy'
        ];
        $data['jobs_in_process']['item'] = JobQueue::where('status', 0)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model . " TIME : " . $q->on_date . " EID:" . $config->id,
                'id' => $q->id
            ];
        });
        $data['jobs_in_working']['item'] = JobQueue::where('status', 1)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model . " TIME : " . $q->on_date . "  EID:" . $config->id,
                'id' => $q->id
            ];
        });
        $data['jobs_in_error']['item'] = JobQueue::where('status', 3)->get()->map(function ($q) {
            $config = json_decode($q->config);
            return [
                'title' => $config->model . " -Error :" . $q->error,
                'id' => $q->id
            ];
        });
        $data['dataJobs'] = $this->getEIdJob();

        return view('pages.job.index', $data);
    }

    public function updateStatusJob(Request $request)
    {
        try {
            JobQueue::find($request->id)->update([
                'status' => $request->status
            ]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
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
        $dataJobs = $this->getEIdJob();
        if (in_array($this->exam_code ?? "", $dataJobs)) return redirect()->back()->with("error", "Đã có công việc !");
        $dataCreate = [
            "status" => request()->status,
        ];
        $dataCreate['on_date'] = $request->on_date;
        $dataCreate['token_queue'] = uniqid();
        switch ($request->type) {
            case 'game_type_1':

                $dataCreate['config'] = json_encode([
                    "model" => "GAME_TYPE_1",
                    "id" => $request->exam_code,
                    "time" => $request->time
                ]);

                dispatch(new GameTypePlay($request->exam_code, "GAME_TYPE_1", $request->time, $dataCreate['token_queue']))->onQueue($dataCreate['token_queue']);
                break;
            case 'game_type_2':

                $dataCreate['config'] = json_encode([
                    "model" => "GAME_TYPE_2",
                    "id" => $request->exam_code,
                    "time" => $request->time
                ]);
                dispatch(new GameTypePlay($request->exam_code, "GAME_TYPE_2", $request->time, $dataCreate['token_queue']))->onQueue($dataCreate['token_queue']);
                break;

            case 'send_mail':
                $dataCreate['config'] = json_encode([
                    "model" => "SEND MAIL",
                    "id" => $request->subject,
                ]);
                dispatch(new SendMailQueue($dataCreate['token_queue'], request()->mails, request()->subject, request()->content, trim(request()->cc) == "" ? [] : explode(',', request()->cc)))
                    ->onQueue($dataCreate['token_queue']);
                break;
            default:
                abort(404);
                break;
        }
        JobQueue::create($dataCreate);
        return redirect()->back()->with('success', 'Thành công ');
    }
}