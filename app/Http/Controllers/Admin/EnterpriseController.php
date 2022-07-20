<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enterprise\RequestsEnterprise;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Services\Modules\MEnterprise\Enterprise as MEnterpriseEnterprise;
use Illuminate\Http\Request;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\Traits\TResponse;

class EnterpriseController extends Controller
{
    use TUploadImage;
    use TResponse;

    public function __construct(
        private Contest $contest,
        private Enterprise $enterprise,
        private DB $db,
        private Storage $storage,
        private MEnterpriseEnterprise $modulesEnterprise,
    ) {
    }
    public function apiIndex(Request $request)
    {
        $listEnterprise = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return $this->responseApi(
            [
                "status" => true,
                "payload" => $listEnterprise,
            ]
        );
    }
    public function index(Request $request)
    {
        $contest =  $this->contest::all();

        $listEnterprise = $this->modulesEnterprise->index($request);
        return view('pages.enterprise.index', compact('listEnterprise', 'contest'));
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            $this->db::transaction(function () use ($id) {
                if (!($data = $this->enterprise::find($id))) return false;
                if ($this->storage::disk('s3')->has($data->logo)) $this->storage::disk('s3')->delete($data->logo);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
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
    public function apiDetail($id)
    {
        $data = $this->enterprise::find($id);
        $data->load('recruitment');

        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data,
            ]
        );
    }
}
