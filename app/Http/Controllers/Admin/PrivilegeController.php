<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Privilege\RequestPrivilege;
use App\Models\Privilege;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class PrivilegeController extends Controller
{
    use TUploadImage, TResponse;
    protected $privilege;

    public function __construct(Privilege $privilege)
    {
        $this->privilege = $privilege;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->privilege::where('title', 'like', "%$keyword%");

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $privileges = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
                
            return view('pages.privileges.list', compact('privileges'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        return view('pages.privileges.create');
    }

    public function store(RequestPrivilege $request) {
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'register_deadline' => $request->register_deadline,
                'expire_date' => $request->expire_date,
                'link' => $request->link,
            ];
            $thumbnail = $this->uploadFile($request->file('thumbnail'));
            if (!$thumbnail)  return redirect()->back()->with('error', 'Upload ảnh thất bại !');
            $data['thumbnail'] = $thumbnail;
            $this->privilege->create($data);
            
            return redirect()->route('admin.privilege.list')->with('success', 'Thêm đặc quyền sinh viên thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Privilege $privilege) {
        return view('pages.privileges.edit', compact('privilege'));
    }

    public function update(Privilege $privilege, RequestPrivilege $request) {
        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'register_deadline' => $request->register_deadline,
                'expire_date' => $request->expire_date,
                'link' => $request->link,
            ];

            // nếu có upload ảnh mới
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $this->uploadFile($request->file('thumbnail'), $privilege->thumbnail);
                if (!$thumbnail) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $data['thumbnail'] = $thumbnail;
            }
            $privilege->update($data);
            
            return redirect()->route('admin.privilege.list')->with('success', 'Sửa đặc quyền sinh viên thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Privilege $privilege) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $privilege->delete();

            return redirect()->back()->with('success', 'Xóa đặc quyền sinh viên thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**API for client */
    public function getPrivileges(Request $request)
    {
        $data = $this->getList($request)
            ->paginate(20);
        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }
}
