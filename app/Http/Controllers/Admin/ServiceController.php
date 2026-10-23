<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\RequestService;
use App\Models\Service;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use TResponse, TUploadImage;
    private $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "asc";

        $query = $this->service::where('name', 'like', "%$keyword%")
            ->with(['createdBy', 'requests']);

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    /**Admin CRUD */
    public function index(Request $request) {
        try {
            $services = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            
            return view('pages.services.list', compact('services'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function requestList(Service $service, Request $request)
    {
        try {
            $status = $request->status ?? 0;
            $query = $service->requests();
            if ($status == config('util.SERVICE.REQUEST_STATUS.IN_PROGRESS')) { //in_progess
                $query->inProgress();
            }
            if ($status == config('util.SERVICE.REQUEST_STATUS.FINISH')) { //finish
                $query->finish();
            }
            $requests = $query->with(['register'])->paginate(10)->appends(['status' => $status]);
            
            return view('pages.services.requests', compact('service', 'requests', 'status'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create() {
        return view('pages.services.create');
    }

    public function store(RequestService $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'link' => $request->link,
                'created_by' => auth()->user()->id,
            ];
            $thumbnail = $this->uploadFile($request->file('thumbnail'));
            if (!$thumbnail)  return redirect()->back()->with('error', 'Upload ảnh thất bại !');
            $data['thumbnail'] = $thumbnail;
            $this->service->create($data);
            
            return redirect()->route('admin.service.list')->with('success', 'Thêm dịch vụ thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit(Service $service) {
        return view('pages.services.edit', compact('service'));
    }

    public function update(Service $service, RequestService $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'description' => $request->description,
                'short_description' => $request->short_description,
                'link' => $request->link,
            ];
            // nếu có upload ảnh mới
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $this->uploadFile($request->file('thumbnail'), $service->thumbnail);
                if (!$thumbnail) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $data['thumbnail'] = $thumbnail;
            }
            
            $service->update($data);
            
            return redirect()->route('admin.service.list')->with('success', 'Sửa dịch vụ thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Service $service) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $service->delete();

            return redirect()->back()->with('success', 'Xóa dịch vụ thành công');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**API for client */
    public function getServices(Request $request) {
        $data = $this->getList($request)
            ->where('status', config('util.ACTIVE_STATUS'))
            ->limit(6)
            ->get();
        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }

    public function apiDetailEvent(Service $service)
    {
        if (!$service) abort(404);
        $service->load(['createdBy']);

        return $this->responseApi(true, $service);
    }
}
