<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enterprise\RequestsEnterprise;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Services\Modules\MEnterprise\Enterprise as MEnterpriseEnterprise;
use Illuminate\Http\Request;
use App\Services\Traits\TUploadImage;
use App\Services\Traits\TStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\Traits\TResponse;

class EnterpriseController extends Controller
{
    use TUploadImage;
    use TResponse, TStatus;

    public function __construct(
        private Contest $contest,
        private Enterprise $enterprise,
        private DB $db,
        private Storage $storage,
        private MEnterpriseEnterprise $modulesEnterprise,
    ) {
    }
    /**
     * @OA\Get(
     *     path="/api/public/enterprise",
     *     description="Description api enterprise",
     *     tags={"Enterprise"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *         @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Các doanh nghiệp hiện thị ở trag chủ status = 1 , status = 0 là các doanh nghiệp kh hiện thị",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="contest_id",
     *         in="query",
     *         description="Tài trọ cho các cuộc thi",
     *         required=false,
     *     ),
     *
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiIndex(Request $request)
    {
        $data = $this->modulesEnterprise->index($request);
        $data->load(['recruitment:id,name', 'recruitment.contest:id,name']);
        return $this->responseApi(
            true,
            $data
        );
    }
    public function index(Request $request)
    {
        $contest =  $this->contest::all();

        $listEnterprise = $this->modulesEnterprise->index($request);
        return view('pages.enterprise.index', compact('listEnterprise', 'contest'));
    }
    public function getModelDataStatus($id)
    {
        return $this->modulesEnterprise->find($id);
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return abort(404);
            $this->db::transaction(function () use ($id) {
                if (!($data = $this->enterprise::find($id))) return abort(404);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function create(Request $request)
    {
        return view('pages.enterprise.form-add');
    }
    public function store(RequestsEnterprise $request)
    {
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'link_web' => $request->link_web,

            ];

            $logo = $this->uploadFile($request->file('logo'));
            if (!$logo)  return redirect()->back()->with('error', 'Thêm mới thất bại !');
            $data['logo'] = $logo;
            $this->modulesEnterprise->store($data, $request);
            return redirect()->route('admin.enterprise.list');
        } catch (\Throwable $th) {

            return redirect('error');
        }
    }
    public function edit($id)
    {
        $enterprise = $this->enterprise::find($id);
        // dd($enterprise);
        if ($enterprise) {
            return view('pages.enterprise.form-edit', compact('enterprise'));
        }
        return false;
    }
    public function update($id, RequestsEnterprise $request)
    {
        $this->db::beginTransaction();
        try {
            $this->modulesEnterprise->update($request, $id);
            $this->db::commit();

            return redirect()->route('admin.enterprise.list');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        }
    }
    public function softDelete(Request $request)
    {
        $listSofts = $this->modulesEnterprise->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

        return view('pages.enterprise.enterprise-soft-delete', compact('listSofts'));
    }
    public function backUpEnterprise($id)
    {
        try {
            $this->enterprise::withTrashed()->where('id', $id)->restore();
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

            $this->enterprise::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/public/enterprise/{id}",
     *     description="Description api enterprise",
     *     tags={"Enterprise"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id doanh nghiệp",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiDetail($id)
    {
        $data = $this->enterprise::find($id);
        $data->load('recruitment:id,name');

        return $this->responseApi(true, $data);
    }
}
