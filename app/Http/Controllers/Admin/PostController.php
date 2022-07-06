<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Recruitments;
use App\Models\Round;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\Promise\all;

class PostController extends Controller
{
    use TUploadImage;
    use TResponse;
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $status = $request->has('status') ? $request->status : null;
        $contest = $request->has('contest_id') ? $request->contest_id : 0;
        $rounds = $request->has('round_id') ? $request->round_id : 0;
        $recruitment = $request->has('recruitment_id') ? $request->recruitment_id : 0;
        $progress = $request->has('progress') ? $request->progress : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('post_soft_delete') ? $request->post_soft_delete : null;
        if ($softDelete != null) {
            $query = Post::onlyTrashed()->where('title', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        if ($contest != 0) {
            $query = Contest::find($contest);
            return $query;
        }
        if ($rounds != 0) {
            $query = Round::find($rounds);
            return $query;
        }
        if ($recruitment != 0) {
            $query = Recruitment::find($recruitment);
            return $query;
        }
        $query = Post::where('title', 'like', "%$keyword%");
        if ($status != null) {
            $query->where('status', $status);
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
        // dd($query->get());
        return $query;
    }
    public function index(Request $request)
    {

        DB::beginTransaction();
        try {
            $round = null;
            if (request()->has('round_id')) $round = Round::find(request('round_id'))->load('contest');
            $contest = Contest::where('type', 0)->get();
            $recruitments = Recruitment::all();
            $rounds = Round::all();
            $posts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

            if ($request->contest_id) {
                $posts = $this->getList($request)->posts()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }
            if ($request->round_id) {
                $posts = $this->getList($request)->posts()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }
            if ($request->recruitment_id) {
                $posts = $this->getList($request)->posts()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }

            DB::commit();
            return view('pages.post.index', [
                'posts' => $posts,
                'contest' => $contest,
                'recruitments' => $recruitments,
                'rounds' => $rounds,
                'round' => $round
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('error');
        };
    }
    public function un_status($id)
    {
        try {
            $post = Post::find($id);
            $post->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => $post
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        try {
            $post = Post::find($id);
            $post->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => $post
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $contest = Contest::where('type', 0)->get();
            $recruitments = Recruitment::all();
            $rounds = Round::all();

            DB::commit();
            return view('pages.post.form-add', ['contest' => $contest, 'recruitments' => $recruitments, 'rounds' => $rounds]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }
    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $contest = Contest::where('type', 0)->get();
            $recruitments = Recruitment::all();
            $rounds = Round::all();

            DB::commit();
            return view('pages.post.form-add-outside', ['contest' => $contest, 'recruitments' => $recruitments, 'rounds' => $rounds]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|unique:posts,title',
                'description' => 'required',
                'published_at' => 'required|after_or_equal:today',
                'slug' => 'required|unique:posts,slug',
                'thumbnail_url' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'content' => $request->content ? 'required' : '',
                'link_to' => $request->link_to ? 'required' : '',
            ],
            [
                'slug.required' => 'Không được bỏ trống slug !',
                'slug.unique' => 'trường đã tồn tại !',
                'title.required' => 'Chưa nhập trường này !',
                'title.unique' => 'trường đã tồn tại !',
                'published_at.after_or_equal' => 'Thời gian bắt đầu phải sau hoặc bằng ngày hiện tại. ',
                'published_at.required' => 'Chưa nhập trường này !',
                'description.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                'link_to.required' => 'Chưa nhập trường này !',
                'thumbnail_url.mimes' => 'Sai định dạng !',
                'thumbnail_url.required' => 'Chưa nhập trường này !',
                'thumbnail_url.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'published_at' => $request->published_at,
                'content' => $request->content ? $request->content : null,
                'slug' => $request->slug,
                'link_to' => $request->link_to ? $request->link_to : null,
                'user_id' => auth()->user()->id,
            ];

            if ($request->has('thumbnail_url')) {
                $fileImage =  $request->file('thumbnail_url');
                $image = $this->uploadFile($fileImage);
                $data['thumbnail_url'] = $image;
            }
            if ($request->contest_id != 0) {
                $dataContest = Contest::find($request->contest_id);
                $dataContest->posts()->create($data);
            } elseif ($request->round_id != 0) {
                $dataRound = Round::find($request->round_id);
                $dataRound->posts()->create($data);
            } elseif ($request->recruitment_id != 0) {
                $dataRound = Recruitment::find($request->recruitment_id);
                $dataRound->posts()->create($data);
            }

            Db::commit();

            return Redirect::route('admin.post.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function destroy($slug)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;
            DB::transaction(function () use ($slug) {
                if (!(Post::where('slug', $slug)->get())) return false;
                Post::where('slug', $slug)->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function edit(Request $request, $slug)
    {

        DB::beginTransaction();
        try {
            $round = null;
            $contest = Contest::where('type', 0)->get();
            $recruitments = Recruitment::all();
            $post = $this->getList($request)->where('slug', $slug)->first();
            $post->load('postable');
            if ($post->postable && (get_class($post->postable) == Round::class)) {
                $round = Round::find($post->postable->id)->load('contest');
            }

            return view('pages.post.form-edit', [
                'round' => $round,
                'post' => $post,
                'recruitments' => $recruitments,
                'contest' => $contest,
                'rounds' => Round::all(),

            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|unique:posts,title,' . $id,
                'description' => 'required',
                'published_at' => 'required',
                'slug' => 'required|unique:posts,slug,' . $id,
                'content' => 'required',
                'content' => $request->content ? 'required' : '',
                'link_to' => $request->link_to ? 'required' : '',
            ],
            [
                'slug.required' => 'Không được bỏ trống slug !',
                'slug.unique' => 'trường đã tồn tại !',
                'title.required' => 'Chưa nhập trường này !',
                'title.unique' => 'trường đã tồn tại !',
                'published_at.required' => 'Chưa nhập trường này !',
                'description.required' => 'Chưa nhập trường này !',
                'content.required' => 'Chưa nhập trường này !',
                'link_to.required' => 'Chưa nhập trường này !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd($id);
        DB::beginTransaction();
        try {
            $post = Post::find($id);


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
            if ($request->contest_id != 0) {
                $post->postable_id = $request->contest_id;
                $post->postable_type = Contest::class;
            } elseif ($request->round_id != 0) {
                $post->postable_id = $request->round_id;
                $post->postable_type = Round::class;
            } elseif ($request->recruitment_id != 0) {
                $post->postable_id = $request->recruitment_id;
                $post->postable_type = Recruitment::class;
            }
            $post->save();

            Db::commit();

            return Redirect::route('admin.post.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function detail($slug)
    {
        $data = Post::where('slug', $slug)->first();

        return view('pages.post.detailPost', compact('data'));
    }

    public function listRecordSoftDeletes(Request $request)
    {

        $listSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        // dd($listSofts);
        return view('pages.post.soft-delete', compact('listSofts'));
    }
    public function backUpPost($id)
    {
        try {
            Post::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    //xóa vĩnh viễn
    public function delete($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;

            Post::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
}
