<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class StatController extends Controller
{
    use TUploadImage, TResponse;
    private $stat;

    public function __construct(Stat $stat)
    {
        $this->stat = $stat;
    }

    public function index(Request $request) {
        try {
            $type = $request->type ?? 1;
            $stats = $this->stat::where('type', $type)
                ->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
                
            return view('pages.stats.list', compact('stats', 'type'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function create(Request $request) {
        $type = $request->type ?? 1;

        return view('pages.stats.create', compact('type'));
    }

    public function store(Request $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'data' => $request->data,
                'type' => $request->query('type')
            ];
            if ($request->hasFile('icon')) {
                $icon = $this->uploadFile($request->file('icon'));
                if (!$icon)  return redirect()->back()->with('error', 'Thêm mới thất bại !');
                $data['icon'] = $icon;
            }
            $this->stat->create($data);
            
            return redirect()->route('admin.stat.list')->with('success', 'Thêm thông số thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(Stat $stat) {
        return view('pages.stats.edit', compact('stat'));
    }

    public function update(Stat $stat, Request $request) {
        try {
            $data = [
                'name' => $request->name,
                'status' => $request->status,
                'data' => $request->data,
            ];
            
            if ($request->hasFile('icon')) {
                $icon = $this->uploadFile($request->file('icon'), $stat->icon);
                if (!$icon) {
                    return redirect()->back()->with('error', 'Thêm mới thất bại !');
                } 
                $data['icon'] = $icon;
            }
            $stat->update($data);
            
            return redirect()->route('admin.stat.list')->with('success', 'Sửa thông số thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Stat $stat) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            $stat->delete();

            return redirect()->back()->with('success', 'Xóa thông số thành công');;
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**API for client */
    public function getListStats() {
        $data = $this->stat::get();
        if (!$data) abort(404);
        
        return $this->responseApi(true, $data);
    }
}
