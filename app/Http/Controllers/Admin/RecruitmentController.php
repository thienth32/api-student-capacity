<?php

namespace App\Http\Controllers\Admin;

use App\Services\Traits\TUploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RequestsRecruitment;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Recruitment;
use App\Services\Modules\MRecruitment\Recruitment as MRecruitmentRecruitment;
use Carbon\Carbon;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecruitmentController extends Controller
{
    use TUploadImage;
    use TResponse;

    public function __construct(

        private Contest $contest,
        private MRecruitmentRecruitment $modulesRecruitment,
        private Enterprise $enterprise,
        private Recruitment $recruitment,
        private DB $db,
        private Storage $storage
    ) {
    }

    public function index(Request $request)
    {
        try {
            $enterprises = $this->enterprise::all();
            $contests = $this->contest::where('type', 1)->get();
            $recruitments = $this->modulesRecruitment->index($request);
            return view('pages.recruitment.index', [
                'recruitments' => $recruitments,
                'enterprises' => $enterprises,
                'contests' => $contests
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('error');
        };
    }
    public function create(Request $request)
    {

        DB::beginTransaction();
        try {
            $enterprise = $this->enterprise::all();
            $contest = $this->contest::where('type', 1)->get();
            DB::commit();
            return view('pages.recruitment.form-add', ['enterprise' => $enterprise, 'contest' => $contest]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }
    public function store(RequestsRecruitment $request)
    {

        DB::beginTransaction();
        try {
            $this->modulesRecruitment->store($request);
            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) abort(404);
            DB::transaction(function () use ($id) {
                if (!($data = $this->recruitment::find($id))) abort(404);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function edit(Request $request, $id)
    {

        $data =  $this->modulesRecruitment->find($id);
        $enterprises = $this->enterprise::all();
        $contests = $this->contest::where('type', 1)->get();

        return view('pages.recruitment.form-edit', compact('data', 'enterprises', 'contests'));
    }
    public function update(RequestsRecruitment $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->modulesRecruitment->update($request, $id);

            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function listRecordSoftDeletes(Request $request)
    {
        $listSofts = $this->modulesRecruitment->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return view('pages.recruitment.soft-delete', compact('listSofts'));
    }
    public function backUpRecruitment($id)
    {
        try {
            $this->recruitment::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    //xóa vĩnh viễn
    public function delete($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) abort(404);
            $this->recruitment::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function detail($id)
    {
        $data = $this->modulesRecruitment->find($id);

        return view('pages.recruitment.detailRecruitment', compact('data'));
    }
    public function apiShow(Request $request)
    {
        $data = $this->modulesRecruitment->getList($request)->paginate(request('limit') ?? config('util.HOMEPAGE_ITEM_AMOUNT'));
        if (!$data) abort(404);
        $data->load('contest');
        $data->load('enterprise');
        return $this->responseApi(
            true,
            $data,
        );
    }
    public function apiDetail($id)
    {
        $data = $this->modulesRecruitment->find($id);
        if (!$data) abort(404);
        $data->load('contest');
        $data->load('enterprise');
        return $this->responseApi(
            true,
            $data
        );
    }
}
