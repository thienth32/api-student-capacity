<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    private $round;

    public function __construct(Round $round)
    {
        $this->round = $round;
    }

    /**
     *  Get list round
     */
    private function getList()
    {
        try {
            $data = $this->round::search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'desc' : 'asc'), request('sort_by') ?? null, 'rounds')
                ->hasContest(request('contest_id') ?? null)
                ->hasTypeExam(request('type_exam_id') ?? null)
                ->with([
                    'contest',
                    'type_exam',
                ])
                ->paginate(request('limit') ?? 10);
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View round
    public function index()
    {
        if (!($data = $this->getList())) return view('not_found');
        $data = $this->getList();
        return view('', ['rounds' => $data]);
    }

    //  Response round
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
     *  End round
     */
}