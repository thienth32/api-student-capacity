<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skill\RequestsSkill;
use App\Models\Major;
use App\Models\MajorSkill;
use App\Models\Skill;
use App\Services\Modules\MSkill\Skill as MSkillSkill;
use App\Services\Traits\TResponse;
use Carbon\Carbon;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    use TUploadImage, TResponse;
    public function __construct(

        private Major $major,
        private MSkillSkill $modulesSkill,
        private Skill $skill,
        private MajorSkill $majorSkill,
        private DB $db,
        private Storage $storage
    ) {
    }

    // Danh sách skills phía view
    public function index(Request $request)
    {
        try {
            $dataMajor = $this->major::all();
            $dataSkill =  $this->modulesSkill->index($request);
            return view('pages.skill.index', compact('dataSkill', 'dataMajor'));
        } catch (\Throwable $th) {

            return redirect('error');
        };
    }

    // chi tiết skill
    public function detail($id)
    {
        try {
            $data = $this->modulesSkill->find($id);

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
            return redirect('error');
        };
    }

    public function store(RequestsSkill $request)
    {

        $this->db::beginTransaction();
        try {
            $this->modulesSkill->store($request);
            $this->db::commit();
            return redirect()->route('admin.skill.index');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        }
    }

    public function edit(Request $request, $id)
    {

        $data =  $this->skill::find($id);
        $dataMajor = $this->major::where('parent_id', 0)->get();

        return view('pages.skill.form-edit', compact('data', 'dataMajor'));
    }

    public function update($id, RequestsSkill $request)
    {
        DB::beginTransaction();
        try {
            $this->modulesSkill->update($request, $id);
            $this->db::commit();
            return redirect()->route('admin.skill.index');
        } catch (\Throwable $th) {
            $this->db::rollBack();
            return redirect('error');
        }
    }

    public function destroy($id)
    {

        try {
            if (!(auth()->user()->hasRole('super admin'))) return abort(404);
            $this->db::transaction(function () use ($id) {
                if (!($data = $this->skill::find($id))) return abort(404);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function softDelete(Request $request)
    {
        $listSofts = $this->modulesSkill->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

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
            if (!(auth()->user()->hasRole('super admin'))) return abort(404);
            $this->skill::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function indexApi()
    {
        $skills = $this->modulesSkill->getAll();
        return $this->responseApi(true, $skills);
    }
}