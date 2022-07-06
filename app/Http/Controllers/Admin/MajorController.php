<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Skill;
use App\Services\Traits\TResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
{
    use TResponse;
    private $major;
    public function __construct(Major $major)
    {
        $this->major = $major;
    }

    private function getMajor($slug)
    {
        try {
            $major = $this->major::where('slug', $slug);
            return $major;
        } catch (\Throwable $th) {
            return false;
        }
    }

    private function addCollectionMajor($major)
    {
        try {
            return $major->withCount('contests');
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function apiShow($slug)
    {
        if (!($major = $this->getMajor($slug))) return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Không tìm thấy major '
            ]
        );
        if (!($major = $this->addCollectionMajor($major))) return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Không lấy được major '
            ]
        );
        return $this->responseApi([
            'status' => true,
            'payload' => $major->first(),
        ]);
    }

    private function getList()
    {
        try {
            $limit = 10;
            $dataMajor = Major::sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'majors')
                ->search(request('q') ?? null, ['name', 'slug']);
            return $dataMajor;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function index()
    {
        $data = $this->getList()->where('parent_id', '=', 0);
        if ($data) {
            return  view('pages.major.index', [
                'majors' => $data->paginate(request('limit') ?? 5),
            ]);
        }
        return abort(404);
    }

    public function apiIndex()
    {
        if ($data = $this->getList()) {
            return $this->responseApi(
                [
                    'status' => true,
                    'payload' => $data->get(),
                ]
            );
        }
        return $this->responseApi(
            [
                'status' => false,
                'payload' => 'Not found '
            ],
            404
        );
    }

    public function create()
    {
        $dataMajor = $this->getList()->where('parent_id', '=', 0)->get();
        return view('pages.major.create', compact('dataMajor'));
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required|min:4',
                'slug' => 'required|unique:majors,slug'
            ],
            [
                'name.required' => 'Không được bỏ trống tên !',
                'slug.required' => 'Không được bỏ trống slug !',
                'name.min' => 'Ký tự tên phải lớn hơn 4 ký tự  !',
                'name.unique' => 'Slug không được trùng !',
            ]
        );
        $slug = \Str::slug($request->slug);
        $this->major::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->major_id
        ]);
        return redirect()->route('admin.major.list');;
    }
    public function edit(Request $request, $slug)
    {
        $dataMajor = Major::where('parent_id', 0)->get();
        if ($major = $this->getMajor($slug)) {
            //   dd( $major->first()->parent);
            return view('pages.major.edit', ['major' => $major->first(), 'dataMajor' => $dataMajor]);
        }
        return abort(404);
    }

    public function update(Request $request, $slug)
    {
        if (!($major = $this->getMajor($slug))) return abort(404);

        $request->validate(
            [
                'name' => 'required|min:4',
                'slug' => 'required|unique:majors,slug,' . $major->first()->id,
            ],
            [
                'name.required' => 'Không được bỏ trống tên !',
                'slug.required' => 'Không được bỏ trống slug !',
                'name.min' => 'Ký tự tên phải lớn hơn 4 ký tự  !',
                'name.unique' => 'Slug không được trùng !',
            ]
        );
        $slug = \Str::slug($request->slug);
        $major->update([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
        ]);
        return redirect()->route('admin.major.list');
    }

    public function destroy($slug)
    {

        if (!($major = $this->getMajor($slug))) return abort(404);
        // $parent_id = Major::where('parent_id', $major->first()->id)->get();
        // foreach ($parent_id as $value) {
        //     Major::destroy($value->id);
        // }
        $major->delete();
        return redirect()->back();
    }

    public function listRecordSoftDeletes()
    {
        if ($data = $this->getList()->onlyTrashed()) {
            return  view('pages.major.soft-deletes', [
                'majors' => $data->paginate(request('limit') ?? 5),
            ]);
        }
        return abort(404);
    }
    public function permanently_deleted($slug)
    {
        $major = Major::withTrashed()->where('slug', $slug)->first();
        $major->forceDelete();
        return redirect()->back();
    }
    public function restore_deleted($slug)
    {
        $major = Major::withTrashed()->where('slug', $slug)->first();
        $major->restore();
        return redirect()->back();
    }
    public function skill($slug)
    {
        $listSkill = Skill::all();
        $major = $this->getList()->where('slug', $slug)->first();
        $skills = $this->getList()->where('slug', $slug)->first()->skill()->paginate(6);
       $parentSkill=$this->getList()->where('slug', $slug)->first()->skill()->get();
        return view('pages.major.skill', compact('skills', 'major', 'listSkill','parentSkill'));
    }
    public function detachSkill($slug, $skill_id)
    {
        try {
            $major = Major::where('slug', $slug)->first();
            Major::find($major->id)->skill()->detach([$skill_id]);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function attachSkill(Request $request,$slug)
    {
        try {
            $major = Major::where('slug', $slug)->first();
            Major::find($major->id)->skill()->syncWithoutDetaching($request->skill_id);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
}
