<?php
namespace App\Services\Modules\MContest;

use App\Models\Major;
use App\Models\Contest as ModelContest;
use App\Models\Team;
use Carbon\Carbon;

class Contest
{
    private $contest;
    private $major;
    private $team;

    public function __construct(ModelContest $contest, Major $major, Team $team)
    {
        $this->contest = $contest;
        $this->major = $major;
        $this->team = $team;
    }

    public function getList($with , $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        return  $this->contest::when($request->has('contest_soft_delete'), function ($q) {
                    return $q->onlyTrashed();
                })
                ->when(auth()->check() && auth()->user()->hasRole('judge'), function ($q) {
                    return $q->whereIn('id', array_unique(Judge::where('user_id', auth()->user()->id)->pluck('contest_id')->toArray()));
                })
                ->search($request->q ?? null, ['name'], true)
                ->missingDate('register_deadline', $request->miss_date ?? null, $now->toDateTimeString())
                ->passDate('register_deadline', $request->pass_date ?? null, $now->toDateTimeString())
                ->registration_date('end_register_time', $request->registration_date ?? null, $now->toDateTimeString())
                ->status($request->status)
                ->sort(($request->sort == 'asc' ? 'asc' : 'desc'), $request->sort_by ?? null, 'contests')
                ->hasDateTimeBetween('date_start', $request->start_time ?? null, $request->end_time ?? null)
                // ->hasDateTimeBetween('end_register_time',request('registration_date'))
                ->hasRequest(['major_id' => $request->major_id ?? null])
                ->with($with)
                ->withCount('teams');
    }

    public function store($filename , $request)
    {

        $contest = new $this->contest();
        if ($request->hasFile('img')) {
            $fileImage = $request->file('img');
            $filename = $this->uploadFile($fileImage);
            $contest->img = $filename;
        }
        $contest->name = $request->name;
        $contest->img = $filename;
        $contest->max_user = $request->max_user ?? 9999;
        $contest->date_start = $request->date_start;
        $contest->start_register_time = $request->start_register_time ?? null;
        $contest->end_register_time = $request->end_register_time ?? null;
        $contest->register_deadline = $request->register_deadline;
        $contest->description = $request->description;
        $contest->post_new = $request->post_new;
        $contest->major_id = $request->major_id;
        $contest->type = request('type') ?? 0;
        $contest->status = config('util.ACTIVE_STATUS');
        $rewardRankPoint = json_encode(array(
            'top1' => $request->top1,
            'top2' => $request->top2,
            'top3' => $request->top3,
            'leave' => $request->leave,
        ));
        $contest->reward_rank_point =  $rewardRankPoint;
        $contest->save();

    }

    public function find($id)
    {
        return $this->contest::find($id);
    }

    public function update($contest,$data)
    {
        $contest->update($data);
    }

    public function getContest()
    {
        return $this->contest;
    }
}
