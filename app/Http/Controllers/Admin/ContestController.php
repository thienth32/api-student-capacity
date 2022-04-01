<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
use App\Services\Traits\TUploadImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContestController extends Controller
{
    use TUploadImage;
    public function create()
    {
        $majors = Major::all();
        return view('pages.contest.form-add', compact('majors'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'img' => 'required|required|mimes:jpeg,png,jpg|max:10000',
                'date_start' => 'required|date',
                'register_deadline' => 'required|date|after:date_start',
                'description' => 'required'
            ],
            [
                'name.required' => 'Chưa nhập trường này !',
                'name.max' => 'Độ dài kí tự không phù hợp !',
                'img.mimes' => 'Sai định dạng !',
                'img.required' => 'Chưa nhập trường này !',
                'img.max' => 'Dung lượng ảnh không được vượt quá 10MB !',
                'date_start.required' => 'Chưa nhập trường này !',
                'date_start.date' => 'Sai định dạng !',
                'register_deadline.required' => 'Chưa nhập trường này !',
                'register_deadline.date' => 'Sai định dạng !',
                'register_deadline.after' => 'Thời gian kết thúc không được bằng thời gian bắt đầu !',
                'description.required' => 'Chưa nhập trường này !',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {
            $contest = new Contest();
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                $filename = $this->uploadFile($fileImage);
                $contest->img = $filename;
            }
            $contest->name = $request->name;
            $contest->date_start = $request->date_start;
            $contest->register_deadline = $request->register_deadline;
            $contest->description = $request->description;
            $contest->major_id = $request->major_id;
            $contest->status = config('util.ACTIVE_STATUS');
            $contest->save();
            Db::commit();
            return Redirect::route('admin.contest.list')->with('success', 'Thêm mới thành công !');
        } catch (Exception $ex) {
            if ($request->hasFile('img')) {
                $fileImage = $request->file('img');
                if (Storage::disk('google')->has($filename)) Storage::disk('google')->delete($filename);
            }
            Db::rollBack();
            return Redirect::back()->with('error', 'Thêm mới thất bại !');
        }
    }
}