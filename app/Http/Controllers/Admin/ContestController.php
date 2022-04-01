<?php

namespace App\Http\Controllers\Admin;
use App\Services\Traits\TUploadImage;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ContestController extends Controller
{
    use TUploadImage;
    public function edit($id)
    {
        $major = Major::orderBy('id', 'desc')->get();

        $Contest = Contest::find($id);
        // dd($Contest);
        if ($Contest) {
            return view('pages.contest.edit', compact('Contest', 'major'));
        } else {
            return view('errỏ');
        }
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => "required",
                'date_start' => "required",
                'register_deadline' => "required|after:date_start",
                'description' => "required",
                'major_id' => "required",
                'status' => "required",

            ],
            [
                "name.required" => "Tường name không bỏ trống !",
                "date_start.required" => "Tường thời gian bắt đầu  không bỏ trống !",
                "register_deadline.required" => "Tường thời gian kết thúc không bỏ trống !",
                "register_deadline.after" => "Tường thời gian kết thúc không nhỏ hơn trường bắt đầu  !",
                "description.required" => "Tường mô tả không bỏ trống !",
                "major_id.required" => "Tường cuộc thi tồn tại !",
                "status.required" => "Tường trạng thái không bỏ trống",

            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();

            $contest = Contest::find($id);

            if (is_null($contest)) {
                return response()->json([
                    "payload" => 'Không tồn tại trong cơ sở dữ liệu !'
                ], 500);
            } else {
                if ($request->has('img')) {
                    // dd($request->img);
                    $fileImage =  $request->file('img');
                    $img = $this->uploadFile($fileImage, $contest->img);
                    $contest->img = $img;
                }
             $contest->update($request->all());

                Db::commit();

                return Redirect::back();
            }



    }



}
