<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;
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
        if ($data = $this->getList()) {
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
        return view('pages.major.create');
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
        ]);
        return redirect()->route('admin.major.list');;
    }

    public function edit(Request $request, $slug)
    {
        if ($major = $this->getMajor($slug)) {
            return view('pages.major.edit', ['major' => $major->first()]);
        }
        return abort(404);
    }

    public function update(Request $request, $slug)
    {
        if (!($major = $this->getMajor($slug))) return abort(404);
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
        $major->update([
            'name' => $request->name,
            'slug' => $slug,
        ]);
        return redirect()->route('admin.major.list');
    }

    public function destroy($slug)
    {
        if (!($major = $this->getMajor($slug))) return abort(404);
        $major->delete();
        return redirect()->back();
    }
}