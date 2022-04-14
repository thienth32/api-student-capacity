<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function TeamUserSearch(Request $request)
    {
        $users = User::search($request->key ?? null, ['name', 'email'])->take(4)->get();
        return response()->json($users, 200);
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

    public function index()
    {
        // List
        try {
            $limit = 10;
            $users = User::status(request('status') ?? null)
                ->sort(request('sort') == 'desc' ? 'desc' : 'asc', request('sort_by') ?? null, 'users')
                ->search(request('search') ?? null, ['name', 'email'])
                ->has_role(request('role') ?? null)
                ->paginate(request('limit') ?? $limit);

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
        } catch (\Throwable $e) {

            return response()->json(
                [
                    'status' => false,
                    'payload' => 'Máy chủ bị lỗi , liên hệ quản trị viên để khắc phục sự cố  !'
                ],
                506
            );
        }
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
}