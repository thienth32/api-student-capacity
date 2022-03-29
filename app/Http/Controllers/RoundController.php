<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Image;

class RoundController extends Controller
{
    public function addRound(Request $request)
    {

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'name' => 'required|max:255',
        //         'image' => 'required|size:<=10000',
        //         'start_time' => 'required|date',
        //         'end_time' => 'required|date',
        //         'description' => 'required',
        //         'contest_id' => 'required|numeric',
        //         'type_exam_id' => 'required|numeric',
        //     ],
        //     [
        //         'name.required' => 'Chưa nhập trường này !',
        //         'name.max' => 'Độ dài kí tự không phù hợp !',
        //         'image.required' => 'Chưa nhập trường này !',
        //         'image.size' => 'Dung lượng ảnh không được vượt quá 10MB !',
        //         'start_time.required' => 'Chưa nhập trường này !',
        //         'start_time.date' => 'Sai định dạng !',
        //         'end_time.required' => 'Chưa nhập trường này !',
        //         'end_time.date' => 'Sai định dạng !',
        //         'description.required' => 'Chưa nhập trường này !',
        //         'contest_id.required' => 'Chưa nhập trường này !',
        //         'contest_id.numeric' => 'Sai định dạng !',
        //         'type_exam_id.required' => 'Chưa nhập trường này !',
        //         'type_exam_id.numeric' => 'Sai định dạng !',

        //     ]
        // );
        // // dd($validator->errors()->toArray());
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
                $filename = time() . '_' . rand(01, 99) . '_img.' .  $fileImage->getClientOriginalExtension();
                //get name
                Storage::disk("google")->putFileAs("", $fileImage, $filename);
                //get url
                // $url = Storage::disk('google')->url($name);

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
            return response()->json([
                "payload" => $round
            ], 200);
        } catch (Exception $ex) {

            Db::rollBack();
            return response()->json([
                "payload" => $ex
            ], 500);
        }
    }
}