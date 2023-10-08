<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Traits\TResponse;
use App\Models\Branch;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    use TResponse;
    private $branch;
    public function __construct(Branch $branch)
    {
        $this->branch = $branch;
    }

    private function getList()
    {
        try {
            $dataBranch = Branch::sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'branches')
                ->withCount(['users'])
                ->where('status', 1)
                ->search(request('q') ?? null, ['name']);
            return $dataBranch;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function apiIndex()
    {
        try {
            $data = $this->getList();
            return $this->responseApi(true, $data->get());
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    public function index()
    {
        $data = $this->getList();

        if ($data) {
            return  view('pages.branch.index', [
                'branches' => $data->paginate(request('limit') ?? 10),
            ]);
        }

        return abort(404);
    }

    private function getBranch($branch_id)
    {
        try {
            $branch = $this->branch::where('id', $branch_id);
            return $branch;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function create()
    {
        return view('pages.branch.create');
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Không được bỏ trống tên !',
            ]
        );
        $this->branch::create([
            'name' => $request->name,
            'code' => $request->code ?? '',
            'description' => $request->description ?? '',
            'logo' => $request->logo ?? '',
            'address' => $request->address ?? '',
            'phone' => $request->phone ?? '',
            'status' => $request->status ?? 1,
        ]);
        return redirect()->route('admin.branch.list');
    }

    private function getCurrentBranchAdmin($branch_id)
    {
        return User::role('admin')->select('id', 'name', 'branch_id')
            ->where('branch_id', $branch_id)->first();
    }

    private function getNoBranchAdmins()
    {
        $admins = User::role('admin')->select('id', 'name', 'branch_id')
            ->where(function ($query) {
                $query->where('branch_id', '=', 0)->orWhere('branch_id', '=', null);
            })->get();
        $emptyAdmin = new User();
        $emptyAdmin->id = 0;
        $emptyAdmin->name = 'Không chọn ai!';
        $admins->prepend($emptyAdmin);

        return $admins;
    }

    private function getCurrentBranchStaffs($branch_id)
    {
        return User::role('staff')->select('id', 'name', 'branch_id')
            ->where('branch_id', $branch_id)->get();
    }

    private function getNoBranchStaffs()
    {
        $staffs = User::role('staff')->select('id', 'name', 'branch_id')
            ->where(function ($query) {
                $query->where('branch_id', '=', 0)->orWhere('branch_id', '=', null);
            })->get();

        return $staffs;
    }

    public function edit(Request $request, $branch_id)
    {
        if ($branch = $this->getBranch($branch_id)) {
            $admins = $this->getNoBranchAdmins();
            $currentBranchAdmin = $this->getCurrentBranchAdmin($branch_id);
            if ($currentBranchAdmin) {
                $admins->push($currentBranchAdmin);
            }

            $staffs = $this->getNoBranchStaffs();
            $currentBranchStaffs = $this->getCurrentBranchStaffs($branch_id);
            if (count($currentBranchStaffs)) {
                $staffs = $staffs->concat($currentBranchStaffs);
            }

            return view('pages.branch.edit', [
                'branch' => $branch->first(),
                'admins' => $admins,
                'currentBranchAdmin' => $currentBranchAdmin,
                'staffs' => $staffs,
                'currentBranchStaffs' => $currentBranchStaffs,
            ]);
        }
        return abort(404);
    }

    public function update(Request $request, $branch_id)
    {
        if (!($branch = $this->getBranch($branch_id))) return abort(404);

        $authUserRoles = auth()->user()->roles->pluck('name')->toArray();

        if (in_array('admin', $authUserRoles) && !in_array('super admin', $authUserRoles)) {
            $currentBranchStaffs = $this->getCurrentBranchStaffs($branch_id);
            $newStaffIds = $request->branch_staff_ids ?? [];
            User::whereIn('id', $currentBranchStaffs->pluck('id'))->update(['branch_id' => 0]);
            User::whereIn('id', $newStaffIds)->update(['branch_id' => $branch_id]);

            return redirect()->route('admin.branch.list');
        }

        $request->validate(
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Không được bỏ trống tên !',
            ]
        );
        DB::beginTransaction();
        try {
            $branch->update([
                'name' => $request->name,
                'code' => $request->code,
                'description' => $request->description,
                'logo' => $request->logo,
                'address' => $request->address,
                'phone' => $request->phone,
                'status' => $request->status,
                'email' => $request->email,
                'website' => $request->website,
            ]);

            $currentBranchAdmin = $this->getCurrentBranchAdmin($branch_id);
            $newAdminId = $request->branch_admin_id;
            if ($currentBranchAdmin && $newAdminId !== $currentBranchAdmin->id) {
                $currentBranchAdmin->branch_id = 0;
                $currentBranchAdmin->save();
            }
            if ($newAdminId) {
                User::where('id', $newAdminId)->update(['branch_id' => $branch_id]);
            }

            $currentBranchStaffs = $this->getCurrentBranchStaffs($branch_id);
            $newStaffIds = $request->branch_staff_ids ?? [];
            User::whereIn('id', $currentBranchStaffs->pluck('id'))->update(['branch_id' => 0]);
            User::whereIn('id', $newStaffIds)->update(['branch_id' => $branch_id]);

            DB::commit();

            return redirect()->route('admin.branch.list');
        } catch (Exception $e) {
            DB::rollBack();

            return abort(404);
        }
    }

    public function destroy($branch_id)
    {

        if (!($branch = $this->getBranch($branch_id))) return abort(404);

        $branch->delete();
        return redirect()->back();
    }

    public function listRecordSoftDeletes()
    {
        if ($data = $this->getList()->onlyTrashed()) {
            return  view('pages.branch.soft-deletes', [
                'branches' => $data->paginate(request('limit') ?? 10),
            ]);
        }
        return abort(404);
    }
    public function permanently_deleted($branch_id)
    {
        $branch = Branch::withTrashed()->where('branch_id', $branch_id)->first();
        $branch->forceDelete();
        return redirect()->back();
    }
    public function restore_deleted($branch_id)
    {
        $branch = Branch::withTrashed()->where('branch_id', $branch_id)->first();
        $branch->restore();
        return redirect()->back();
    }
}
