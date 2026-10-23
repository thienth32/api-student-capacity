<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MentorInfo;
use App\Models\User;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MentorController extends Controller
{
    use TResponse, TUploadImage;
    protected $mentor;
    protected $mentorInfo;

    public function __construct(User $mentor, MentorInfo $mentorInfo, Role $role)
    {
        $this->mentor = $mentor;
        $this->mentorInfo = $mentorInfo;
    }

    private function getList(Request $request) 
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = $this->mentor::where('name', 'like', "%$keyword%")
            ->whereHas('roles', function (Builder $query) {
                $query->where('id', config('util.MENTOR_ROLE'));
            })
            ->with('info');

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        
        return $query;
    }

    public function index(Request $request) {
        try {
            $mentors = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            $availableMentors = $this->mentor::select('id', 'name', 'email')
                ->where('status', 1)
                ->whereDoesntHave('roles', function (Builder $query) {
                    $query->whereIn('id', [config('util.MENTOR_ROLE'), config('util.SUPER_ADMIN_ROLE'), config('util.ADMIN_ROLE')]);
                })
                ->get();

            return view('pages.mentors.list', compact('mentors', 'availableMentors'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function addMentorsHaveAccount(Request $request)
    {
        try {
            $request->validate([
                'mentor_ids' => 'required|array',
                'mentor_ids.*' => 'exists:users,id'
            ]);
            $role = Role::find(config('util.MENTOR_ROLE'));
            foreach ($request->mentor_ids as $mentorId) {
                $user = $this->mentor::find($mentorId);
                $user->syncRoles($role->name);
            }

            return back()->with('success', 'Thêm mentors thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function addMentorNoAccount(Request $request)
    {
        try {
            DB::beginTransaction();
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            //kiểm tra có up avatar không?
            if ($request->hasFile('avatar')) {
                $avatar = $this->uploadFile($request->file('avatar'));
                if (!$avatar) {
                    return redirect()->back()->with('error', 'Upload ảnh thất bại!');
                }
                $userData['avatar'] = $avatar;
            }
            $user = $this->mentor::create($userData); //tạo bản ghi trong bảng user
            //set role mentor cho user mới tạo
            $role = Role::find(config('util.MENTOR_ROLE'));
            $user->syncRoles($role->name);

            //lưu mentor_infos
            $user->info()->create([
                'location' => $request->location,
                'experience' => $request->experience,
                'education' => $request->education,
                'position' => $request->position,
                'note' => $request->note,
            ]);
            DB::commit();
            
            return back()->with('success', 'Thêm mentors thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            
            return back()->with('error', $th->getMessage());
        }
    }

    public function saveInfo(Request $request)
    {
        try {
            $this->mentorInfo::updateOrCreate(
                ['mentor_id' => $request->mentor_id],
                [
                'location' => $request->location,
                'experience' => $request->experience,
                'education' => $request->education,
                'position' => $request->position,
                'note' => $request->note,
            ]);
    
            return back()->with('success', 'Cập nhật thành công');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(User $mentor) {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_ADMINS')))) return false;
            DB::beginTransaction();
            //loại bỏ role mentor của user
            $mentorRole = Role::find(config('util.MENTOR_ROLE'));
            $mentor->removeRole($mentorRole);

            //kiểm tra nếu user không còn role nào khác thì setRole student
            if ($mentor->roles()->count() == 0) {
                $defaultRole = Role::find(config('util.STUDENT_ROLE'));
                $mentor->assignRole($defaultRole);
            }
            $mentor->info->delete();
            DB::commit();

            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect('error');
        }
    }
}
