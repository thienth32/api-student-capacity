<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function list(Request $request)
    {
        $users = User::all();
        return response()->json([
            'status' => true,
            'payload' => $users->toArray()
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