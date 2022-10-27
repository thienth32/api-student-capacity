<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailUploadCV;
use App\Mail\MailUploadCV;
use App\Models\Candidate;
use App\Models\Post;
use App\Models\Recruitment;
use App\Services\Modules\MCandidate\Candidate as MCandidateCandidate;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    use TUploadImage;
    use TResponse, TStatus;
    public function __construct(
        private Candidate $candidate,
        private Post $post,
        private MCandidateCandidate $MCandidate,
        private DB $db,
        private Storage $storage
    ) {
    }
    public function index(Request $request)
    {
        $posts = $this->post::where('postable_type', Recruitment::class)->get();
        $candidates = $this->MCandidate->index($request);
        return view('pages.candidate.index', [
            'candidates' => $candidates,
            'posts' => $posts
        ]);
    }
    public function detail($id)
    {
        if (!$id) return abort(404);
        $data = $this->candidate::find($id);

        return view('pages.candidate.detail', compact('data'));
    }
    public function listCvUser(Request $request)
    {
        try {
            if (!$request->has('post_id') || !$request->has('email')) return abort(404);
            $candidates = $this->MCandidate->listCvUser($request);
            return view('pages.candidate.list-cv-user', compact('candidates'));
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) return abort(404);
            $this->db::transaction(function () use ($id) {
                if (!($this->candidate::where('id', $id)->get())) return abort(404);
                $this->candidate::where('id', $id)->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    public function listRecordSoftDeletes(Request $request)
    {
        $posts = $this->post::where('postable_type', Recruitment::class)->get();
        $listSofts = $this->MCandidate->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return view('pages.candidate.candidate-soft-delete', compact('listSofts', 'posts'));
    }
    public function backUpPost($id)
    {
        try {
            $this->candidate::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    //xóa vĩnh viễn
    public function delete($id)
    {
        // dd($id);
        try {
            if (!(auth()->user()->hasRole('super admin'))) abort(404);

            $this->candidate::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
    /**
     * @OA\Post(
     *      path="/api/public/candidate/add",
     *     description="Tải Cv lên ",
     *      tags={"Candidate"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *          mediaType="multipart/form-data" ,
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="post_id",

     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="name",

     *                  ),
     *   @OA\Property(
     *                      type="string",
     *                      property="phone",

     *                  ),
     *   @OA\Property(
     *                      type="string",
     *                      property="email",

     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="file_link",

     *                  ),
     *              ),
     *          ),
     *      ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function ApiAddCandidate(Request $request)
    {
        $rules = [
            'post_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'file_link' => 'required|mimes:zip,docx,word,pdf|file|max:10000',
        ];
        $message = [
            'post_id.required' => 'Mã tuyển dụng không được bỏ trống ',
            'name.required' => 'Họ Tên không được bỏ trống ',
            'email.required' => 'Email không được bỏ trống ',
            'email.email' => 'Email sai định dạng ',
            'phone.required' => 'Số điện thoạt không được bỏ trống ',
            'file_link.required' => 'Link CV không được bỏ trống ',
            'file_link.mimes' => 'Link CV không đúng định dạng . Yêu cầu file zip,docx,word,pdf , tối đa dung lượng file 10MB  !',
            'file_link.file' => 'Link CV phải là một file  . Yêu cầu file zip,docx,word,pdf , tối đa dung lượng file 10MB  !',
            'file_link.max' => 'Link CV dung lượng quá lớn. Tối đa 10MB !',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        $addCandidate =   $this->MCandidate->store($request);
        if (!$addCandidate) return $this->responseApi(false, ' Lỗi upload CV !');
        $sizeFile = Storage::disk('s3')->size($addCandidate->file_link);
        $sizeFileFormat =  number_format($sizeFile / 1048576, 2);
        $addCandidate['file_link'] = Storage::disk('s3')->temporaryUrl($addCandidate->file_link, now()->addMinutes(5));
        $addCandidate['sizeFile'] = $sizeFileFormat;
        $email = new SendMailUploadCV($addCandidate);
        dispatch($email);
        return $this->responseApi(true, 'Upload Cv thành công !', ['data' => $addCandidate]);
    }
    public function ApiDetailCandidate($id)
    {
        $data = $this->candidate::find($id);
        if (!$data) abort(404);
        return $this->responseApi(
            true,
            $data
        );
    }
}
