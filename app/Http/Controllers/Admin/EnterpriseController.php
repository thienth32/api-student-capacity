<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Enterprise;
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
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';

        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('enterprise_soft_delete') ? $request->enterprise_soft_delete : null;

        if ($softDelete != null) {
            $query = Enterprise::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = Enterprise::where('name', 'like', "%$keyword%");
        if ($contest != null) {
            $query = Contest::find($contest);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        return $query;
    }
    public function apiIndex(Request $request)
    {
        $listEnterprise = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return response()->json([
            'status' => true,
            'payload' => $listEnterprise,
        ]);
    }
    public function index(Request $request)
    {
        $contest = Contest::all();

        $listEnterprise = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        if ($request->contest) {
            $listEnterprise = $this->getList($request)->enterprise()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        }
        return view('pages.enterprise.index', compact('listEnterprise', 'contest'));
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = Enterprise::find($id))) return false;
                if (Storage::disk('s3')->has($data->logo)) Storage::disk('s3')->delete($data->logo);
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
    public function store(Request $request)
    {
        // dd($request->all);
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:enterprises,name',
                'description' => "required",
                'logo' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'link_web' => "required",
            ],
            [
                'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                'name.unique' => '???? t???n t???i tr?????ng n??y',
                'description.required' => 'Ch??a nh???p tr?????ng n??y !',
                'link_web.required' => 'Ch??a nh???p tr?????ng n??y !',
                'logo.mimes' => 'Sai ?????nh d???ng !',
                'logo.required' => 'Ch??a nh???p tr?????ng n??y !',
                'logo.max' => 'Dung l?????ng ???nh kh??ng ???????c v?????t qu?? 10MB !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'link_web' => $request->link_web,

            ];
        
            $logo = $this->uploadFile($request->file('logo'));
            if(!$logo)  return redirect()->back()->with('error', 'Th??m m???i th???t b???i !'); 
            $data['logo'] = $logo;
          

            Enterprise::create($data);
            Db::commit();

            return redirect()->route('admin.enterprise.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function edit($id)
    {
        $enterprise = Enterprise::find($id);
        // dd($enterprise);
        if ($enterprise) {
            return view('pages.enterprise.form-edit', compact('enterprise'));
        }
        return false;
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:enterprises,name,' . $id,
                'description' => "required",
                'link_web' => "required",
            ],
            [
                'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                'name.unique' => '???? t???n t???i tr?????ng n??y',
                'description.required' => 'Ch??a nh???p tr?????ng n??y !',
                'link_web.required' => 'Ch??a nh???p tr?????ng n??y !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $enterprise = Enterprise::find($id);
            if (!$enterprise) {
                return false;
            }
            $enterprise->name = $request->name;
            $enterprise->description = $request->description;
            $enterprise->link_web = $request->link_web;
            if ($request->has('logo')) {
                $fileImage =  $request->file('logo');
                $logo = $this->uploadFile($fileImage);
                $enterprise->logo = $logo;
            }
            $enterprise->save();
            Db::commit();

            return redirect()->route('admin.enterprise.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function softDelete(Request $request)
    {
        $listSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

        return view('pages.enterprise.enterprise-soft-delete', compact('listSofts'));
    }
    public function backUpEnterprise($id)
    {
        try {
            Enterprise::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    //x??a v??nh vi???n
    public function delete($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;

            Enterprise::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function apiDetail($id)
    {
        $data = Enterprise::find($id);
        $data->load('recruitment');

        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data,
            ]
        );
    }
}
