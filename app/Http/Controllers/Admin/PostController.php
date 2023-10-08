<?php

namespace App\Http\Controllers\Admin;

use App\Models\Major;
use App\Models\Post;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\RequestsPost;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Recruitment;
use App\Models\Round;
use App\Models\User;
use App\Models\Branch;
use App\Services\Modules\MPost\Post as MPostPost;
use App\Services\Traits\TStatus;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//use function GuzzleHttp\Promise\all;

class PostController extends Controller
{
    use TUploadImage;
    use TResponse, TStatus;

    public function __construct(

        private Contest     $contest,
        private Post        $post,
        private MPostPost   $modulesPost,
        private User        $user,
        private Enterprise  $enterprise,
        private Recruitment $recruitment,
        private Round       $round,
        private Branch      $branches,
        private DB          $db,
        private Storage     $storage,
        private Major       $majors
    )
    {
    }

    public function index(Request $request)
    {

        $round = null;
        if (request()->has('round_id')) $round = $this->round::find(request('round_id'))->load('contest');

        $contest = $this->contest::where('type', 0)->get();
        $capacity = $this->contest::where('type', 1)->get();
        $recruitments = $this->recruitment::select('id', 'name')->get();
        $rounds = $this->round::select('id', 'name')->get();
        $posts = $this->modulesPost->index($request);
        $branches = $this->branches::select('id', 'name')->get();

        return view('pages.post.index', [
            'posts' => $posts,
            'contest' => $contest,
            'capacity' => $capacity,
            'recruitments' => $recruitments,
            'rounds' => $rounds,
            'round' => $round,
            'branches' => $branches,
        ]);
    }

    public function getModelDataStatus($id)
    {
        return $this->modulesPost->find($id);
    }

    public function getModelDataHot($id)
    {
        return $this->modulesPost->find($id);
    }

    public function create(Request $request)
    {
        $this->db::beginTransaction();
        try {

            $contest = $this->contest::where('type', 0)->get(['id', 'name']);
            $capacity = $this->contest::where('type', 1)->get(['id', 'name']);
            $users = $this->user::all(['id', 'name', 'email']);
            $recruitments = $this->recruitment::with(['enterprise' => function ($query) {
                $query->select('enterprises.id')->pluck('enterprises.id')->toArray();
            }])->get(['id', 'name']);
            foreach ($recruitments as $recruitment) {
                $recruitment->enterprises_id = $recruitment->enterprise->pluck('id')->toArray();
            }
            $majors = $this->majors::all(['id', 'name']);
            // dd($users);
            $enterprises = $this->enterprise::all(['id', 'name']);
            $rounds = $this->round::all(['id', 'name', 'contest_id']);
            $branches = $this->branches::select('id', 'name')->get();
            $this->db::commit();
            return view(
                'pages.post.form-add',
                [
                    'capacity' => $capacity,
                    'contest' => $contest,
                    'recruitments' => $recruitments,
                    'rounds' => $rounds,
                    'users' => $users,
                    'branches' => $branches,
                    'enterprises' => $enterprises,
                    'majors' => $majors,
                ]
            );
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        };
    }

    public function insert(Request $request)
    {
        $this->db::beginTransaction();
        try {

            $contest = $this->contest::where('type', 0)->get(['id', 'name']);
            $capacity = $this->contest::where('type', 1)->get(['id', 'name']);
            $users = $this->user::all(['id', 'name', 'email']);
            $recruitments = $this->recruitment::with(['enterprise' => function ($query) {
                $query->select('enterprises.id')->pluck('enterprises.id')->toArray();
            }])->get(['id', 'name']);
            foreach ($recruitments as $recruitment) {
                $recruitment->enterprises_id = $recruitment->enterprise->pluck('id')->toArray();
            }
            $majors = $this->majors::all(['id', 'name']);
            // dd($users);
            $enterprises = $this->enterprise::all(['id', 'name']);
            $rounds = $this->round::all(['id', 'name', 'contest_id']);
            $branches = $this->branches::select('id', 'name')->get();
            $this->db::commit();
            return view(
                'pages.post.form-add-outside',
                [
                    'capacity' => $capacity,
                    'contest' => $contest,
                    'recruitments' => $recruitments,
                    'rounds' => $rounds,
                    'capacity' => $capacity,
                    'users' => $users,
                    'branches' => $branches,
                    'enterprises' => $enterprises,
                    'majors' => $majors,
                ]
            );
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        };
    }

    public function store(RequestsPost $request)
    {
        $this->db::beginTransaction();
        try {
            if ($request->post_type !== 'recruitment') $request['code_recruitment'] = null;
            $this->modulesPost->store($request);
            $this->db::commit();
            return Redirect::route('admin.post.list');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return abort(404);
        }
    }

