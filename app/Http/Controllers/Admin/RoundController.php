<?php

namespace App\Http\Controllers\Admin;

use App\Models\Round;
use App\Services\Traits\TResponse;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Donor;
use App\Models\DonorRound;
use App\Models\Enterprise;
use App\Models\Evaluation;
use App\Models\Judge;
use App\Models\RoundTeam;
use App\Models\Team;
use App\Models\TypeExam;
use Illuminate\Support\Facades\DB;
use Image;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoundController extends Controller
{
    use TResponse, TUploadImage;
    private $round;
    private $contest;
    private $type_exam;

    public function __construct(Round $round, Contest $contest, TypeExam $type_exam)
    {
        $this->round = $round;
        $this->contest = $contest;
        $this->type_exam = $type_exam;
    }

    /**
     *  Get list round
     */
    private function getList()
    {
        try {
            $key = null;
            $valueDate = null;
            if (request()->has('day')) {
                $valueDate = request('day');
                $key = 'day';
            }
            if (request()->has('month')) {
                $valueDate = request('month');
                $key = 'month';
            };
            if (request()->has('year')) {
                $valueDate = request('year');
                $key = 'year';
            };

            $data = $this->round::when(request()->has('round_soft_delete'), function ($q) {
                return $q->onlyTrashed();
            })->search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'rounds')
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    $key,
                    $valueDate,
                    (request('op_time') == 'sub' ? 'sub' : 'add'),
                    'start_time'
                )
                ->hasRequest([
                    'contest_id' => request('contest_id') ?? null,
                    'type_exam_id' => request('type_exam_id') ?? null,
                ])
                ->with([
                    'contest',
                    'type_exam',
                ]);

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View round
    public function index()
    {
        if (!($rounds = $this->getList())) return view('not_found');

        $rounds = $this->getList();
        return view('pages.round.index', [
            'rounds' => $rounds->paginate(request('limit') ?? 5),
            'contests' => $this->contest::withCount(['teams', 'rounds'])->get(),
            'type_exams' => $this->type_exam::all(),
        ]);
    }

    //  Response round
    public function apiIndex()
    {

        if (!($data = $this->getList())) return $this->responseApi(
            [
                "status" => false,
                "payload" => "Server not found",
            ],
            404
        );

        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data->get(),
            ]
        );
    }

    /**
     *  End list round
     */


    /**
     *  Store round
     */

    public function create()
    {
        $contests = Contest::all();
        $typeexams = TypeExam::all();
        return view('pages.round.form-add', compact('contests', 'typeexams'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:rounds|max:255|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u',
                'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'description' => 'required',
                'contest_id' => 'required|numeric',
                'type_exam_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'name.unique' => 'Đã tồn tại trong cơ sở dữ liệu !',
                'name.regex' => 'Trường name không chứ kí tự đặc biệt !',
                'image.mimes' => 'Sai định dạng !',
                'image.required' => 'Chưa nhập trường này !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'start_time.required' => 'Chưa nhập trường này !',
                'end_time.required' => 'Chưa nhập trường này !',
                'end_time.after' => 'Thời gian kết thúc không được nhỏ hơn  thời gian bắt đầu !',
                'description.required' => 'Chưa nhập trường này !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
                'type_exam_id.required' => 'Chưa nhập trường này !',
                'type_exam_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                $filename = $this->uploadFile($fileImage);
            }
            $round = new Round();
            $round->name = $request->name;
            $round->image = $filename;
            $round->start_time = $request->start_time;
            $round->end_time = $request->end_time;
            $round->description = $request->description;
            $round->contest_id = $request->contest_id;
            $round->type_exam_id = $request->type_exam_id;
            $round->save();
            Db::commit();
            return Redirect::route('admin.round.list');
        } catch (Exception $ex) {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            Db::rollBack();
            return Redirect::back()->with(['error' => 'Thêm mới thất bại !']);
        }
    }
    /**
     *  End store round
     */



    /**
     *  Edit
     */

    public function edit($id)
    {
        try {
            return view('pages.round.edit', [
                'round' => $this->round::where('id', $id)->get()->map->format()[0],
                'contests' => $this->contest::all(),
                'type_exams' => $this->type_exam::all(),
            ]);
        } catch (\Throwable $th) {
            return view('error');
        }
    }

    /**
     *  End edit round
     */

    /**
     *  Update round
     */

    private function updateRound($id)
    {
        try {
            // dd(request()->all());
            if (!($round = $this->round::find($id))) return false;
            $validator = Validator::make(
                request()->all(),
                [
                    'name' => "required|unique:rounds,name,$round->id|max:255|regex:/^[0-9a-zA-Z_ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễếệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\ ]+$/u",
                    'start_time' => "required|before:end_time",
                    'end_time' => "required|after:start_time",
                    'description' => "required",
                    'contest_id' => "required",
                    'type_exam_id' => "required",
                ],
                [
                    "name.required" => "Trường name không bỏ trống !",
                    'name.max' => 'Độ dài kí tự không phù hợp !',
                    'name.unique' => 'Đã tồn tại trong cơ sở dữ liệu !',
                    'name.regex' => 'Trường name không chứ kí tự đặc biệt !',
                    // "start_time.date_format" => "Trường thời gian bắt đầu không đúng định dạng !",
                    // "end_time.date_format" => "Trường thời gian kết thúc không đúng định dạng !",
                    "start_time.required" => "Trường thời gian bắt đầu  không bỏ trống !",
                    "end_time.required" => "Trường thời gian kết thúc không bỏ trống !",
                    "start_time.before" => "Trường thời gian bắt đầu  không nhỏ hơn trường kết thúc  !",
                    "end_time.after" => "Trường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                    "description.required" => "Trường mô tả không bỏ trống !",
                    "contest_id.required" => "Trường cuộc thi tồn tại !",
                    "type_exam_id.required" => "Trường loại thi không tồn tại !",
                ]
            );

            if ($validator->fails()) return [
                'status' => false,
                'errors' => $validator,
            ];
            $data = null;
            if (request()->has('image')) {

                $validator  =  Validator::make(
                    request()->all(),
                    [
                        'image' => 'file|mimes:jpeg,jpg,png|max:10000'
                    ],
                    [
                        'image.max' => 'Ảnh không quá 10000 kb  !',
                        'image.mimes' => 'Ảnh không đúng định dạng: jpeg,jpg,png !',
                    ]
                );

                if ($validator->fails()) return [
                    'status' => false,
                    'errors' => $validator,
                ];
                $nameFile = $this->uploadFile(request()->image, $round->image);
                $data = array_merge(request()->except('image'), [
                    'image' => $nameFile
                ]);
            } else {
                $data = request()->all();
            }
            $round->update($data);
            return $round;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function update($id)
    {
        if ($data = $this->updateRound($id)) {
            if (isset($data['status']) && $data['status'] == false) return redirect()->back()->withErrors($data['errors']);
            return redirect(route('admin.round.list'));
        }
        return redirect('error');
    }
    // Response round
    // public function apiUpdate($id)
    // {
    //     if ($data = $this->updateRound($id)) {
    //         if (isset($data['status']) && $data['status'] == false) return response()->json([
    //             "status" => false,
    //             "payload" => $data['errors']->errors(),
    //         ]);
    //         return response()->json([
    //             "status" => true,
    //             "payload" => $data,
    //         ]);
    //     }

    //     return response()->json([
    //         "status" => false,
    //         "payload" => "Server not found",
    //     ], 404);
    // }
    /**
     * End update round
     */

    /**
     * Destroy round
     */
    private function destroyRound($id)
    {
        try {
            if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = $this->round::find($id))) return false;
                if (Storage::disk('google')->has($data->image)) Storage::disk('google')->delete($data->image);
                $data->delete();
            });
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // View round
    public function destroy($id)
    {
        if (!(auth()->user()->hasRole(config('util.ROLE_DELETE')))) return redirect()->back()->with('error', 'Không thể xóa ');
        if ($this->destroyRound($id)) return redirect()->back();
        return redirect('error');
    }

    // Response
    // public function apiDestroy($id)
    // {
    //     if ($this->destroyRound($id))  return response()->json([
    //         "status" => true,
    //         "payload" => "Success"
    //     ]);
    //     return response()->json([
    //         "status" => false,
    //         "payload" => "Server not found"
    //     ], 404);
    // }
    /**
     *  End destroy round
     */
    public function show(Round $round, $id)
    {
        $round = Round::find($id);
        if (is_null($round)) {
            return response()->json(['payload' => 'Không tồn tại trong hệ thống !'], 200);
        } {
            $round->load('contest');
            $round->load('type_exam');
            $round->load(['teams' => function ($q) {
                return $q->with('members');
            }]);
            return response()->json(['payload' => $round], 200);
        }
    }
    public function contestDetailRound($id)
    {
        if (!($rounds = $this->getList())) return view('not_found');
        $contest = $this->contest->find($id);
        $rounds = $this->getList();
        return view('pages.contest.detail.contest-round', [
            'rounds' => $rounds->where('contest_id', $id)
                ->when(
                    auth()->check() &&  auth()->user()->hasRole('judge'),
                    function ($q) use ($id) {
                        $judge = Judge::where('contest_id', $id)->where('user_id', auth()->user()->id)->with('judge_round')->first('id');
                        $arrId = [];
                        foreach ($judge->judge_round as $judge_round) {
                            array_push($arrId, $judge_round->id);
                        }
                        return $q->whereIn('id', $arrId);
                    }
                )->paginate(request('limit') ?? 5),
            'contests' => $this->contest::withCount(['teams', 'rounds'])->get(),
            'type_exams' => $this->type_exam::all(),
            'contest' =>  $contest
        ]);
    }
    public function adminShow($id)
    {
        if (!($round = $this->round::with(['contest', 'type_exam', 'judges', 'teams', 'Donor', 'exams'])->where('id', $id)->first())) return abort(404);
        return view('pages.round.detail.detail', ['round' => $round]);
    }
    // chi tiết doanh nghiệp
    public function roundDetailEnterprise($id)
    {
        if (!($round = $this->round->find($id)->load('Donor')->Donor()->paginate(6))) return abort(404);

        //         foreach($round as $item){
        // var_dump($item->Enterprise->name);
        // }
        // die();
        $enterprise = Enterprise::all();
        return view('pages.round.detail.enterprise', ['round' => $round, 'roundDeltai' => $this->round->find($id), 'enterprise' => $enterprise]);
    }

    public function softDelete()
    {
        $listRoundSofts = $this->getList()->paginate(request('limit') ?? 5);
        return view('pages.round.round-soft-delete', [
            'listRoundSofts' => $listRoundSofts
        ]);
    }
    public function backUpRound($id)
    {
        try {
            $this->round::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function deleteRound($id)
    {
        try {
            $this->round::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function roundDetailTeam($id)
    {
        $round = Round::find($id);
        $teams =  Round::find($id)->load('contest')->contest->teams;
        return view('pages.round.detail.round-team', compact('round', 'teams'));
    }
    public function attachEnterprise(Request $request, $id)
    {
        try {
            // dd(Round::find($id)->load('Enterprise')->Enterprise->id);
            foreach ($request->enterprise_id as $item) {
                $data = Donor::where('contest_id', Round::find($id)->load('Enterprise')->Enterprise->id)->where('enterprise_id', $item)->first();
                if ($data != null) {
                    DonorRound::create([
                        'round_id' => $id,
                        'donor_id' => $data->id
                    ]);
                    return Redirect::back();
                }
                $data = Donor::create([
                    'contest_id' => Round::find($id)->load('Enterprise')->Enterprise->id,
                    'enterprise_id' => $item
                ]);
                DonorRound::create([
                    'round_id' => $id,
                    'donor_id' => $data->id
                ]);
            }
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function detachEnterprise($id, $donor_id)
    {
        try {
            $data = DonorRound::where('round_id', $id)->where('donor_id', $donor_id)->first();

            if ($data) {
                $data->delete();
            }

            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function attachTeam(Request $request, $id)
    {
        try {
            Round::find($id)->teams()->syncWithoutDetaching($request->team_id);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }
    public function detachTeam($id, $team_id)
    {
        try {
            Round::find($id)->teams()->detach([$team_id]);
            return Redirect::back();
        } catch (\Throwable $th) {
            return Redirect::back();
        }
    }

    /**
     *   chi tiết bài thi của đội thi theo vòng thi
     */
    public function roundDetailTeamTakeExam($id, $teamId)
    {
        try {
            $round = Round::find($id);
            $team = Team::where('id', $teamId)->first();
            $takeExam = RoundTeam::where('round_id', $id)->where('team_id', $teamId)->with('takeExam')->first();
            return view(
                'pages.round.detail.team_take_exam',
                [
                    'takeExam' => $takeExam->takeExam,
                    'round' => $round,
                    'team' => $team
                ]
            );
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function roundDetailTeamMakeExam($id, $teamId)
    {
        try {
            $round = Round::find($id);
            $team = Team::where('id', $teamId)->first();
            $takeExam = RoundTeam::where('round_id', $id)->where('team_id', $teamId)->with('takeExam', function ($q) use ($round) {
                return $q->with(['exam', 'evaluations' => function ($q) use ($round) {
                    $judge = Judge::where('contest_id', $round->contest_id)->where('user_id', auth()->user()->id)->with('judge_rounds', function ($q) use ($round) {
                        return $q->where('round_id', $round->id);
                    })->first('id');
                    return $q->where('judge_round_id', $judge->judge_rounds[0]->id);
                }]);
            })->first();
            return view(
                'pages.round.detail.team-make-exam',
                [
                    'takeExam' => $takeExam->takeExam,
                    'round' => $round,
                    'team' => $team
                ]
            );
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function roundDetailFinalTeamMakeExam(Request $request, $id, $teamId)
    {
        $round = Round::find($id);
        $team = Team::where('id', $teamId)->first();
        $roundTeam = RoundTeam::where('round_id', $id)
            ->where('team_id', $teamId)
            ->with('takeExam', function ($q) use ($round) {
                return $q->with(['exam', 'evaluations']);
            })->first();
        $request->validate([
            'ponit' => 'required|numeric|min:0|max:' . $roundTeam->takeExam->exam->max_ponit,
            'comment' => 'required',
            'status' => 'required',
        ], [
            'ponit.required' => 'Trường điểm không bỏ trống !',
            'ponit.numeric' => 'Trường điểm đúng định dạng !',
            'ponit.min' => 'Trường điểm phải thuộc số dương  !',
            'ponit.max' => 'Trường điểm không lớn hơn thang điểm ' . $roundTeam->takeExam->exam->max_ponit . '!',
            'comment.required' => 'Trường nhận xét không bỏ trống !',
        ]);
        $judge = Judge::where('contest_id', $round->contest_id)->where('user_id', auth()->user()->id)->with('judge_rounds', function ($q) use ($round) {
            return $q->where('round_id', $round->id);
        })->first('id');
        $dataCreate = array_merge($request->only([
            'ponit',
            'comment',
            'status'
        ]), [
            'exams_team_id' => $roundTeam->takeExam->id,
            'judge_round_id' =>  $judge->judge_rounds[0]->id
        ]);
        try {
            Evaluation::create($dataCreate);
            return redirect()->route('admin.round.detail.team', ['id' => $round->id]);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function roundDetailUpdateTeamMakeExam(Request $request, $id, $teamId)
    {
        $round = Round::find($id);
        $roundTeam = RoundTeam::where('round_id', $id)
            ->where('team_id', $teamId)
            ->with('takeExam', function ($q) use ($round) {
                return $q->with(['exam', 'evaluations']);
            })->first();
        $request->validate([
            'ponit' => 'required|numeric|min:0|max:' . $roundTeam->takeExam->exam->max_ponit,
            'comment' => 'required',
            'status' => 'required',
        ], [
            'ponit.required' => 'Trường điểm không bỏ trống !',
            'ponit.numeric' => 'Trường điểm đúng định dạng !',
            'ponit.min' => 'Trường điểm phải thuộc số dương  !',
            'ponit.max' => 'Trường điểm không lớn hơn thang điểm ' . $roundTeam->takeExam->exam->max_ponit . '!',
            'comment.required' => 'Trường nhận xét không bỏ trống !',
        ]);
        $judge = Judge::where('contest_id', $round->contest_id)->where('user_id', auth()->user()->id)->with('judge_rounds', function ($q) use ($round) {
            return $q->where('round_id', $round->id);
        })->first('id');
        $dataCreate = array_merge($request->only([
            'ponit',
            'comment',
            'status'
        ]), [
            'exams_team_id' => $roundTeam->takeExam->id,
            'judge_round_id' =>  $judge->judge_rounds[0]->id
        ]);
        try {
            Evaluation::where('exams_team_id', $roundTeam->takeExam->id)
                ->where('judge_round_id', $judge->judge_rounds[0]->id)
                ->update($dataCreate);
            return redirect()->route('admin.round.detail.team', ['id' => $round->id]);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}