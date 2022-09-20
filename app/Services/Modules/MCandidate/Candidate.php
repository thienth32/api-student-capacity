<?php

namespace App\Services\Modules\MCandidate;

use App\Models\Candidate as ModelsCandidate;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class Candidate
{
    use TUploadImage;
    public function __construct(

        private ModelsCandidate $candidate

    ) {
    }
    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $code_recruitment = $request->has('post_id') ? $request->post_id : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('candidate_soft_delete') ? $request->candidate_soft_delete : null;
        if ($softDelete != null) {
            $query = $this->candidate::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->candidate::where('name', 'like', "%$keyword%");
        if ($endTime != null && $startTime != null) {
            $query->where('created_at', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('created_at', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
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
        return $this->getList($request)->paginate(request('limit') ?? 10);
    }
    public function store($request)
    {
        $ckeck_exist = $this->candidate::where('email', $request->email)->where('post_id', $request->post_id)->first();
        // $oldCandiate = $ckeck_exist ? $ckeck_exist->file_link : null;
        // $ckeck = [
        //     'post_id' => $request->post_id,
        //     'email' => $request->email,
        // ];
        // $updateOrCreate = [
        //     'name' => $request->name,
        //     'phone' => $request->phone,
        //     'file_link' => $this->uploadFile($request->file_link, $oldCandiate),
        // ];
        if ($ckeck_exist) {
            return  null;
        }
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