    public function destroy($slug)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return abort(404);
            $this->db::transaction(function () use ($slug) {
                if (!($this->post::where('slug', $slug)->get())) return abort(404);
                $this->post::where('slug', $slug)->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit(Request $request, $slug)
    {


        $round = null;
        $contest = $this->contest::where('type', 0)->get(['id', 'name']);
        $capacity = $this->contest::where('type', 1)->get(['id', 'name']);
        $users = $this->user::all(['id', 'name', 'email']);
        $recruitments = $this->recruitment::with(['enterprise' => function ($query) {
            $query->select('enterprises.id')->pluck('enterprises.id')->toArray();
        }])->get(['id', 'name']);
        foreach ($recruitments as $recruitment) {
            $recruitment->enterprises_id = $recruitment->enterprise->pluck('id')->toArray();
        }
        $majors = $this->majors::all(['id', 'name']);
        // dd($users);
        $enterprises = $this->enterprise::all(['id', 'name']);
        $post = $this->modulesPost->getList($request)->where('slug', $slug)->first();
//        dd($post->major->name);
        $branches = $this->branches::select('id', 'name')->get();
        $post->load(['postable' => function ($q) {
            $q->select('id', 'name');
        }]);
        if ($post->postable && (get_class($post->postable) == $this->round::class)) {
            $round = $this->round::find($post->postable->id)->load('contest:id,name');
        }

        if ($post->postable_type == $this->recruitment::class) {
            $post_type = 'recruitment';
        } elseif ($post->postable_type == $this->round::class) {
            $post_type = 'round';
        } elseif ($post->postable_type == $this->contest::class) {
            $post_type = 'contest';
        } elseif ($post->postable_type == $this->capacity::class) {
            $post_type = 'capacity';
        } else {
            $post_type = 'outside';
        }

        return view('pages.post.form-edit', [
            'round' => $round,
            'post' => $post,
            'recruitments' => $recruitments,
            'contest' => $contest,
            'capacity' => $capacity,
            'rounds' => $this->round::all(['id', 'name', 'contest_id']),
            'users' => $users,
            'branches' => $branches,
            'majors' => $majors,
            'enterprises' => $enterprises,
            'post_type' => $post_type,
        ]);
    }

    public function update(RequestsPost $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->recruitment_id == 0) $request['code_recruitment'] = null;
            $this->modulesPost->update($request, $id);
            Db::commit();
            return Redirect::route('admin.post.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }

    public function detail($slug)
    {
        $data = $this->post::where('slug', $slug)->first();

        return view('pages.post.detailPost', compact('data'));
    }

    public function listRecordSoftDeletes(Request $request)
    {

        $listSofts = $this->modulesPost->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        // dd($listSofts);
        return view('pages.post.soft-delete', compact('listSofts'));
    }

    public function backUpPost($id)
    {
        try {
            $this->post::withTrashed()->where('id', $id)->restore();
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
            if (!(auth()->user()->hasRole('super admin'))) abort(404);

            $this->post::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/public/posts",
     *     description="Description api posts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *        @OA\Parameter(
     *         name="qq",
     *         in="query",
     *         description="Tìm kiếm  tách chuỗi",
     *         required=false,
     *     ),
     *          @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm từ khóa nổi bật cần chuyền keyword_slug",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *
     *         @OA\Parameter(
     *         name="postHot",
     *         in="query",
     *         description="Bài viết tuyển dụng hot,nổi bật (postHot='hot' list bài viết  hot, nổi bật ,
     *         postHot='normal' list  bài viết bthuong",
     *         required=false,
     *         ),
     *     @OA\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *          @OA\Parameter(
     *         name="post",
     *         in="query",
     *         description="  post='post-contest' -> bài viết thuộc cuộc thi
     *         post='post-capacity' -> bài viết thuộc test nl .
     *         post='post-round' -> bài viết thuộc vòng thi .
     *          post='post-recruitment' -> bài viết thuộc tuyển dụng
     * ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="contest_id",
     *         in="query",
     *         description="Bài viết dành riêng  thuộc cuộc thi",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="round_id",
     *         in="query",
     *         description="bài viết dành riêng thuộc vòng thi",
     *         required=false,
     *     ),
     *   @OA\Parameter(
     *         name="capacity_id",
     *         in="query",
     *         description="Bài viết dành riêng thuộc của bài test",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="recruitment_id",
     *         in="query",
     *         description="Bài viết dành riêng thuộc Tuyển dụng",
     *         required=false,
     *     ),
     *
     *
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiShow(Request $request)
    {
        $data = $this->modulesPost
            ->getList($request)
            ->where('published_at', '<=', now())
            ->paginate(request('limit') ?? 12);
        $data->load(
            [
                'postable:id,name',
                'postable.enterprise:enterprises.id,enterprises.name,enterprises.logo,enterprises.link_web',
                'user:id,name,email'
            ]
        )->makeHidden([
            'deleted_at', 'updated_at',
        ]);
        if (!$data) abort(404);
        return $this->responseApi(
            true,
            $data,
        );
    }

    /**
     * @OA\Get(
     *     path="/api/public/posts/{slug}",
     *     description="Description api post",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         description="slug bài viết",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */

    public function view(Request $request)
    {
        $data = $this->modulesPost->updateView($request->id, $request->view);
        return $this->responseApi(
            true,
            $data
        );
    }

    public function apiDetail($slug)
    {
        $data = $this->post::where('slug', $slug)->first();
        $data->load('user:id,name,email');
        if (!$data) abort(404);
        return $this->responseApi(
            true,
            $data
        );
    }
}
