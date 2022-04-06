<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Judge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JudgesController extends Controller
{

    private $contest;
    private $user;
    public function __construct(Contest $contest, User $user)
    {
        $this->contest = $contest;
        $this->user = $user;
    }
    public function getJudgesContest($contest_id)
    {
        $contest = Contest::find($contest_id);
        $contest->load('judges');
        return view('pages.judges.judges-contest', compact('contest'));
    }

    public function attachJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->syncWithoutDetaching($request->user_id);
            return response()->json(['status' => true, 'payload' => 'Thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }
    public function syncJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->sync($request->user_id);
            return response()->json(['status' => true,  'payload' => 'Thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }

    public function detachJudges(Request $request, $contest_id)
    {
        try {
            Contest::find($contest_id)->judges()->detach([$request->user_id]);
            return response()->json(['status' => true,  'payload' => 'Xóa thành công !'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'payload' => "Có vẻ đang bị lỗi ở :" . $th], 500);
        }
    }
}