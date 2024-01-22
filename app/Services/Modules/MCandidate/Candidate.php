<?php

namespace App\Services\Modules\MCandidate;

use App\Models\Candidate as ModelsCandidate;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Candidate
{
    use TUploadImage;

    public function __construct(

        private ModelsCandidate $candidate

    )
    {
    }

    public function getList(Request $request)
    {
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'created_at';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $code_recruitment = $request->has('post_id') ? $request->post_id : null;
        $major_id = $request->has('major_id') ? $request->major_id : null;
        $status = $request->has('status') ? $request->status : null;
        $result = $request->has('result') ? $request->result : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('candidate_soft_delete') ? $request->candidate_soft_delete : null;
        if ($softDelete != null) {
            $query = $this->candidate::onlyTrashed()->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->candidate::whereRaw('id IN (select MAX(id) FROM candidates GROUP BY email,post_id)');

        if ($endTime != null && $startTime != null) {
            $query->where('crepated_at', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('created_at', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($sortBy == "desc") {
            $query
                ->orderByDesc('send_cv_at')
                ->orderByDesc('id');
        } else {
            $query->orderBy($orderBy);
        }
        if ($code_recruitment != null) {
            $query->where('post_id', $code_recruitment);
        }
        if ($major_id != null) {
            $query->where('major_id', $major_id);
        }
        if ($status != null) {
            $query->where('status', $status);
        }
        if ($result != null) {
            $query->where('result', $result);
        }
        return $query;
    }

    public function index(Request $request)
    {
        return $this->getList($request)
            ->with('post:id,code_recruitment,slug')
            ->with('candidateNotes.user')
//            ->orderBy('updated_at', 'desc')
            ->paginate(request('limit') ?? 10);
    }

    public function listCvUser($request)
    {
        return $this->candidate::with('post:id,code_recruitment,slug')->where('post_id', $request->post_id)->where('email', $request->email)->paginate(request('limit') ?? 10);
    }

    public function store($request)
    {
        // $ckeck_exist = $this->candidate::where('email', $request->email)->where('post_id', $request->post_id)->first();
        // if ($ckeck_exist) {
        //     return  null;
        // }
        $data = [
            'post_id' => $request->post_id,
            'email' => $request->email,
            'name' => $request->name,
            'student_code' => $request->student_code,
            'phone' => $request->phone,
            'file_link' => $this->uploadFile($request->file_link),
            'student_status' => $request->student_status ?? 0,
        ];
        $candidate = $this->candidate::create($data);
        return $candidate;
    }

    public function update($request)
    {
        $candidate = $this->candidate::find($request->id);
        $candidate->email = $request->email;
        $candidate->name = $request->name;
        $candidate->student_code = $request->student_code;
        $candidate->phone = $request->phone;
        if ($request->has('file_link')) {
            $fileImage = $request->file('file_link');
            $file = $this->uploadFile($fileImage, $candidate->file_link);
            $candidate->file_link = $file;
        }
        $candidate->save();
    }

    public function updateOrCreate($request)
    {
        $dataCheck = [
            'post_id' => $request->post_id,
            'email' => $request->email,
            'student_code' => $request->student_code,
            'phone' => $request->phone,
            'major_id' => $request->major_id,
        ];
        $dataUpdate = [
            'name' => $request->name,
            'file_link' => $this->uploadFile($request->file_link),
            'has_checked' => 0,
            'student_status' => $request->student_status ?? 0,
            'send_cv_at' => now(),
        ];
        $candidate = $this->candidate::updateOrCreate($dataCheck, $dataUpdate);

        return $candidate;
    }

    public function count($request = null)
    {
        $startTime = $request?->startTime;
        $endTime = $request?->endTime;
        $code_recruitment = $request?->post_id;
        $major_id = $request?->major_id;
        $status = $request?->status;
        $result = $request?->result;
        $softDelete = $request?->candidate_soft_delete;
        if ($softDelete != null) {
            return $this->candidate::onlyTrashed();
        }
        $query = $this->candidate::whereRaw('id IN (select MAX(id) FROM candidates GROUP BY email,post_id)');

        if ($endTime != null && $startTime != null) {
            $query->where('crepated_at', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('created_at', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($code_recruitment != null) {
            $query->where('post_id', $code_recruitment);
        }
        if ($major_id != null) {
            $query->where('major_id', $major_id);
        }
        if ($status != null) {
            $query->where('status', $status);
        }
        if ($result != null) {
            $query->where('result', $result);
        }
        return $query->count();
    }
}
