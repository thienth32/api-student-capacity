<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\MajorSkill;
use App\Models\Skill;
use Carbon\Carbon;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    use TUploadImage;

    public function __construct(
        private Skill $skill,
        private Major $major,
        private MajorSkill $majorSkill
    ) {
    }
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $major = $request->has('major_id') ? $request->major_id : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $timeDay = $request->has('day') ? $request->day : Null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('skill_soft_delete') ? $request->skill_soft_delete : null;

        if ($softDelete != null) {
            $query = $this->skill::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->skill::where('name', 'like', "%$keyword%");
        if ($major != null) {
            $query = $this->major::find($major);
        }
        if ($timeDay != null) {
            $current = Carbon::now();
            $query->where('created_at', '>=', $current->subDays($timeDay));
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        // dd($query->get());
        return $query;
    }
    // Danh sách teams phía view
    public function index(Request $request)
    {
        try {
            $dataMajor = $this->major::where('parent_id', 0)->get();
            $dataSkill = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            if ($request->major_id) {
                $dataSkill = $this->getList($request)->Skill()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }
            return view('pages.skill.index', compact('dataSkill', 'dataMajor'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'lỗi'
            ]);
        };
    }
    // chi tiết skill
    public function detail(Request $request, $id)
    {
        try {
            $data = $this->skill::find($id);

            return view('pages.skill.detailSkill', compact('data'));
        } catch (\Throwable $th) {
            return redirect(abort(404));
        };
    }
    public function create(Request $request)
    {
        try {
            $dataMajor = $this->major::where('parent_id', 0)->get();
            return view('pages.skill.form-add', compact('dataMajor'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '404 not phao'
            ]);
        };
    }
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:skills,name',
                'short_name' => 'required|max:20|unique:skills,short_name',

                'image_url' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'description' => 'required'
            ],
            [

                'name.required' => 'Chưa nhập trường này !',
                'name.unique' => 'trường name đã tồn tại !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'short_name.required' => 'Chưa nhập trường này !',
                'short_name.max' => 'Độ dài kí tự không phù hợp !',
                'short_name.unique' => 'Đã tồn tại trường này !',
                'image_url.mimes' => 'Sai định dạng !',
                'image_url.required' => 'Chưa nhập trường này !',
                'image_url.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'description.required' => 'Chưa nhập trường này !',
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
                'short_name' => $request->short_name
            ];

            if ($request->has('image_url')) {
                $fileImage =  $request->file('image_url');
                $logo = $this->uploadFile($fileImage);
                $data['image_url'] = $logo;
            }
            $newSkill = $this->skill::create($data);
            if ($newSkill) {
                if ($request->major_id != null) {
                    foreach ($request->major_id as $item) {
                        $this->majorSkill::create([
                            'major_id' => $item,
                            'skill_id' => $newSkill->id,
                        ]);
                    }
                }
            }
            Db::commit();
            return redirect()->route('admin.skill.index');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function edit(Request $request, $id)
    {

        $data =  $this->skill::find($id);
        $dataMajor = $this->major::where('parent_id', 0)->get();

        return view('pages.skill.form-edit', compact('data', 'dataMajor'));
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:skills,name,' . $id,
                'short_name' => 'required|max:20|unique:skills,short_name,' . $id,
                'description' => 'required'
            ],
            [

                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'name.unique' => 'Đã tồn tại trường này !',
                'short_name.required' => 'Chưa nhập trường này !',
                'short_name.max' => 'Độ dài kí tự không phù hợp !',
                'short_name.unique' => 'Đã tồn tại trường này !',


                'description.required' => 'Chưa nhập trường này !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $skill = $this->skill::find($id);
            if (!$skill) {
                return redirect('error');
            }
            $skill->name = $request->name;
            $skill->description = $request->description;
            if ($request->has('image_url')) {
                $fileImage =  $request->file('image_url');
                $logo = $this->uploadFile($fileImage);
                $skill->image_url = $logo;
            }
            $skill->save();
            if ($request->major_id != null) {

                MajorSkill::where('skill_id', $id)->delete();
                foreach ($request->major_id as $item) {
                    $this->majorSkill::create([
                        'major_id' => $item,
                        'skill_id' => $id,
                    ]);
                }
            } else {
                $this->majorSkill::where('skill_id', $id)->delete();
            }
            Db::commit();
            return redirect()->route('admin.skill.index');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = $this->skill::find($id))) return false;
                if (Storage::disk('s3')->has($data->image_url)) Storage::disk('s3')->delete($data->image_url);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function softDelete(Request $request)
    {
        $listSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

        return view('pages.skill.skill-soft-delete', compact('listSofts'));
    }
    public function backUpSkill($id)
    {
        try {
            $this->skill::withTrashed()->where('id', $id)->restore();
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

            $this->skill::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
}