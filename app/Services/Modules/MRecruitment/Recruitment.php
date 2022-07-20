<?php

namespace App\Services\Modules\MRecruitment;

use App\Models\Contest;
use App\Models\Enterprise;
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
        private Carbon $carbon
    ) {
    }
    public function getList(Request $request)
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
            $query =  $this->recruitment::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query =   $this->recruitment::where('name', 'like', "%$keyword%");
        if ($enterprise != null) {
            $query = $this->enterprise::find($enterprise);
        }
        if ($contest != null) {
            $query =  $this->contest::find($contest);
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
        if ($request->enterprise_id) {
            return   $this->getList($request)->recruitment()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        }
        if ($request->contest_id) {
            return $this->getList($request)->recruitment()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        }

        return $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
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
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
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

        if ($request->has('image')) {
            $fileImage =  $request->file('image');
            $image = $this->uploadFile($fileImage);
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
}
