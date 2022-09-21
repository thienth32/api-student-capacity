<?php

namespace App\Services\Modules\MKeyword;

use App\Models\Keyword as ModelsKeyword;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Keyword
{
    use TUploadImage;
    public function __construct(

        private ModelsKeyword $modelKeyword,

    ) {
    }

    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $status = $request->has('status') ? $request->status : null;

        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('keyword_soft_delete') ? $request->keyword_soft_delete : null;
        if ($softDelete != null) {
            $query = $this->modelKeyword::onlyTrashed()->where('keyword', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->modelKeyword::where('title', 'like', "%$keyword%");
        if ($status != null) {
            $query->where('status', $status);
        }
        // if ($endTime != null && $startTime != null) {
        //     $query->where('published_at', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('published_at', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        // }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        return $query;
    }
    public function index(Request $request)
    {
        return $this->getList($request)->paginate(request('limit') ?? 10);
    }

    public function find($id)
    {
        return $this->modelKeyword::find($id);
    }
    public function store($request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'published_at' => $request->published_at,
            'content' => $request->content ? $request->content : null,
            'slug' => $request->slug,
            'link_to' => $request->link_to ? $request->link_to : null,
            'user_id' => auth()->user()->id,
        ];
    }
    public function update($request, $id)
    {
        $post = $this->post::find($id);


        if (!$post) {
            return redirect('error');
        }
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->published_at = $request->published_at;
        $post->description = $request->description;
        $post->content = $request->content ?  $request->content : null;
        $post->link_to = $request->link_to ?  $request->link_to : null;

        if ($request->has('thumbnail_url')) {
            $fileImage =  $request->file('thumbnail_url');
            $image = $this->uploadFile($fileImage);
            $post->thumbnail_url = $image;
        }

        $post->save();
    }
}
