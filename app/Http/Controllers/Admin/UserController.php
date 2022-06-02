<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\User;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Google\Service\Script\Content;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use TUploadImage;
    public function TeamUserSearch(Request $request)
    {
        $users = User::search($request->key ?? null, ['name', 'email'])->take(4)->get();
        if (count($users) == 0) {
            return response()->json([
                'status' => false,
                'payload' => "Tài khoản này không tồn tại !"
            ]);
        } else {
            return response()->json([
                'status' => true,
                'payload' => $users
            ]);
        }
    }

    public function list(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $pageNumber = $request->has('page') ? intval($request->page) : 1;
        $pageSize = $request->has('pageSize') ? intval($request->pageSize) : config('util.DEFAULT_PAGE_SIZE');
        $status = $request->has('status') ? $request->status : config('util.ACTIVE_STATUS');
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = User::with('roles')->where(function ($q) use ($keyword) {
            return $q->where('name', 'like', "%" . $keyword . "%")
                ->orWhere("email", 'like', "%" . $keyword . "%");
        })->where('status', $status);

        if ($request->has('roleId')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('id', $request->roleId);
            });
        }

        $offset = ($pageNumber - 1) * $pageSize;
        $totalItem = $query->count();
        if ($sortBy == 'desc') {
            $query = $query->orderByDesc($orderBy);
        } else {
            $query = $query->orderBy($orderBy);
        }

        $responseData = $query->skip($offset)->take($pageSize)->get();
        return response()->json([
            'status' => true,
            'payload' => [
                'data' => $responseData,
                'pagination' => [
                    'currentPage' => $pageNumber,
                    'pageSize' => $pageSize,
                    'totalItem' =>  $totalItem,
                    'totalPage' => ceil($totalItem / $pageSize)
                ]
            ]
        ]);
    }

    private function getUser()
    {
        try {
            $limit = 10;
            $users = User::status(request('status') ?? null)
                ->sort(request('sort') == 'asc' ? 'asc' : 'desc', request('sort_by') ?? null, 'users')
                ->search(request('q') ?? null, ['name', 'email'])
                ->has_role(request('role') ?? null)
                ->paginate(request('limit') ?? $limit);

            return $users;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function index()
    {
        if (!$users = $this->getUser())    return response()->json(
            [
                'status' => false,
                'payload' => 'Trang không tồn tại !'
            ],
            404
        );
        $users = array_merge(
            $users->toArray(),
            [
                'roles' => Role::all()
                    ->map(function ($role) {
                        return [
                            'value' => $role->id,
                            'slug_name' => \Str::slug($role->name, " "),
                            'name' => \Str::title($role->name),
                        ];
                    })
            ]
        );
        return response()->json(
            [
                'status' => true,
                'payload' => $users
            ],
            200
        );
    }

    public function listAdmin()
    {
        if (!$users = $this->getUser()) return abort(404);
        $roles =  Role::all();
        return view('pages.auth.index', ['users' => $users, 'roles' => $roles]);
    }

    private function checkRole()
    {
        if (auth()->user()->hasAnyRole(['admin', 'super admin'])) return true;
        return false;
    }

    public function un_status($id)
    {
        if (!$this->checkRole())   return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật trạng thái !',
        ]);
        try {
            $user = User::find($id);
            $user->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        if (!$this->checkRole())   return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật trạng thái !',
        ]);
        try {
            $user = User::find($id);
            $user->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }


    public function changeRole(Request $request)
    {

        $data = explode("&&&&", $request->role);

        if (!$role = Role::whereName($data[0])->first()) return response()->json([
            'status' => false,
            'payload' => 'Không có quyền  !',
        ]);
        if (!$user = User::find($data[1])) return response()->json([
            'status' => false,
            'payload' => 'Không tìm thấy tài khoản  !',
        ]);
        if (auth()->user()->id == $user->id) return response()->json([
            'status' => false,
            'payload' => 'Không thể câp nhật quyền của chính mình !',
        ]);
        if (auth()->user()->roles[0]->name == 'super admin') {
            $user->syncRoles($role);
        } else {
            if ($role->name == 'super admin') return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật quyền cao hơn mình cho người khác  !',
            ]);
            if ($user->roles[0]->name == 'super admin') return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật quyền cao nhất  !',
            ]);
            $user->syncRoles($role);
        }
        return response()->json([
            'status' => true,
            'payload' => 'Cập nhật thành công  !',
        ]);
    }

    public function get_user_by_token(Request $request)
    {
        return response([
            'status' => true,
            'payload' => $request->user()->toArray()
        ]);
    }
    public function add_user(Request $request)
    {
        // validator
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài tên không phù hợp!',

                'email.required' => 'Chưa nhập trường này !',
                'email.email' => 'Không đúng định dạng email !',
                'email.max' => 'Độ dài email không phù hợp!',
                'email.unique' => 'Email đã tồn tại!',
            ]
        );
        // dd($validator->errors()->toArray());
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $model = new User();
            $model->fill($request->all());
            $model->save();
            $role = Role::find($request->role_id);
            $model->assignRole($role->name);
            DB::commit();
        } catch (Exception $ex) {
            Log::error("Lỗi tạo tài khoản:");
            Log::info("post data: " . json_encode($request->all()));
            DB::rollBack();
            return response()->json([
                'status' => false,
                'payload' => $ex->getMessage()
            ]);
        }
        return response()->json([
            'status' => true,
            'payload' => $model->toArray()
        ]);
    }

    public function block_user(Request $request, $id)
    {
        if ($request->user()->id == $id) {
            return response()->json([
                'status' => false,
                'payload' => "Không được phép thực hiện hành động này!"
            ], 403);
        }
        $user = User::find($id);
        if ($user) {
            $user->status = config('util.INACTIVE_STATUS');
            $user->save();
            return response()->json([
                'status' => true,
                'payload' => $user
            ]);
        }
        return response()->json([
            'status' => false,
            'payload' => "Không tìm thấy tài khoản"
        ], 404);
    }

    public function updateRoleUser(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                'status' => false,
                'payload' => 'Lỗi tài khoản không tồn tại !'
            ]);
        } else {
            $role = Role::find($request->role_id);
            if (is_null($role)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Quyền này không tồn tại !'
                ]);
            } else {
                // dd($user->roles()->first());
                $user->syncRoles($role->name);
                return response()->json([
                    'status' => true,
                    'payload' => $user->roles()->get()
                ]);
            }
        }
    }


    public function contestJoined()
    {
        // user đã đăng nhập vô
        //tổng quan url  http://127.0.0.1:8000/api/v1/users/contest-joined?sort=asc&status=1&q=Nguyen Bich test
        // sort : asc/desc
        // q : tìm kiếm

        $contestID = [];
        $user_id = auth('sanctum')->user()->id;
        $user = User::find($user_id)->load('teams');
        foreach ($user->teams as $team) {
            if ($team->contest) {
                array_push($contestID, $team->contest->id);
            }
        }
        $contest = Contest::whereIn('id', $contestID)
            ->search(request('q') ?? null, ['name', 'description'])
            ->status(request('status'))
            ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'contests')
            ->get();
        return response()->json([
            'status' => true,
            'payload' => $contest
        ]);
    }

    public function updateDetailUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:4|max:50',
            ],
            [
                'name.required' => 'Tên không được bỏ trống !',
                'name.min' => 'Tên không nhỏ hơn 4 ký tự !',
                'name.max' => 'Tên không lớn hơn 50 ký tự !',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validator->errors(),
            ]);
        }
        $user = auth('sanctum')->user();

        if ($request->has('avatar')) {
            $validatorImage = Validator::make(
                $request->all(),
                [
                    'avatar' => 'image|mimes:jpeg,png,jpg|max:10000',
                ],
                [
                    'avatar.image' => 'Ảnh không được bỏ trống  !',
                    'avatar.mimes' => 'Ảnh không đúng định dạng  !',
                    'avatar.max' => 'Ảnh này kích cỡ quá lớn  !',
                ]
            );
            if ($validatorImage->fails()) {
                return response()->json([
                    'status' => false,
                    'payload' => $validatorImage->errors(),
                ]);
            }
            $nameAvatar = $this->uploadFile($request->avatar, $user->avatar ?? '');
            $user->update([
                'name' => $request->name,
                'avatar' => $nameAvatar,
            ]);
            return response()->json([
                'status' => true,
                'payload' => $user,
            ]);
        }
        $user->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'payload' => $user,
        ]);
    }
}