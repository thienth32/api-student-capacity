<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exams;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Round;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ExamController extends Controller
{
    use TUploadImage;
    private $exam;

    public function __construct(Exams $exam)
    {
        $this->exam = $exam;
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|unique:exams,name|min:4|max:255',
                'description' => 'required|min:4',
                'max_ponit' => 'required|numeric|min:0|max:1000',
                'ponit' => 'required|numeric|min:0|max:1000',
                'external_url' => 'required|mimes:zip,docx,word|file|max:10000',
                'round_id' => 'required|numeric',

            ], [
                'name.required' => 'Không bỏ trống trường tên !',
                'name.unique' => 'Trường tên đã tồn tại trong hệ thống !',
                'name.min' => 'Trường tên không nhỏ hơn 4 ký tự  !',
                'description.min' => 'Trường mô tả không nhỏ hơn 4 ký tự  !',
                'name.max' => 'Trường tên không lớn hơn 255 ký tự  !',
                'description.required' => 'Không bỏ trống trường mô tả !',
                'max_ponit.required' => 'Không bỏ trống trường thang điểm !',
                'max_ponit.numeric' => 'Trường thang điểm phải thuộc dạng số !',
                'max_ponit.min' => 'Trường thang điểm phải là số dương !',
                'max_ponit.max' => 'Trường thang điểm không quá 1000 !',

                'ponit.numeric' => 'Trường điểm phải thuộc dạng số !',
                'ponit.max' => 'Trường điểm không quá 1000 !',
                'ponit.min' => 'Trường điểm phải là số dương !',
                'ponit.required' => 'Không bỏ trống trường điểm !',

                'external_url.mimes' => 'Trường đề thi không đúng định dạng !',
                'external_url.required' => 'Không bỏ trống trường đề bài !',
                'external_url.file' => 'Trường đề bài phải là một file  !',
                'external_url.max' => 'Trường đề bài dung lượng quá lớn !',

                'round_id.numeric' => 'Trường vòng thi phải thuộc dạng số !',
                'round_id.required' => 'Không bỏ trống trường vòng thi !',
            ]);

            $filename = $this->uploadFile($request->external_url);
            $dataCreate = array_merge($request->only([
                'name',
                'description',
                'max_ponit',
                'ponit',
                'round_id',
            ]), [
                'external_url' => $filename
            ]);
            $this->exam::create($dataCreate);
            return true;
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return abort(404);
        }
    }

    public function download(Request $request)
    {
        if (Storage::disk('google')->has($request->external_url ?? '')) {
            return Storage::disk('google')->download($request->external_url);
        }
        return 'Không có tài liệu nào phù hợp !';
    }

    public function destroy($id)
    {
        try {
            $exam = $this->exam::find($id);
            $exam->delete($id);
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function apiUpdate(Request $request, $id)
    {
        $examModel = Exams::find($id);
        if (is_null($examModel)) return Response::json([
            'status' => false,
            'payload' => 'Không tìm thấy đề bài trong cơ sở dữ liệu !!'
        ]);
        $validate = validator::make(
            $request->all(),
            [
                'name' => 'required|unique:exams,name|min:4|max:255',
                'description' => 'required|min:4',
                'max_ponit' => 'required|numeric|min:0|max:1000',
                'ponit' => 'required|numeric|min:0|max:1000',
                'external_url' => 'required|mimes:zip,docx,word|file|max:10000',
                'round_id' => 'required|numeric',

            ],
            [
                'name.required' => 'Không bỏ trống trường tên !',
                'name.unique' => 'Trường tên đã tồn tại trong hệ thống !',
                'name.min' => 'Trường tên không nhỏ hơn 4 ký tự  !',
                'description.min' => 'Trường mô tả không nhỏ hơn 4 ký tự  !',
                'name.max' => 'Trường tên không lớn hơn 255 ký tự  !',
                'description.required' => 'Không bỏ trống trường mô tả !',
                'max_ponit.required' => 'Không bỏ trống trường thang điểm !',
                'max_ponit.numeric' => 'Trường thang điểm phải thuộc dạng số !',
                'max_ponit.min' => 'Trường thang điểm phải là số dương !',
                'max_ponit.max' => 'Trường thang điểm không quá 1000 !',

                'ponit.numeric' => 'Trường điểm phải thuộc dạng số !',
                'ponit.max' => 'Trường điểm không quá 1000 !',
                'ponit.min' => 'Trường điểm phải là số dương !',
                'ponit.required' => 'Không bỏ trống trường điểm !',

                'external_url.mimes' => 'Trường đề thi không đúng định dạng !',
                'external_url.required' => 'Không bỏ trống trường đề bài !',
                'external_url.file' => 'Trường đề bài phải là một file  !',
                'external_url.max' => 'Trường đề bài dung lượng quá lớn !',

                'round_id.numeric' => 'Trường vòng thi phải thuộc dạng số !',
                'round_id.required' => 'Không bỏ trống trường vòng thi !',
            ]
        );
        if ($validate->fails()) return response()->json([
            'status' => false,
            'payload' => $validate->errors()
        ]);

        DB::beginTransaction();
        try {
            $roundContest = Round::find($request->round_id);
            if (is_null($roundContest)) return Response::json([
                'status' => false,
                'payload' => 'Không tìm thấy vòng thi trong cơ sở dữ liệu !!'
            ]);
            if ($request->has('external_url')) {
                $fileImage =  $request->file('external_url');
                $external_url = $this->uploadFile($fileImage, $examModel->external_url);
                $examModel->external_url = $external_url;
            }
            $examModel->name = $request->name;
            $examModel->description = $request->description;
            $examModel->max_ponit = $request->max_ponit;
            $examModel->ponit = $request->ponit;
            $examModel->round_id = $request->round_id;
            $examModel->save();
            DB::commit();
            return Response::json([
                'status' => true,
                'payload' => 'Cập nhập thành công !!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response::json([
                'status' => false,
                'payload' => $th
            ]);
        }
    }
}