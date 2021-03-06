<?php

namespace App\Http\Controllers\Admin;

use App\Services\Traits\TUploadImage;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Recruitment;
use Carbon\Carbon;
use App\Services\Traits\TResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class RecruitmentController extends Controller
{
    use TUploadImage;
    use TResponse;
    private function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $enterprise = $request->has('enterprise_id') ? $request->enterprise_id : null;
        $contest = $request->has('contest_id') ? $request->contest_id : null;
        $progress = $request->has('progress') ? $request->progress : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('recruitment_soft_delete') ? $request->recruitment_soft_delete : null;
        if ($softDelete != null) {
            $query = Recruitment::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = Recruitment::where('name', 'like', "%$keyword%");
        if ($enterprise != null) {
            $query = Enterprise::find($enterprise);
        }
        if ($contest != null) {
            $query = Contest::find($contest);
        }
        if ($progress != null) {
            if ($progress == 'pass_date') {
                // dd(\Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
                $query->where('start_time', '>', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
            } elseif ($progress == 'registration_date') {
                $query->where('start_time', '<', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString())->whereDate('end_time', '>', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
            } elseif ($progress == 'miss_date') {
                $query->where('end_time', '<', \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString());
            }
        }
        if ($endTime != null && $startTime != null) {
            // dd(\Carbon\Carbon::parse(request('startTime'))->format('m/d/Y h:i:s A'), \Carbon\Carbon::parse(request('endTime'))->format('m/d/Y h:i:s A'));
            $query->where('start_time', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('start_time', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        // dd($query->get());
        return $query;
    }
    public function index(Request $request)
    {
        DB::beginTransaction();
        try {
            $enterprises = Enterprise::all();
            $contests = Contest::where('type', 1)->get();
            $Recruitments = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            if ($request->enterprise_id) {
                $Recruitments = $this->getList($request)->recruitment()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }
            if ($request->contest_id) {
                $Recruitments = $this->getList($request)->recruitment()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
            }
            DB::commit();
            return view('pages.recruitment.index', [
                'Recruitments' => $Recruitments,
                'enterprises' => $enterprises,
                'contests' => $contests
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('error');
        };
    }
    public function create(Request $request)
    {

        DB::beginTransaction();
        try {
            $enterprise = Enterprise::all();
            $contest = Contest::where('type', 1)->get();
            // dd($contest);
            DB::commit();
            return view('pages.recruitment.form-add', ['enterprise' => $enterprise, 'contest' => $contest]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:recruitments,name',
                'description' => 'required',
                'start_time' => 'required|after_or_equal:today',
                'end_time' => 'required|after:start_time',
                'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',

            ],
            [

                'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                'name.unique' => 'tr?????ng ???? t???n t???i !',
                'start_time.after_or_equal' => 'Th???i gian b???t ?????u ph???i sau ho???c b???ng ng??y hi???n t???i. ',
                'start_time.required' => 'Ch??a nh???p tr?????ng n??y !',
                'end_time.required' => 'Ch??a nh???p tr?????ng n??y !',
                'end_time.after' => 'Th???i gian k???t th??c kh??ng ???????c nh??? h??n th???i gian b???t ?????u !',
                'description.required' => 'Ch??a nh???p tr?????ng n??y !',
                'image.mimes' => 'Sai ?????nh d???ng !',
                'image.required' => 'Ch??a nh???p tr?????ng n??y !',
                'image.max' => 'Dung l?????ng ???nh kh??ng ???????c v?????t qu?? 10MB !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ];
            if ($request->has('image')) {
                $fileImage =  $request->file('image');
                $image = $this->uploadFile($fileImage);
                $data['image'] = $image;
            }

            // dd($request->contest_id);
            $newRecruitment =  Recruitment::create($data);
            if ($newRecruitment) {
                if ($request->enterprise_id != null) {
                    Recruitment::find($newRecruitment->id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
                }
                if ($request->contest_id != null) {
                    Recruitment::find($newRecruitment->id)->contest()->syncWithoutDetaching($request->contest_id);
                }
            }
            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;
            DB::transaction(function () use ($id) {
                if (!($data = Recruitment::find($id))) return false;
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function edit(Request $request, $id)
    {

        $data =  Recruitment::find($id);
        $enterprises = Enterprise::all();
        $contests = Contest::where('type', 1)->get();
        // dd($data);
        // $dataMajor = Major::where('parent_id', 0)->get();

        return view('pages.recruitment.form-edit', compact('data', 'enterprises', 'contests'));
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255|unique:recruitments,name,' .  $id,
                'description' => 'required',
                'start_time' => 'required|after_or_equal:today',
                'end_time' => 'required|after:start_time',


            ],
            [

                'name.required' => 'Ch??a nh???p tr?????ng n??y !',
                'name.unique' => 'tr?????ng ???? t???n t???i !',
                'start_time.after_or_equal' => 'Th???i gian b???t ?????u ph???i sau ho???c b???ng ng??y hi???n t???i. ',
                'start_time.required' => 'Ch??a nh???p tr?????ng n??y !',
                'end_time.required' => 'Ch??a nh???p tr?????ng n??y !',
                'end_time.after' => 'Th???i gian k???t th??c kh??ng ???????c nh??? h??n th???i gian b???t ?????u !',
                'description.required' => 'Ch??a nh???p tr?????ng n??y !',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd($id);
        DB::beginTransaction();
        try {
            $recruitment = Recruitment::find($id);
            // dd($recruitment);
            if (!$recruitment) {
                return redirect('error');
            }
            $recruitment->name = $request->name;
            $recruitment->start_time = $request->start_time;
            $recruitment->end_time = $request->end_time;
            $recruitment->description = $request->description;

            if ($request->has('image')) {
                $fileImage =  $request->file('image');
                $image = $this->uploadFile($fileImage);
                $recruitment->image = $image;
            }
            $recruitment->save();
            if ($request->enterprise_id != null) {
                $index = -1;
                Recruitment::find($id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
                foreach (Recruitment::find($id)->enterprise()->get() as $item) {
                    foreach ($request->enterprise_id as $value) {
                        if ($item->id == $value) {
                            $index = $value;
                        }
                    }
                    if ($item->id != $index) {
                        Recruitment::find($id)->enterprise()->detach($item->id);
                    }
                }
            } else {
                Recruitment::find($id)->enterprise()->detach();
            }
            if ($request->contest_id != null) {
                $count = -1;
                Recruitment::find($id)->contest()->syncWithoutDetaching($request->contest_id);
                foreach (Recruitment::find($id)->contest()->get() as $item) {
                    foreach ($request->contest_id as $value) {
                        if ($item->id == $value) {
                            $count = $value;
                        }
                    }
                    if ($item->id != $count) {
                        Recruitment::find($id)->contest()->detach($item->id);
                    }
                }
            } else {
                Recruitment::find($id)->contest()->detach();
            }

            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }
    public function listRecordSoftDeletes(Request $request)
    {
        $listSofts = $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return view('pages.recruitment.soft-delete', compact('listSofts'));
    }
    public function backUpRecruitment($id)
    {
        try {
            Recruitment::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    //x??a v??nh vi???n
    public function delete($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) return false;

            Recruitment::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function detail($id)
    {
        $data = Recruitment::find($id);

        return view('pages.recruitment.detailRecruitment', compact('data'));
    }
    public function apiShow(Request $request)
    {

        $data = $this->getList($request)->get();
        $data->load('contest');
        $data->load('enterprise');
        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data,
            ]
        );
    }
    public function apiDetail($id)
    {
        $data = Recruitment::find($id);
        $data->load('contest');
        $data->load('enterprise');
        return $this->responseApi(
            [
                "status" => true,
                "payload" => $data,
            ]
        );
    }
}