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

class EnterpriseController extends Controller
{
    use TUploadImage;
    private function getList(Request $request)
    {

        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';

        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $query = Enterprise::where('name', 'like', "%$keyword%");
        if ($contest != null) {
            $query = Contest::where('id', $contest);
            return $query;
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        return $query;
    }
    public function index(Request $request)
    {


        $contest = Contest::all();
        if ($request->contest) {

            $Enterprise = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

//          foreach($Enterprise[0]->enterprise as $item){
//              echo '<pre>';
// var_dump($item);
//          };
//          die();
            return view('pages.enterprise.index', compact('Enterprise', 'contest'));
        }
        $listEnterprise = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return view('pages.enterprise.index', compact('listEnterprise', 'contest'));
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = Enterprise::find($id))) return false;
                if (Storage::disk('google')->has($data->logo)) Storage::disk('google')->delete($data->logo);
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
                'name' => 'required',
                'description' => "required",

            ],
            [
                'name.required' => 'Trường name không bỏ trống',
                'description.required' => 'Trường mô tả không bỏ trống',

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
            ];

            if ($request->has('logo')) {
                $fileImage =  $request->file('logo');
                $logo = $this->uploadFile($fileImage);
                $data['logo'] = $logo;
            }

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
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'description' => "required",

            ],
            [
                'name.required' => 'Trường name không bỏ trống',
                'description.required' => 'Trường mô tả không bỏ trống',

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
}
