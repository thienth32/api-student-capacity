<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Post;
use App\Services\Modules\MCandidate\Candidate as MCandidateCandidate;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $posts = $this->post::where('');
        $candidates = $this->MCandidate->index($request);
        return view('pages.candidate.index', ['candidates' => $candidates]);
    }
    /**
     * @OA\Post(
     *      path="/api/public/candidate",
     *     description="Đăng kí đội thi đồng thời người đăng kí sẽ là nhóm trưởng",
     *      tags={"Team","Api V1"},
     *        summary="Authorization",
     *     security={{"bearer_token":{}}},

     *     @OA\RequestBody(
     *          @OA\MediaType(
     *          mediaType="multipart/form-data" ,
     *              @OA\Schema(
     *                  @OA\Property(
     *                      type="number",
     *                      property="contest_id",
     *                  ),
     *                  @OA\Property(
     *                      type="string",
     *                      property="name",
     *                  ),
     *                  @OA\Property(
     *                      type="file",
     *                      property="image",
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'file_link' => 'required|mimes:zip,docx,word,pdf|file|max:10000',
        ];
        $message = [
            'name.required' => 'Họ Tên không được bỏ trống ',
            'email.required' => 'Email không được bỏ trống ',
            'email.email' => 'Email sai định dạng ',
            'phone.required' => 'Số điện thoạt không được bỏ trống ',
            'file_link.required' => 'Link CV không được bỏ trống ',
            'file_link.mimes' => 'Link CV không đúng định dạng !',
            'file_link.file' => 'Link CV phải là một file  !',
            'file_link.max' => 'Link CV dung lượng quá lớn !',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) return $this->responseApi(false, $validator->errors());
        $addCandidate =   $this->MCandidate->store($request);
        if ($addCandidate) return $this->responseApi(true, 'Thành công !', ['data' => $addCandidate]);
    }
}
