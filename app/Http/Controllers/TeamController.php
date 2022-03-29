<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{

    public function update(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'image' => 'size:<=10000',
                'contest_id' => 'required|numeric',
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'image.size' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'contest_id.required' => 'Chưa nhập trường này !',
                'contest_id.numeric' => 'Sai định dạng !',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validator->errors()
            ]);
        }
        DB::beginTransaction();
        try {
            $team = Team::find($id);
            if (is_null($team)) {
                return response()->json([
                    "payload" => 'Không tồn tại trong cơ sở dữ liệu !'
                ], 500);
            } else {
                if ($request->has('image')) {
                    if (Storage::disk('google')->has($team->image)) {
                        Storage::disk('google')->delete($team->image);
                    }
                    $fileImage =  $request->file('image');
                    $filename = time() . '_' . rand(01, 99) . '_img.' .  $fileImage->getClientOriginalExtension();
                    $image =  $fileImage->store($filename, "google");
                    Storage::disk("google")->putFileAs("", $fileImage, $filename);
                }
                $team->name = $request->name;
                $team->image = $image;
                $team->contest_id = $request->contest_id;
                $team->save();
                Db::commit();
                return response()->json([
                    "payload" =>  $team
                ], 200);
            }
        } catch (Exception $ex) {
            Db::rollBack();
            return response()->json([
                "payload" => $ex
            ], 500);
        }
    }
}