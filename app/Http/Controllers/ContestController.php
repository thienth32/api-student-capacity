<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Major;
use App\Models\Member;
use Illuminate\Http\Request;

class ContestController extends Controller
{
     //Api các cuộc thi Đang diễn ra
    public function listContest(Request $request)
    {
        $dataMajor = Major::all();

        $keyword = $request->has('keyword') ? $request->keyword : "";
        $pageNumber = $request->has('page') ? intval($request->page) : 1;
        $pageSize = $request->has('pageSize') ? intval($request->pageSize) : config('util.HOMEPAGE_ITEM_AMOUNT');
        $major = $request->has('major') ? $request->major : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'date_start';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query = Contest::where('status', config('util.ACTIVE_STATUS'))->where('name', 'like', "%$keyword%");
        if ($major != null) {
            $query->where('major_id', $major);
        }

        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }

        $offset = ($pageNumber - 1) * $pageSize;
        $totalItem = $query->count();
        $dataContent = $query->skip($offset)->take($pageSize)->get();

        $dataContent->load('teams');
        return response()->json([
            'status' => true,
            'dataMajor' => $dataMajor->toArray(),
            'payload' => [
                'major' => $major,
                'data' => $dataContent->toArray(),
                'pagination' => [
                    'currentPage' => $pageNumber,
                    'pageSize' => $pageSize,
                    'totalItem' => $totalItem,
                    'totalPage' => ceil($totalItem / $pageSize)
                ]
            ]
        ]);
    }
     // các cuộc thi đang diễn ra

    //Api các cuộc thi đã kết thúc
    public function ContestOff(Request $request)
    {
        $dataMajor = Major::all();
        $keyword = $request->has('keyword') ? $request->keyword : "";
        //ACTIVE_STATUS

        //INACTIVE_STATUS
        $pageNumber2 = $request->has('page2') ? intval($request->page2) : 1;
        $pageSize2 = $request->has('pageSize2') ? intval($request->pageSize2) : config('util.HOMEPAGE_ITEM_AMOUNT');

        $major = $request->has('major') ? $request->major : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'date_start';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query2 = Contest::where('status', config('util.INACTIVE_STATUS'))->where('name', 'like', "%$keyword%");
        if ($major != null) {

            $query2->where('major_id', $major);
        }
        if ($sortBy == "desc") {

            $query2->orderByDesc($orderBy);
        } else {

            $query2->orderBy($orderBy);
        }




        $offset2 = ($pageNumber2 - 1) * $pageSize2;
        $totalItem2 = $query2->count();
        $dataContent2 = $query2->skip($offset2)->take($pageSize2)->get();



        $dataContent2->load('teams');
        return response()->json([
            'status' => true,
            'payload' => [
                'dataMajor' => $dataMajor->toArray(),


                'data2' => $dataContent2->toArray(),
                'major' => $major,

                'pagination2' => [
                    'currentPage2' => $pageNumber2,
                    'pageSize2' => $pageSize2,
                    'totalItem2' => $totalItem2,
                    'totalPage2' => ceil($totalItem2 / $pageSize2)
                ]

            ]
        ]);
    }
     // Api các cuộc thi chuẩn bị diễn ra
    public function contestUpcoming(Request $request)
    {

        $dataMajor = Major::all();
        $keyword = $request->has('keyword') ? $request->keyword : "";

        //UPCOMING_STATUS
        $pageNumber1 = $request->has('page1') ? intval($request->page1) : 1;
        $pageSize1 = $request->has('pageSize1') ? intval($request->pageSize1) : config('util.HOMEPAGE_ITEM_AMOUNT');


        $major = $request->has('major') ? $request->major : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'date_start';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";

        $query1 = Contest::where('status', config('util.UPCOMING_STATUS'))->where('name', 'like', "%$keyword%");

        if ($major != null) {

            $query1->where('major_id', $major);
        }
        if ($sortBy == "desc") {

            $query1->orderByDesc($orderBy);
        } else {

            $query1->orderBy($orderBy);
        }




        $offset1 = ($pageNumber1 - 1) * $pageSize1;
        $totalItem1 = $query1->count();
        $dataContent1 = $query1->skip($offset1)->take($pageSize1)->get();




        $dataContent1->load('teams');

        return response()->json([
            'status' => true,

            'payload' => [
                'dataMajor' => $dataMajor->toArray(),


                'data1' => $dataContent1->toArray(),

                'major' => $major,

                'pagination1' => [
                    'currentPage1' => $pageNumber1,
                    'pageSize1' => $pageSize1,
                    'totalItem1' => $totalItem1,
                    'totalPage1' => ceil($totalItem1 / $pageSize1)
                ]


            ]
        ]);
    }
}
