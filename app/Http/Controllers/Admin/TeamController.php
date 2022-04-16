<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Team;
use App\Models\User;
use App\Models\Contest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Traits\TCheckUserDrugTeam;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    use TUploadImage;
    use TCheckUserDrugTeam;
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
        $sortBy = $request->has('sortBy') ? $request->sortBy : "asc";
        $softDelete = $request->has('team_soft_delete') ? $request->team_soft_delete : null;

        if ($softDelete != null) {
            $query = Team::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = Team::where('name', 'like', "%$keyword%");
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
    // Danh sách teams phía view
    public function ListTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $Contest = Contest::orderBy('id', 'DESC')->get();
            $dataTeam = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            // foreach ($dataTeam as $key) {

            //     echo '<pre/>';
            //     var_dump($key->contest->name);
            // }
            // die();

            DB::commit();
            return view('pages.team.listTeam', compact('dataTeam', 'Contest'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'lỗi'
            ]);
        };
    }


    //xóa Teams
    public function deleteTeam(Request $request, $id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = Team::find($id))) return false;
                if (Storage::disk('google')->has($data->image)) Storage::disk('google')->delete($data->image);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }



    public function create()
    {
        $contests = Contest::all();
        return view('pages.team.form-add', compact('contests'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:teams|max:255',
                'image' => 'required|max:10000',
                'contest_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'name.unique' => 'Tên đã tồn tại !',
                'image.required' => 'Chưa nhập trường này !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails() || !($request->has('user_id'))) {
            return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội')->withInput($request->input());
        }
        DB::beginTransaction();
        try {
            $result = $this->checkUserDrugTeam($request->contest_id, $request->user_id);
            $team = new Team();
            if ($request->has('image')) {
                $fileImage =  $request->file('image');
                $image = $this->uploadFile($fileImage);
                $team->image = $image;
            }
            $team->name = $request->name;
            $team->contest_id = $request->contest_id;
            $team->save();
            $team->members()->syncWithoutDetaching($result['user-pass']);
            Db::commit();
            return redirect()->route('admin.teams');
        } catch (Exception $ex) {
            Db::rollBack();
            return redirect('error');
        }
    }

    public function edit($id)
    {
        $userArray = [];
        $users = User::all();
        $contests = Contest::all();
        $team = Team::find($id);
        foreach ($users as $user) {
            foreach ($team->members as $me) {
                if ($user->id == $me->id) {
                    array_push($userArray, [
                        'id_user' => $user->id,
                        'email_user' => $user->email
                    ]);
                }
            }
        }
        return view('pages.team.form-edit', compact('contests', 'team', 'userArray'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:teams,name,' . $id . '|max:255',
                'image' => 'mimes:jpeg,png,jpg|max:10000',
                'contest_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'name.unique' => 'Tên đã tồn tại !',
                'name.mimes' => 'Sai định dạng ảnh !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails() || !($request->has('user_id'))) {
            return redirect()->back()->withErrors($validator)->with('error', 'Chưa có thành viên trong đội')->withInput($request->input());
        }
        DB::beginTransaction();
        try {
            $result = $this->checkUserDrugTeam($request->contest_id, $request->user_id);
            $team = Team::find($id);
            if (is_null($team)) {
                return response()->json([
                    "payload" => 'Không tồn tại trong cơ sở dữ liệu !'
                ], 500);
            } else {
                if ($request->has('image')) {
                    $fileImage =  $request->file('image');
                    $image = $this->uploadFile($fileImage, $team->image);
                    $team->image = $image;
                }
                $user_id = $result['user-pass'];
                $team->members()->syncWithoutDetaching($user_id);
                $team->name = $request->name;
                $team->contest_id = $request->contest_id;
                $team->save();
                Db::commit();

                return Redirect::route('admin.teams');
            }
        } catch (Exception $ex) {
            Db::rollBack();
            return response()->json([
                "payload" => $ex
            ], 500);
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
            Team::withTrashed()->where('id', $id)->restore();
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

            Team::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }


    // Add team phía client
    public function apiAddTeam(Request $request)
    {

        $validate = validator::make(
            $request->all(),
            [
                'contest_id' => 'required',
                'name' => 'required|unique:teams',
                'image' =>  'mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'contest_id.required' => 'Chưa nhập trường này !',
                'name.required' => 'Chưa nhập trường này !',
                'name.unique' => 'Tên đã tồn tại !',
                'image.mimes' => 'Sai định dạng !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
            ]
        );
        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);
        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $result = $this->checkUserDrugTeam($request->contest_id, $user_id);
            if (count($result['user-not-pass']) > 0) return response()->json([
                'status' => false,
                'payload' => 'Tài khoản này đã tham gia cuộc thi khác !'
            ]);


            $today = Carbon::now()->toDateTimeString();
            // $user_id = $request->user_id;
            $user = User::find($user_id);
            $contest = Contest::find($request->contest_id);
            if (is_null($user) || is_null($contest)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Không tồn tại trong cơ sở dữ liệu !'
                ]);
            } else {
                if ($user->status != config('util.ACTIVE_STATUS')) return response()->json([
                    'status' => false,
                    'payload' => 'Tài khoản đã bị khóa !'
                ]);
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
                    $teamModel->members()->syncWithoutDetaching($result['user-pass'], ['bot' => config('util.ACTIVE_STATUS')]);
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'payload' => 'Tạo đội thành công !'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'payload' => 'Đã quá thời hạn đăng kí cuộc thi !'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            return response()->json([
                'status' => false,
                'payload' =>  $th
            ]);
        }
    }

    public function apiEditTeam(Request $request, $team_id)
    {

        DB::beginTransaction();
        try {
            $user_id = auth('sanctum')->user()->id;
            $result = $this->checkUserDrugTeam($request->contest_id, $user_id);
            if (count($result['user-not-pass']) > 0) return response()->json([
                'status' => false,
                'payload' => 'Tài khoản này đã tham gia cuộc thi khác !'
            ]);
            $today = Carbon::now()->toDateTimeString();
            $user = User::find($user_id);
            $teamCheck = $this->team::find($team_id)->load('members');
            $contest = $this->contest::find($teamCheck->contest_id);
            if (is_null($user) || is_null($teamCheck)) {
                return response()->json([
                    'status' => false,
                    'payload' => 'Không tồn tại trong cơ sở dữ liệu !'
                ]);
            } else {
                foreach ($teamCheck->members as $u) {
                    if ($u->pivot->bot === 1) if (!($u->pivot->user_id === $user_id)) return response()->json([
                        'status' => false,
                        'payload' => 'Bạn không có quyền để chỉnh sửa cuộc thi !'
                    ]);
                }
                if ($user->status != config('util.ACTIVE_STATUS')) return response()->json([
                    'status' => false,
                    'payload' => 'Tài khoản đã bị khóa !'
                ]);
                if (strtotime($contest->register_deadline) > strtotime($today)) {
                    $validate = validator::make(
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
                    if ($validate->fails()) return response()->json([
                        'status' => false,
                        'payload' => $validate->errors()
                    ]);

                    $team =  $this->team::find($team_id);
                    if ($request->hasFile('image')) {
                        $fileImage = $request->file('image');
                        $filename = $this->uploadFile($fileImage);
                        $team->image = $filename;
                    }
                    $team->name = $request->name;
                    $team->save();
                    $team->members()->syncWithoutDetaching($result['user-pass']);

                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'payload' => $team
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'payload' => 'Đã quá thời hạn đăng kí cuộc thi !'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            return response()->json([
                'status' => false,
                'payload' =>  $th
            ]);
        }
    }
}