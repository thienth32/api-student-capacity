<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\User;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MUser\MUserInterface;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TResponse;
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
    use TUploadImage, TCheckUserDrugTeam, TResponse;


    public function __construct(
        private MUserInterface $user,
        private MContestInterface $contest,
        private User $modeluser,
        private Role $role
    ) {
    }

    public function TeamUserSearch(Request $request)
    {

        try {
            $usersNotTeam = User::where('status', config('util.ACTIVE_STATUS'))->pluck('id');
            $usersTeamNot = $this->checkUserDrugTeam($request->id_contest, $usersNotTeam);

            $users = User::select('id', 'name', 'email', 'avatar')
                ->search($request->key, ['name', 'email'])
                ->whereIn('id', $usersTeamNot['user-pass'])
                ->limit(5)->get();
            return response()->json([
                'status' => true,
                'payload' => $users,
            ]);
        } catch (\Throwable $th) {
            dd($th);
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
            $users = $this->modeluser::status(request('status') ?? null)
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
        $roles =  $this->role::all();
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
            $user = $this->modeluser::find($id);
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
            $user = $this->modeluser::find($id);
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

        if (!$role = $this->role::whereName($data[0])->first()) return response()->json([
            'status' => false,
            'payload' => 'Không có quyền  !',
        ]);
        if (!$user = $this->modeluser::find($data[1])) return response()->json([
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
    //    public function add_user(Request $request)
    //    {
    //        // validator
    //        $validator = Validator::make(
    //            $request->all(),
    //            [
    //                'name' => 'required|max:255',
    //                'email' => 'required|email|max:255|unique:users',
    //            ],
    //            [
    //                'name.required' => 'Chưa nhập trường này !',
    //                'name.max' => 'Độ dài tên không phù hợp!',
    //
    //                'email.required' => 'Chưa nhập trường này !',
    //                'email.email' => 'Không đúng định dạng email !',
    //                'email.max' => 'Độ dài email không phù hợp!',
    //                'email.unique' => 'Email đã tồn tại!',
    //            ]
    //        );
    //        // dd($validator->errors()->toArray());
    //        if ($validator->fails()) {
    //            return response()->json([
    //                'status' => false,
    //                'payload' => $validator->errors()
    //            ]);
    //        }
    //        DB::beginTransaction();
    //        try {
    //            $model = new User();
    //            $model->fill($request->all());
    //            $model->save();
    //            $role = Role::find($request->role_id);
    //            $model->assignRole($role->name);
    //            DB::commit();
    //        } catch (Exception $ex) {
    //            Log::error("Lỗi tạo tài khoản:");
    //            Log::info("post data: " . json_encode($request->all()));
    //            DB::rollBack();
    //            return response()->json([
    //                'status' => false,
    //                'payload' => $ex->getMessage()
    //            ]);
    //        }
    //        return response()->json([
    //            'status' => true,
    //            'payload' => $model->toArray()
    //        ]);
    //    }

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
        $user = $this->modeluser::find($id);
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

    /**
     * @OA\Get(
     *     path="/api/v1/users/contest-joined-and-not-joined",
     *     description="Description api contests",
     *     tags={"User-Joined-Contest"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Lọc theo trạng thái ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function contestJoinedAndNotJoined()
    {
        if (!($data = $this->contest->apiIndex())) return $this->responseApi(false);
        return $this->responseApi(true, $data);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/contest-joined",
     *     description="Description api contests",
     *     tags={"User-Joined-Contest"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Giới hạn hiển thị",
     *         required=false,
     *     ),
     *          @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Trạng thái",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function contestJoined()
    {
        $contest = $this->user->contestJoined();
        return $this->responseApi(true, $contest);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/edit",
     *     description="Description api edit user",
     *     tags={"User","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="string",
     *                      property="name",
     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="avatar",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
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