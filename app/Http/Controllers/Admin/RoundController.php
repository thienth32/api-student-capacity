<?php

namespace App\Http\Controllers\Admin;

use Image;
use Exception;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\TypeExam;
use Illuminate\Support\Facades\File;
use App\Services\Traits\TUploadImage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RoundController extends Controller
{
    use TUploadImage;

    public function create()
    {
        $contests = Contest::all();
        $typeexams = TypeExam::all();
        return view('page.round.form-add', compact('contests', 'typeexams'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'description' => 'required',
                'contest_id' => 'required|numeric',
                'type_exam_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'image.mimes' => 'Sai định dạng !',
                'image.required' => 'Chưa nhập trường này !',
                'image.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'start_time.required' => 'Chưa nhập trường này !',
                'start_time.date' => 'Sai định dạng !',
                'end_time.required' => 'Chưa nhập trường này !',
                'end_time.date' => 'Sai định dạng !',
                'end_time.after' => 'Thời gian kết thúc không được bằng thời gian bắt đầu !',
                'description.required' => 'Chưa nhập trường này !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
                'type_exam_id.required' => 'Chưa nhập trường này !',
                'type_exam_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => false,
        //         'payload' => $validator->errors()
        //     ]);
        // }
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $fileImage = $request->file('image');
                $filename = $this->uploadFile($fileImage);
            }
            $round = new Round();
            $round->name = $request->name;
            $round->image = $filename;
            $round->start_time = $request->start_time;
            $round->end_time = $request->end_time;
            $round->description = $request->description;
            $round->contest_id = $request->contest_id;
            $round->type_exam_id = $request->type_exam_id;
            $round->save();
            Db::commit();
            // return response()->json([
            //     "payload" => $round
            // ], 200);
            return Redirect::back()->with(['msg' => 'Thêm thành công !']);
        } catch (Exception $ex) {

            Db::rollBack();
            return Redirect::back()->with(['err' => 'Thêm mới thất bại !']);
        }
    }
}