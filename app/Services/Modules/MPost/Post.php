<?php

namespace App\Services\Modules\MPost;

use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Post as ModelsPost;
use App\Models\Recruitment;
use App\Models\Round;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class Post
{
    use TUploadImage;
    public function __construct(

        private Contest $contest,
        private ModelsPost $post,
        private Enterprise $enterprise,
        private Recruitment $recruitment,
        private Round $round,

    ) {
    }

    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $status = $request->has('status') ? $request->status : null;
        $contest = $request->has('contest_id') ? $request->contest_id : 0;
        $capacity = $request->has('capacity_id') ? $request->capacity_id : 0;
        $rounds = $request->has('round_id') ? $request->round_id : 0;
        $recruitment = $request->has('recruitment_id') ? $request->recruitment_id : 0;
        $progress = $request->has('progress') ? $request->progress : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $postHot =  $request->has('postHot') ? $request->postHot : null;
        $softDelete = $request->has('post_soft_delete') ? $request->post_soft_delete : null;
        if ($softDelete != null) {
            $query = $this->post::onlyTrashed()->where('title', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        // $query = $this->post::where('title', 'like', "%$keyword%");
        $query = $this->post::query();
        $query->where('title', 'like', "%$keyword%");
        // if ($request->has('qq')) $query->searchKeyword(request('qq') ?? null, ['title']);
        if ($status != null) {
            $query->where('status', $status);
        }
        if ($postHot != null) {
            if ($postHot == 'hot') {
                $query->where('hot', config('util.POST_HOT'));
            } elseif ($postHot == 'normal') {
                $query->where('hot', config('util.POST_NORMAL'));
            }
        }
        if ($progress != null) {
            if ($progress == 'unpublished') {
                $query->where('published_at', '>', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
            } elseif ($progress == 'published') {
                $query->where('published_at', '<', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
            }
        }
        if ($endTime != null && $startTime != null) {
            $query->where('published_at', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('published_at', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        if ($contest != 0) {
            $query->where('postable_id', $contest)->where('postable_type', $this->contest::class);
        }
        if ($capacity != 0) {
            $query->where('postable_id', $capacity)->where('postable_type', $this->contest::class);
        }
        if ($rounds != 0) {
            $query->where('postable_id', $rounds)->where('postable_type', $this->round::class);
        }
        if ($recruitment != 0) {
            $query->where('postable_id', $recruitment)->where('postable_type', $this->recruitment::class);
        }
        if ($request->post != null) {
            $this->loadAble($query, $request->post);
        }

        return $query;
    }
    public function index(Request $request)
    {
        return $this->getList($request)->with(['postable:id,name'])->paginate(request('limit') ?? config('util.HOMEPAGE_ITEM_AMOUNT'));
    }
    private function loadAble($query, $post = null)
    {
        if ($post == config('util.post-contest')) {
            $query->where('status_capacity', 0)->where('postable_type', $this->contest::class);
        } elseif ($post == config('util.post-capacity')) {
            $query->where('status_capacity', 1)->where('postable_type', $this->contest::class);
        } elseif ($post == config('util.post-round')) {
            $query->where('postable_type', $this->round::class);
        } elseif ($post == config('util.post-recruitment')) {
            $query->where('postable_type', $this->recruitment::class);
        }
    }
    public function find($id)
    {
        return $this->post::find($id);
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
            'code_recruitment' => $request->code_recruitment ? $request->code_recruitment : null,
            'user_id' => $request->user_id != 0 ?  $request->user_id : auth()->user()->id,
        ];

        if ($request->has('thumbnail_url')) {
            $fileImage =  $request->file('thumbnail_url');
            $image = $this->uploadFile($fileImage);
            $data['thumbnail_url'] = $image;
        }

        if ($request->contest_id != 0) {
            $dataContest = $this->contest::find($request->contest_id);
            $dataContest->posts()->create($data);
        } elseif ($request->capacity_id != 0) {
            $data['status_capacity'] = 1; // 1 là bài viết thuộc capacity nhằm phân biệt với contest
            $dataCapacity = $this->contest::find($request->capacity_id);
            $dataCapacity->posts()->create($data);
        } elseif ($request->round_id != 0) {
            $dataRound = $this->round::find($request->round_id);
            $dataRound->posts()->create($data);
        } elseif ($request->recruitment_id != 0) {
            $dataRound = $this->recruitment::find($request->recruitment_id);
            $dataRound->posts()->create($data);
        }
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
        $post->code_recruitment = $request->code_recruitment ? $request->code_recruitment : null;
        $post->user_id = $request->user_id != 0 ? $request->user_id : auth()->user()->id;

        if ($request->has('thumbnail_url')) {
            $fileImage =  $request->file('thumbnail_url');
            $image = $this->uploadFile($fileImage,  $post->thumbnail_url);
            $post->thumbnail_url = $image;
        }
        if ($request->contest_id != 0) {
            $post->postable_id = $request->contest_id;
            $post->postable_type = $this->contest::class;
            $post->status_capacity = 0;
        } elseif ($request->capacity_id != 0) {
            $post->status_capacity = 1;
            $post->postable_id = $request->capacity_id;
            $post->postable_type = $this->contest::class;
        } elseif ($request->round_id != 0) {
            $post->postable_id = $request->round_id;
            $post->postable_type = $this->round::class;
            $post->status_capacity = 0;
        } elseif ($request->recruitment_id != 0) {
            $post->postable_id = $request->recruitment_id;
            $post->postable_type = $this->recruitment::class;
            $post->status_capacity = 0;
        }
        $post->save();
    }
}
