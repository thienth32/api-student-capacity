<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Judge;
use App\Models\Round;
use App\Models\Result;
use App\Models\Contest;
use App\Models\TakeExam;
use App\Models\RoundTeam;
use App\Models\JudgeRound;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Traits\TStatus;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Keyword\RequestKeyword;
use App\Services\Modules\MKeyword\MKeywordInterface;

class KeywordController extends Controller
{

    use TResponse, TStatus;
    public function __construct(
        private DB $db,
        private MKeywordInterface $keyword,
        private Storage $storage
    ) {
    }
    public function index()
    {
        $data = $this->keyword->list();
        return view('pages.keyword.index', [
            'datas' => $data
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/keywords",
     *     description="Description api keywords",
     *     tags={"Keywords"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function indexApi()
    {
        $data = $this->keyword->getList(request())->get();
        $data->makeHidden([
            'created_at',
            'updated_at',
            'deleted_at'
        ]);
        return $this->responseApi(true, $data);
    }
    public function create()
    {
        try {
            return view('pages.keyword.form-add');
        } catch (\Throwable $th) {
            return redirect('error');
        };
    }
    public function store(RequestKeyword $request)
    {
        $this->db::beginTransaction();
        try {
            $this->keyword->store($request->all());
            $this->db::commit();
            return redirect()->route('admin.keyword.list');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        }
    }
    public function destroy($id)
    {
        try {
            $data = $this->keyword->find($id);
            if (is_null($data)) {
                return abort('error');
            } else {
                $data->delete();
                return redirect()->route('admin.keyword.list');
            }
        } catch (\Throwable $th) {
            return abort('error');
        }
    }
    public function edit(Request $request, $id)
    {

        try {
            $data = $this->keyword->find($id);
            if (is_null($data)) {
                return redirect()->route('admin.keyword.list');
            } else {

                return view('pages.keyword.form-edit', compact('data'));
            }
        } catch (\Throwable $th) {
            return abort('error');
        };
    }
    public function update(RequestKeyword $request, $id)
    {

        $this->db::beginTransaction();
        try {
            $data = $this->keyword->find($id);
            if (is_null($data)) {
                return redirect()->back();
            } else {
                $data->update($request->all());
                $this->db::commit();
                return redirect()->route('admin.keyword.list');
            }
        } catch (\Throwable $th) {
            $this->db::rollBack();
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

    public function getModelDataStatus($id)
    {
        return $this->keyword->find($id);
    }
}