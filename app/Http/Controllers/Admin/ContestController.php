<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $contest;
    private $major;

    public function __construct(Contest $contest, Major $major)
    {
        $this->contest = $contest;
        $this->major = $major;
    }

    /**
     *  Get list contest
     */
    private function getList()
    {
        try {
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            $data = $this->contest::search(request('q') ?? null, ['name', 'description'])
                ->missingDate('register_deadline', request('miss_date') ?? null, $now->toDateTimeString())
                ->passDate('register_deadline', request('pass_date') ?? null, $now->toDateTimeString())
                // ->passDate('date_start', request('upcoming_date') ?? null, $now->toDateTimeString())
                ->status(request('status'))
                ->sort((request('sort') == 'desc' ? 'desc' : 'asc'), request('sort_by') ?? null, 'contests')
                ->hasDateTimeBetween('date_start', request('start_time') ?? null, request('end_time') ?? null)
                ->hasReuqest(['major_id' => request('major_id') ?? null])
                ->with([
                    'major',
                    'teams',
                ])
                ->withCount('teams')
                ->paginate(request('limit') ?? 10);
            // if(request()->ajax()){}
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View contest
    public function index()
    {
        if (!($data = $this->getList())) return abort(404);

        return view('pages.contest.index', [
            'contests' => $data,
            'majors' => $this->major::all(),
        ]);
    }

    //  Response contest
    public function apiIndex()
    {

        if (!($data = $this->getList())) return response()->json([
            "status" => false,
            "payload" => "Server not found",
        ], 404);
        return response()->json([
            "status" => true,
            "payload" => $data,
        ], 200);
    }
    /**
     *  End contest
     */

    public function un_status($id)
    {
        try {
            $contest = $this->contest::find($id);
            $contest->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        try {
            $contest = $this->contest::find($id);
            $contest->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }



    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return redirect()->back()->with('error', 'Không thể xóa ');
            $contest = $this->contest::find($id);
            $contest->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Xóa không thành công ');
        }
    }
}