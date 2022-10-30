<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TTeamContest;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use TUploadImage, TCheckUserDrugTeam, TTeamContest, TResponse;
    private $contest;
    private $team;
    private $user;

    public function __construct(Contest $contest, User $user, Team $team)
    {
        $this->contest = $contest;
        $this->team = $team;
        $this->user = $user;
    }

    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $timeDay = $request->has('day') ? $request->day : Null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('team_soft_delete') ? $request->team_soft_delete : null;

        if ($softDelete != null) {
            $query = $this->team::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->team::where('name', 'like', "%$keyword%");
        if ($timeDay != null) {
            $current = Carbon::now();
            $query->where('created_at', '>=', $current->subDays($timeDay));
        }
        if ($contest != null) {
            $query->where('contest_id', $contest);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        // dd($query->get());
        return $query;
    }

    public function ListTeam(Request $request)
    {
        try {
            $Contest = $this->contest::orderBy('id', 'DESC')->get();
            $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

            return view('pages.team.listTeam', compact('dataTeam', 'Contest'));
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'lỗi'
            ]);
        };
    }

    public function deleteTeam(Request $request, $id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data =  $this->team::find($id))) return false;
                if (Storage::disk('s3')->has($data->image)) Storage::disk('s3')->delete($data->image);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function create()
    {
        $contests = $this->contest::where('type', config('util.TYPE_CONTEST'))->get();
        return view('pages.team.form-add', compact('contests'));
    }

    public function store(Request $request)
    {
        return $this->addTeamContest($request, null, Redirect::route('admin.teams'), Redirect::back());
    }

    public function edit($id)
    {
        try {
            $userArray = [];
            $contests = $this->contest::where('type', config('util.TYPE_CONTEST'))->get();
            $team = $this->team::find($id);
            if (!$team) return abort(404);
            $team->load('members');
            foreach ($team->members as $me) {
                array_push($userArray, [
                    'id_user' => $me->id,
                    'email_user' => $me->email,
                    'name_user' => $me->name,
                    'bot' => $me->pivot->bot,
                ]);
            }
            return view('pages.team.form-edit', compact('contests', 'team', 'userArray'));
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function update(Request $request, $id_team)
    {
        $team =  $this->team::find($id_team);
        if (!is_null($team)) {
            return $this->editTeamContest($request, $id_team, null, Redirect::route('admin.teams'), Redirect::back());
        } else {
            return redirect()->back()->withErrors(["error" => "Đã xảy ra lỗi !"]);;
        }
    }

    public function softDelete(Request $request)
    {
        $listTeamSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));

        return view('pages.team.team-soft-delete', compact('listTeamSofts'));
    }

    public function backUpTeam($id)
    {
        try {
            $this->team::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function destroy($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;

            $this->team::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/teams/{id}",
     *     description="Description api user team",
     *     tags={"Team"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id đội",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */

    public function apiShow($id)
    {
        try {
            $team = $this->team::find($id)->load(['members', 'contest']);
            return $this->responseApi(true, $team);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/teams/edit-team/{team_id}",
     *     description="Description api capacity",
     *     tags={"Team","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="team_id",
     *         in="path",
     *         description="Id đội muốn chỉnh sửa",
     *         required=true,
     *      @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *          mediaType="multipart/form-data" ,
     *              @OA\Schema(

     *                  @OA\Property(
     *                      type="string",
     *                      property="name",
     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="image",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiEditTeam(Request $request, $team_id)
    {
        // dd($request->all());
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'image' =>  'mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'image.mimes' => 'Sai định dạng !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(false, $validate->errors());
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $user = $this->user::find($user_id);
            $teamCheck = $this->team::find($team_id)->load('members');
            if (is_null($user) || is_null($teamCheck)) {
                return  $this->responseApi(false, 'Không tồn tại trong cơ sở dữ liệu !');
            } else {
                foreach ($teamCheck->members as $u) {
                    if ($u->pivot->bot === 1) if (!($u->pivot->user_id === $user_id))
                        return  $this->responseApi(false, 'Bạn không có quyền để chỉnh sửa cuộc thi !');
                }
                if ($user->status != config('util.ACTIVE_STATUS'))
                    return  $this->responseApi(false, 'Tài khoản đã bị khóa !');
                $teamChecks = $this->team::where(
                    'contest_id',
                    $request->contest_id
                )->where('name', trim($request->name))->get();
                foreach ($teamChecks as $teamCheck) {
                    if ($teamCheck->id != $team_id)
                        return $this->responseApi(false, 'Tài khoản này đã tham gia đội thi khác !!');
                }
                $team =  $this->team::find($team_id);
                if ($request->has('image')) {
                    $fileImage = $request->file('image');
                    $filename = $this->uploadFile($fileImage, $team->image);
                    $team->image = $filename;
                }
                $team->name = $request->name;
                $team->save();
                DB::commit();
                return $this->responseApi(true, $team);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('s3')->has($fileImage)) Storage::disk('s3')->delete($fileImage);
            }
            return $this->responseApi(true, $th);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/teams/add-team",
     *     description="Đăng kí đội thi đồng thời người đăng kí sẽ là nhóm trưởng",
     *      tags={"Team","Api V1"},
     *        summary="Authorization",
     *     security={{"bearer_token":{}}},

     *     @OA\RequestBody(
     *          @OA\MediaType(
     *          mediaType="multipart/form-data" ,
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="contest_id",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="name",
     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="image",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiAddTeam(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'contest_id' => 'required',
                'name' => 'required',
                'image' =>  'mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'contest_id.required' => 'Chưa nhập trường này !',
                'name.required' => 'Chưa nhập trường này !',
                'image.mimes' => 'Sai định dạng !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if ($validate->fails()) return  $this->responseApi(false, $validate->errors());
        $teamCheck = $this->team::where(
            'contest_id',
            $request->contest_id
        )->where('name', trim($request->name))->get();
        if (count($teamCheck) > 0) return $this->responseApi(false, 'Tên đã tồn tại trong cuộc thi !!');
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $result = $this->checkUserDrugTeam($request->contest_id, [$user_id]);
            if (count($result['user-not-pass']) > 0) return $this->responseApi(false, 'Tài khoản này đã tham gia đội thi khác !!');
            $today = Carbon::now()->toDateTimeString();
            $user = $this->user::find($user_id);
            $contest = $this->contest::find($request->contest_id);
            if (is_null($user) || is_null($contest)) {
                return $this->responseApi(false, 'Không tồn tại trong cơ sở dữ liệu !');
            } else {
                if ($user->status != config('util.ACTIVE_STATUS')) return $this->responseApi(false, 'Tài khoản đã bị khóa !');
                if (strtotime($contest->register_deadline) > strtotime($today)) {
                    $teamModel = new Team();
                    if ($request->hasFile('image')) {
                        $fileImage = $request->file('image');
                        $filename = $this->uploadFile($fileImage);
                        $teamModel->image = $filename;
                    }
                    $teamModel->name = $request->name;
                    $teamModel->contest_id = $request->contest_id;
                    $teamModel->save();
                    $teamModel->members()->attach($result['user-pass'], ['bot' => config('util.ACTIVE_STATUS')]);
                    DB::commit();
                    $modelTeamId =  $teamModel->id;
                    return $this->responseApi(true, 'Tạo đội thành công !', ['id_team' => $modelTeamId]);
                } else {
                    return $this->responseApi(false, 'Đã quá thời hạn đăng kí cuộc thi !');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($fileImage)) Storage::disk('google')->delete($fileImage);
            }

            return $this->responseApi(true, $th);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/teams/check-user-team-contest/{id_contest}",
     *     description="Description api user team",
     *     tags={"Team","Contest"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id_contest",
     *         in="path",
     *         description="Id cuộc thi cần check",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function checkUserTeamContest($id_contest)
    {
        $user_id = auth('sanctum')->user()->id;
        $result = $this->checkUserDrugTeam($id_contest, [$user_id]);
        if (count($result['user-not-pass']) > 0)
            return $this->responseApi(false, 'Tài khoản này đã tham gia cuộc thi khác !');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/add-user-team-contest/{id_contest}/{id_team}",
     *     description="Dẩy  user_id với dạng array :  {  'user_id': [ 0,3,4,5,6] }",
     *     tags={"Team","Api V1"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id_contest",
     *         in="path",
     *         description="Id cuộc thi đó",
     *         required=true,
     *      @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="id_team",
     *         in="path",
     *         description="Id đội muốn thêm thành viên",
     *         required=true,
     *      @OA\Schema(type="number")
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="string",
     *                      property="user_id",
     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function addUserTeamContest(Request $request, $id_contest, $id_team)
    {

        $validate = Validator::make(
            $request->all(),
            [
                "user_id"    => "required",
                "user_id.*"  => "required",
            ],
            [
                'user_id.required' => 'Chưa nhập trường này !',
            ]
        );
        if ($validate->fails()) return $this->responseApi(false, $validate->errors());
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $team = $this->team::where('id', $id_team)->where('contest_id', $id_contest)->first();
            if (is_null($team)) return $this->responseApi(false, 'Đội không tồn tại trong cuộc thi !');
            $team->load('members');
            $result = $this->checkUserDrugTeam($id_contest, $request->user_id);
            foreach ($team->members as $userTeam) {
                if ($userTeam->id === $user_id && $userTeam->pivot->bot == 1) {
                    $team->members()->attach($result['user-pass']);
                    DB::commit();

                    $user_pass = $this->user::whereIn('id', $result['user-pass'])->get();
                    $use_not_pass = $this->user::whereIn('id', $result['user-not-pass'])->get();

                    return $this->responseApi(true, 'Thêm thành viên thành công !', [
                        'user_pass' => $user_pass ?? null,
                        'user_not_pass' => $use_not_pass ?? null
                    ]);
                } else {
                    return $this->responseApi(false, 'Không đủ quyền để thêm thành viên !');
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/user-team-search/{id_contest}",
     *     description="Tìm kiếm user ko có trong cuộc thi này",
     *     tags={"Team","Api V1" , "Contest"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="id_contest",
     *         in="path",
     *         description="Id cuộc thi đó",
     *         required=true,
     *      @OA\Schema(type="number")
     *     ),
     *     @OA\Parameter(
     *         name="key",
     *         in="query",
     *         description="Tìm kiếm theo tên hoặc email ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function userTeamSearch($id_contest, Request $request)
    {
        try {
            $usersNotTeam = $this->user::where('status', config('util.ACTIVE_STATUS'))->pluck('id');
            $usersNotTeam = $this->checkUserDrugTeam($id_contest, $usersNotTeam);
            $users = $this->user::select('id', 'name', 'email', 'avatar')
                ->search(request('key') ?? null, ['name', 'email'])
                ->whereIn('id', $usersNotTeam['user-pass'])
                ->limit(5)->get();
            return $this->responseApi(true, $users);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function getContest(Request $request)
    {
        $max_user = $this->contest::find($request->id)->max_user;
        return $this->responseApi(true, $max_user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/delete-user-team-contest",
     *     description="Dẩy  user_id với dạng array :  {  'user_id': [ 0,3,4,5,6] }",
     *     tags={"Team","Api V1" , "Contest"},
     *     summary="Authorization",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="team_id",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="user_id",
     *                  ),

     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function deleteUserTeamContest(Request $request)
    {
        $team = $this->team::find($request->team_id);
        if (is_null($team))  return $this->responseApi(false, "Thông tin đội bị lỗi !!");
        $userID = $this->user::whereIn('id', $request->user_id)->get()->pluck('id');
        $team->members()->detach($userID);
        return $this->responseApi(true, "Xóa thành viên thành công !!", ['user_id' => $userID]);
    }
}