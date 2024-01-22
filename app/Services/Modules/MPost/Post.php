<?php

namespace App\Services\Modules\MPost;

use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Keyword;
use App\Models\Major;
use App\Models\Post as ModelsPost;
use App\Models\Recruitment;
use App\Models\Round;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class Post
{
    use TUploadImage;

    public function __construct(

        private Contest     $contest,
        private ModelsPost  $post,
        private Enterprise  $enterprise,
        private Recruitment $recruitment,
        private Round       $round,
        private Keyword     $keyword,
        private Major       $majorModel,
    )
    {
    }

    public function getModel()
    {
        return $this->post->query();
    }

    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $q = $request->has('q') ? $request->q : null;
        $status = $request->has('status') ? $request->status : null;
        $post = $request->has('post_id') ? $request->post_id : 0;
        $contest = $request->has('contest_id') ? $request->contest_id : 0;
        $capacity = $request->has('capacity_id') ? $request->capacity_id : 0;
        $rounds = $request->has('round_id') ? $request->round_id : 0;
        $recruitment = $request->has('recruitment_id') ? $request->recruitment_id : 0;
        $progress = $request->has('progress') ? $request->progress : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $postHot = $request->has('postHot') ? $request->postHot : null;
        $branch_id = $request->has('branch_id') ? $request->branch_id : null;
        $major_id = $request->has('major_id') ? $request->major_id : null;
        $enterprise_id = $request->has('enterprise_id') ? $request->enterprise_id : null;
        $softDelete = $request->has('post_soft_delete') ? $request->post_soft_delete : null;
        if ($softDelete != null) {
            $query = $this->post::onlyTrashed()->where('title', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        // $query = $this->post::where('title', 'like', "%$keyword%");
        $query = $this->post::query();
        $query->where('title', 'like', "%$keyword%");

        //Từ khóa tìm kiếm nổi bật
        if ($q != null) {
            // ->orWhere("keyword_en", "LIKE", "%" .  implode(' ', explode('-', $q)) . "%")
            $k = $this->keyword::where('keyword_slug', 'like', "%$q%")->first();
            if ($k) $query->where("title", "LIKE", "%$k->keyword%")
                ->orWhere("title", "LIKE", "%$k->keyword_en%");
        }

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
        if ($post != 0) {
            $query->where('id', $post);
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
        if ($branch_id != 0) {
            $query->where('branch_id', $branch_id)->where('postable_type', $this->recruitment::class);
        }
        if ($major_id != 0) {
            $query->where('major_id', $major_id)->where('postable_type', $this->recruitment::class);
        }
        if ($enterprise_id != 0) {
            $query->where('enterprise_id', $enterprise_id)->where('postable_type', $this->recruitment::class);
        }
//        if (!auth()->user()->hasRole(config('util.SUPER_ADMIN_ROLE'))) {
//            $query->where('branch_id', auth()->user()->branch_id);
//        }
        if ($request->post != null) {
            $this->loadAble($query, $request->post);
        }

        return $query;
    }

    public function updateView($id)
    {
        $post = $this->post::find($id);
        if ($post) {
            $post->increment('view');
            // Hoặc: $job->increment('views', 1);
            return response()->json(['message' => 'Views increased successfully post ID' . $id], 200);
        } else {
            return response()->json(['message' => 'Job not found'], 404);
        }
    }

    public function index(Request $request, $postable = null)
    {
        if ($postable) {
            $postable_prefix = "App\\Models\\";
            $postable_type = $postable_prefix . ucfirst($postable);
        }
        $query = $this->getList($request)->with(['postable:id,name']);
        if ($postable) {
            $query->where('postable_type', $postable_type);
        }
        return $query->paginate(request('limit') ?? config('util.HOMEPAGE_ITEM_AMOUNT'));
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
            'user_id' => $request->user_id != 0 ? $request->user_id : auth()->user()->id,
            'branch_id' => $request->branch_id ?? 0,
            'tax_number' => $request->tax_number != 0 ? $request->tax_number : null,
            'contact_name' => $request->contact_name != 0 ? $request->contact_name : null,
            'contact_phone' => $request->contact_phone != 0 ? $request->contact_phone : null,
            'contact_email' => $request->contact_email != 0 ? $request->contact_email : null,
            'career_source' => $request->career_source != 0 ? $request->career_source : null,
            'career_require' => $request->career_require != 0 ? $request->career_require : null,
            'position' => $request->position != 0 ? $request->position : null,
            'career_type' => $request->career_type != 0 ? $request->career_type : 1,
            'major_id' => $request->major_id != 0 ? $request->major_id : null,
            'branch_id' => $request->branch_id != 0 ? $request->branch_id : 0,
            'enterprise_id' => $request->enterprise_id != 0 ? $request->enterprise_id : null,
            'total' => $request->total != 0 ? $request->total : null,
            'deadline' => $request->deadline != 0 ? $request->deadline : null,
            'note' => $request->note != 0 ? $request->note : null,
        ];

        if ($request->post_type === 'recruitment') {
            $enterprise = $this->enterprise::query()
                ->where('id', $request->enterprise_id)
                ->orWhere('name', $request->enterprise_id)
                ->first();

            if (!$enterprise) {
                $enterprise = $this->enterprise::create([
                    'name' => $request->enterprise_id,
                ]);
            }

            $major_id = trim($request->major_id);

            $major = $this->majorModel::query()
                ->where('id', $major_id)
                ->orWhere('slug', Str::slug($major_id))
                ->first();

            if (!$major) {
                $major = $this->majorModel::query()->create([
                    'name' => $major_id,
                    'slug' => Str::slug($major_id),
                    'for_recruitment' => '1',
                ]);
            }

            $data['enterprise_id'] = $enterprise->id;
            $data['major_id'] = $major->id;
        }

        if ($request->has('thumbnail_url')) {
            $fileImage = $request->file('thumbnail_url');
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
        } elseif ($request->post_type === 'recruitment') {
            $data['postable_type'] = $this->recruitment::class;
            $this->post::create($data);
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
        $post->content = $request->content ? $request->content : null;
        $post->link_to = $request->link_to ? $request->link_to : null;
        $post->code_recruitment = $request->code_recruitment ? $request->code_recruitment : null;
        $post->user_id = $request->user_id != 0 ? $request->user_id : auth()->user()->id;
        $post->branch_id = $request->branch_id ?? 0;
        $post->tax_number = $request->tax_number != 0 ? $request->tax_number : null;
        $post->contact_name = $request->contact_name != 0 ? $request->contact_name : null;
        $post->contact_phone = $request->contact_phone != 0 ? $request->contact_phone : null;
        $post->contact_email = $request->contact_email != 0 ? $request->contact_email : null;
        $post->career_source = $request->career_source != 0 ? $request->career_source : null;
        $post->career_require = $request->career_require != 0 ? $request->career_require : null;
        $post->position = $request->position != 0 ? $request->position : null;
        $post->career_type = $request->career_type != 0 ? $request->career_type : 1;
        $post->major_id = $request->major_id != 0 ? $request->major_id : null;
        $post->branch_id = $request->branch_id != 0 ? $request->branch_id : 0;
        $post->enterprise_id = $request->enterprise_id != 0 ? $request->enterprise_id : null;
        $post->total = $request->total != 0 ? $request->total : null;
        $post->deadline = $request->deadline != 0 ? $request->deadline : null;
        $post->note = $request->note != 0 ? $request->note : null;

        if ($request->post_type === 'recruitment') {
            $enterprise = $this->enterprise::query()
                ->where('id', $request->enterprise_id)
                ->orWhere('name', $request->enterprise_id)
                ->first();
            if (!$enterprise) {
                $enterprise = $this->enterprise::create([
                    'name' => $request->enterprise_id,
                ]);
            }

            $major_id = trim($request->major_id);

            $major = $this->majorModel::query()
                ->where('id', $major_id)
                ->orWhere('slug', Str::slug($major_id))
                ->first();

            if (!$major) {
                $major = $this->majorModel::query()->create([
                    'name' => $major_id,
                    'slug' => Str::slug($major_id),
                    'for_recruitment' => '1',
                ]);
            }

            $post->enterprise_id = $enterprise->id;
            $post->major_id = $major->id;
        }

        if ($request->has('thumbnail_url')) {
            $fileImage = $request->file('thumbnail_url');
            $image = $this->uploadFile($fileImage, $post->thumbnail_url);
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
        } elseif ($request->post_type === 'recruitment') {
            $post->postable_type = $this->recruitment::class;
            $post->status_capacity = 0;
        }
        $post->save();
    }

    public function getLatestInfoWithDiffTaxNumber(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->post::query()
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from($this->post->getTable())
                    ->whereNotNull('tax_number')
                    ->groupBy('tax_number');
            });
//        return $this->post->query()
//            ->select('tax_number', 'contact_name', 'contact_phone', 'contact_email')
//            ->whereNotNull('tax_number')
//            ->groupBy('tax_number')
//            ->latest('created_at');
    }
}
