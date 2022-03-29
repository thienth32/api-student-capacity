<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Member;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $contest;

    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    /**
     *  Get list contest
     */
    private function getList()
    {
        try {
            $data = $this->contest::all();
            // if(request()->ajax()){}
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    //  View contest
    public function index()
    {
        if (!($data = $this->getList())) return view('not_found');
        $data = $this->getList();
        return view('', ['contests' => $data]);
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
}