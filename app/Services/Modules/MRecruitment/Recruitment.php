<?php

namespace App\Services\Modules\MRecruitment;

use App\Models\Contest;
use App\Models\ContestRecruitment;
use App\Models\ContestSkill;
use App\Models\Enterprise;
use App\Models\EnterpriseRecruitment;
use App\Models\Recruitment as ModelsRecruitment;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Recruitment
{
    use TUploadImage;
    public function __construct(
        private Contest $contest,
        private Enterprise $enterprise,
        private ModelsRecruitment $recruitment,
        private Carbon $carbon,
        private EnterpriseRecruitment $enterpriseRecruitment,
        private ContestRecruitment $contestRecruitment,
        private ContestSkill $contestSkill,
    ) {
    }
    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $enterprise = $request->has('enterprise_id') ? $request->enterprise_id : null;
        $contest = $request->has('contest_id') ? $request->contest_id : null;
        $major = $request->has('major_id') ? $request->major_id : null;
        $skill = $request->has('skill_id') ? $request->skill_id : null;
        $recruitmentHot =  $request->has('recruitmentHot') ? $request->recruitmentHot : null;
        $progress = $request->has('progress') ? $request->progress : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $startTime = $request->has('startTime') ? $request->startTime : null;
        $endTime = $request->has('endTime') ? $request->endTime : null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('recruitment_soft_delete') ? $request->recruitment_soft_delete : null;
        if ($softDelete != null) {
            $query =  $this->recruitment::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->recruitment::where('name', 'like', "%$keyword%");

        if ($recruitmentHot != null) {
            if ($recruitmentHot == 'hot') {
                $query->where('hot', 1);
            } else {
                $query->where('hot', 0);
            }
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
            $query->where('start_time', '>=', \Carbon\Carbon::parse(request('startTime'))->toDateTimeString())->where('start_time', '<=', \Carbon\Carbon::parse(request('endTime'))->toDateTimeString());
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        if ($enterprise != null) {
            $recruitmentsId =  $this->enterpriseRecruitment::where('enterprise_id', $enterprise)->pluck('recruitment_id')->toArray();
            $query->whereIn('id', $recruitmentsId);
        }
        if ($contest != null) {
            $recruitmentsIdInContest = $this->contestRecruitment::where('contest_id', $contest)->pluck('recruitment_id')->toArray();
            $query->whereIn('id',  $recruitmentsIdInContest);
        }
        if ($major != null) {
            $contest_id = $this->contest::where([['major_id', $major], ['type', config('util.TYPE_TEST')]])->pluck('id')->toArray();
            $recruitmentsIdInContest = $this->contestRecruitment::whereIn('contest_id', array_unique($contest_id))->pluck('recruitment_id')->toArray();
            $query->whereIn('id', array_unique($recruitmentsIdInContest));
        }
        if ($skill != null) {
            $contest_id = $this->contestSkill::where('skill_id', $skill)->pluck('contest_id')->toArray();
            $recruitmentsIdInContest = $this->contestRecruitment::whereIn('contest_id', array_unique($contest_id))->pluck('recruitment_id')->toArray();
            $query->whereIn('id', array_unique($recruitmentsIdInContest));
        }
        return $query;
    }
    public function index(Request $request)
    {
        // ->paginate(request('limit') ?? 10);
        return $this->getList($request)->paginate(request('limit') ?? 10);
    }
    public function find($id)
    {

        return $this->recruitment::find($id);
    }
    public function store($request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'cost' => $request->cost,
            'amount' => $request->amount,
        ];
        if ($request->has('image')) {
            $fileImage =  $request->file('image');
            $image = $this->uploadFile($fileImage);
            $data['image'] = $image;
        }
        $newRecruitment =  $this->recruitment::create($data);
        if ($newRecruitment) {
            if ($request->enterprise_id != null) {
                $this->recruitment::find($newRecruitment->id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
            }
            if ($request->contest_id != null) {
                $this->recruitment::find($newRecruitment->id)->contest()->syncWithoutDetaching($request->contest_id);
            }
        }
    }
    public function update($request, $id)
    {
        $recruitment = $this->recruitment::find($id);

        if (!$recruitment) {
            return redirect('error');
        }
        $recruitment->name = $request->name;
        $recruitment->start_time = $request->start_time;
        $recruitment->end_time = $request->end_time;
        $recruitment->description = $request->description;
        $recruitment->cost = $request->cost;
        $recruitment->amount = $request->amount;
        $recruitment->short_description = $request->short_description;
        if ($request->has('image')) {
            $fileImage =  $request->file('image');
            $image = $this->uploadFile($fileImage, $recruitment->image);
            $recruitment->image = $image;
        }
        $recruitment->save();
        if ($request->enterprise_id != null) {
            $index = -1;
            $this->recruitment::find($id)->enterprise()->syncWithoutDetaching($request->enterprise_id);
            foreach ($this->recruitment::find($id)->enterprise()->get() as $item) {
                foreach ($request->enterprise_id as $value) {
                    if ($item->id == $value) {
                        $index = $value;
                    }
                }
                if ($item->id != $index) {
                    $this->recruitment::find($id)->enterprise()->detach($item->id);
                }
            }
        } else {
            $this->recruitment::find($id)->enterprise()->detach();
        }
        if ($request->contest_id != null) {
            $count = -1;
            $this->recruitment::find($id)->contest()->syncWithoutDetaching($request->contest_id);
            foreach ($this->recruitment::find($id)->contest()->get() as $item) {
                foreach ($request->contest_id as $value) {
                    if ($item->id == $value) {
                        $count = $value;
                    }
                }
                if ($item->id != $count) {
                    $this->recruitment::find($id)->contest()->detach($item->id);
                }
            }
        } else {
            $this->recruitment::find($id)->contest()->detach();
        }
    }
    public function LoadSkillAndUserApiShow($data)
    {
        // $data->load(['contest:id,name']);
        // $arrSkill = [];
        // foreach ($data as $item) {
        //     foreach ($item->skillHasManyDeep->makeHidden(['created_at', 'description', 'deleted_at', 'updated_at', 'laravel_through_key']) as $skill) {
        //         $arrSkill[] = $skill;
        //     }
        //     $item['skill'] = collect($arrSkill)->unique('id')->values()->all();
        //     $arrSkill = [];
        // }
        // $arrSkill = [];
        // foreach ($data as $item) {
        //     foreach ($item->contest as $contest) {
        //         foreach ($contest->skills->makeHidden(['created_at', 'description', 'deleted_at', 'updated_at']) as $skill) {
        //             $arrSkill[] = $skill;
        //         }
        //     }
        //     $item['skill'] = collect($arrSkill)->unique('id')->values()->all();
        //     $arrSkill = [];
        // }
        $arrUser = [];
        foreach ($data as $item) {
            foreach ($item->contest as $contest) {
                foreach ($contest->resultCapacity as $users)
                    $arrUser[] = $users->user;
            }
            $item['count_user'] = count(collect($arrUser)->unique('id')->values()->all());
            // $item['user'] = collect($arrUser)->unique('id')->values()->all();
            $arrUser = [];
        }
    }
    public function loadSkillAndUserApiDetail($data)
    {
        // $arr = [];
        // foreach ($data->contest as $contest) {
        //     foreach ($contest->skills as $skill) {
        //         $arr[] = $skill;
        //     }
        // }
        // $data['skill'] = collect($arr)->unique('id')->values()->all();
        // $arr = [];

        $arrUser = [];
        foreach ($data->contest as $contest) {
            foreach ($contest->resultCapacity as $users)
                $arrUser[] = $users->user;
        }
        $data['count_user'] = count(collect($arrUser)->unique('id')->values()->all());
        // $data['user'] = collect($arrUser)->unique('id')->values()->all();;
        $arrUser = [];
    }
}
