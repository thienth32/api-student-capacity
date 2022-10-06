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

    ) {
    }
    public function getList(Request $request)
    {
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'created_at';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $code_recruitment = $request->has('post_id') ? $request->post_id : null;
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
            $query->orderByDesc('created_at');
        } else {
            $query->orderBy($orderBy);
        }
        if ($code_recruitment != null) {
            $query->where('post_id', $code_recruitment);
        }
        return $query;
    }
    public function index(Request $request)
    {
        return $this->getList($request)->with('post:id,code_recruitment,slug')->paginate(request('limit') ?? 10);
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
            'phone' => $request->phone,
            'file_link' => $this->uploadFile($request->file_link),
        ];
        $candidate = $this->candidate::create($data);
        return $candidate;
    }
    public function update($request)
    {
        $candidate = $this->candidate::find($request->id);
        $candidate->email = $request->email;
        $candidate->name = $request->name;
        $candidate->phone = $request->phone;
        if ($request->has('file_link')) {
            $fileImage =  $request->file('file_link');
            $file = $this->uploadFile($fileImage, $candidate->file_link);
            $candidate->file_link = $file;
        }
        $candidate->save();
    }
}
