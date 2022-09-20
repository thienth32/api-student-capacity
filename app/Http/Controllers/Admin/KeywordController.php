<?php

namespace App\Http\Controllers\admin;

use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use App\Services\Traits\TStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Keyword\RequestKeyword;
use App\Models\Keyword;
use App\Services\Modules\MKeyword\Keyword as MKeywordKeyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KeywordController extends Controller
{

    use TResponse, TStatus;
    public function __construct(

        private DB $db,
        private Keyword $keyword,
        private MKeywordKeyword $modulesKeyword,
        private Storage $storage
    ) {
    }
    public function index(Request $request)
    {

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
    }
    public function insert(Request $request)
    {
        try {
            return view('pages.keyword.form-add');
        } catch (\Throwable $th) {
            return redirect('error');
        };
    }
    public function store($request)
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
    public function update(RequestKeyword $request, $id)
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
