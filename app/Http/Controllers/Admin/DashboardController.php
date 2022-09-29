<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Team;
use App\Models\User;
use App\Services\Modules\MContest\MContestInterface;
use App\Services\Modules\MTeam\MTeamInterface;
use App\Services\Modules\MUser\MUserInterface;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function __construct(
        private MContestInterface $contest,
        private Carbon $carbon,
        private CarbonPeriod $carbonPeriod,
        private MUserInterface $user,
        private MTeamInterface $team,
    ) {
    }

    public function index(Request $request)
    {
        $totalContestGoingOn = $this->contest->getCountContestGoingOn();

        $totalTeamActive = $this->team->getTotalTeamActive();

        $totalStudentAccount = $this->user->getTotalStudentAcount();

        $dt = $this->carbon::now('Asia/Ho_Chi_Minh');
        $dt2 = $this->carbon::now('Asia/Ho_Chi_Minh');
        $dt3 = $this->carbon::now('Asia/Ho_Chi_Minh');
        $timeNow   = $this->carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();
        $contests = $this->contest->getContestMapSubDays($dt->subDays(2)->toDateTimeString());
        $contestsDealineNow = $this->contest->getContestByDateNow($this->carbon::now('Asia/Ho_Chi_Minh'));
        $period = $this->carbonPeriod::create($dt3->subDays(2)->toDateTimeString(), $dt2->addDays(7)->toDateTimeString());

        return view('dashboard.index', compact(
            'totalContestGoingOn',
            'totalTeamActive',
            'totalStudentAccount',
            'contests',
            'period',
            'timeNow',
            'contestsDealineNow'
        ));
    }

    public function chartCompetity(Request $request)
    {
        $start = date($request->startDate);
        $end = date($request->endDate);
        $lstContest = Contest::with('teams')
            ->where('status', config('util.CONTEST_STATUS_GOING_ON'))
            ->whereBetween('register_deadline', [$start, $end])
            ->orderByDesc('id')
            ->get();
        return response()->json([
            'status' => true,
            'data' => $lstContest
        ]);
    }
}