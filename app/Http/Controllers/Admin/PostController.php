<?php

namespace App\Http\Controllers\Admin;

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

        private Contest $contest,
        private Post $post,
        private MPostPost $modulesPost,
        private Enterprise $enterprise,
        private Recruitment $recruitment,
        private Round $round,
        private DB $db,
        private Storage $storage
    ) {
    }
    public function index(Request $request)
    {
        try {
            $round = null;
            if (request()->has('round_id')) $round = $this->round::find(request('round_id'))->load('contest');

            $contest = $this->contest::where('type', 0)->get();
            $capacity = $this->contest::where('type', 1)->get();
            $recruitments = $this->recruitment::all();
            $rounds = $this->round::all();
            $posts = $this->modulesPost->index($request);

            return view('pages.post.index', [
                'posts' => $posts,
                'contest' => $contest,
                'capacity' => $capacity,
                'recruitments' => $recruitments,
                'rounds' => $rounds,
                'round' => $round
            ]);
        } catch (\Throwable $th) {
            return redirect('error');
        };
    }

    public function getModelDataStatus($id)
    {
        return $this->modulesPost->find($id);
    }


    public function create(Request $request)
    {
        $this->db::beginTransaction();
        try {
            $contest = $this->contest::where('type', 0)->get();
            $capacity = $this->contest::where('type', 1)->get();
            $recruitments = $this->recruitment::all();
            $rounds = $this->round::all();

            $this->db::commit();
            return view(
                'pages.post.form-add',
                [
                    'capacity' => $capacity,
                    'contest' => $contest,
                    'recruitments' => $recruitments,
                    'rounds' => $rounds
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
            $contest =  $this->contest::where('type', 0)->get();
            $capacity = $this->contest::where('type', 1)->get();
            $recruitments = $this->recruitment::all();
            $rounds = $this->round::all();

            $this->db::commit();
            return view(
                'pages.post.form-add-outside',
                [
                    'capacity' => $capacity,
                    'contest' => $contest,
                    'recruitments' => $recruitments,
                    'rounds' => $rounds,
                    'capacity' => $capacity,
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
            $this->modulesPost->store($request);
            $this->db::commit();

            return Redirect::route('admin.post.list');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
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

        $this->db::beginTransaction();
        try {
            $round = null;
            $contest = $this->contest::where('type', 0)->get();
            $capacity = $this->contest::where('type', 1)->get();
            $recruitments = $this->recruitment::all();
            $post = $this->modulesPost->getList($request)->where('slug', $slug)->first();
            $post->load('postable');
            if ($post->postable && (get_class($post->postable) == $this->round::class)) {
                $round = $this->round::find($post->postable->id)->load('contest');
            }

            return view('pages.post.form-edit', [
                'round' => $round,
                'post' => $post,
                'recruitments' => $recruitments,
                'contest' => $contest,
                'capacity' => $capacity,
                'rounds' => $this->round::all(),

            ]);
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return abort(404);
        };
    }
    public function update(RequestsPost $request, $id)
    {


        DB::beginTransaction();
        try {

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
}
