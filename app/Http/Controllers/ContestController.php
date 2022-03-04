<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Member;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function listContest(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $pageNumber = $request->has('page') ? $request->page : 1;
        $pageSize = $request->has('pageSize') ? $request->pageSize : config('util.HOMEPAGE_ITEM_AMOUNT');
        $major = $request->has('major') ? $request->major : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'date_start';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = Contest::where('status', config('util.ACTIVE_STATUS'))->where('name', 'like', "%$keyword%");
        if($major != null){
            $query->where('major_id', $major);
        }


        if($sortBy == "desc"){
            $query->orderByDesc($orderBy);
        }else{
            $query->orderBy($orderBy);
        }

        $offset = ($pageNumber-1)*$pageSize;
        $dataContent = $query->skip($offset)->take($pageSize)->get();

        $dataContent->load('teams');
        return response()->json([
            'status' => true,
            'payload' => $dataContent->toArray()
        ]);
    }
}
