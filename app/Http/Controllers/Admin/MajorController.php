<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;

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
                ->search(request('search') ?? null, ['name', 'slug'])
                ->paginate(request('limit') ?? $limit);

            return $dataMajor;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function index()
    {
        if ($data = $this->getList()) {
            return  view('pages.major.index', [
                'majos' => $data,
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
                    'payload' => $data,
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
        try {
            $slug = \Str::slug($request->name);
            $this->major::create([
                'name' => $request->name,
                'slug' => $slug,
            ]);
            return;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}