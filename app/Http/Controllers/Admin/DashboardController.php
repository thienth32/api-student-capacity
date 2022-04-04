<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $totalContestRegistering = Contest::where('status', config('util.CONTEST_STATUS_REGISTERING'))->count();
        $totalContestGoingOn = Contest::where('status', config('util.CONTEST_STATUS_GOING_ON'))->count();
        $totalContestDone = Contest::where('status', config('util.CONTEST_STATUS_DONE'))->count();

        $totalTeamActive = Team::with('contest')
                                ->whereHas('contest', function($q){
                                    $q->whereIn('status', [config('util.CONTEST_STATUS_REGISTERING'), config('util.CONTEST_STATUS_GOING_ON')]);
                                })
                                ->count();
        $totalStudentAccount = User::with('roles')
                                ->whereHas('roles', function($q){
                                    $q->where('id', config('util.STUDENT_ROLE'));
                                })->count();
        return view('dashboard.index', compact(
            'totalContestRegistering', 
            'totalContestGoingOn', 
            'totalContestDone',
            'totalTeamActive',
            'totalStudentAccount'
        ));
    }

    public function chartCompetity(Request $request){
        $start = date($request->startDate);
        $end = date($request->endDate);
        $lstContest = Contest::with('teams')
                                ->where('status', config('util.CONTEST_STATUS_REGISTERING'))
                                ->whereBetween('register_deadline', [$start, $end])
                                ->orderByDesc('id')
                                ->get();
        return response()->json([
            'status' => true,
            'data' => $lstContest
        ]);
    }
}
