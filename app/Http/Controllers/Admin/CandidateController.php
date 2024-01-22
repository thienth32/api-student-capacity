<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailUploadCV;
use App\Jobs\SendMailNoteCV;
use App\Jobs\SendMailWhenCandidateIsNotSupport;
use App\Jobs\SendMailWhenSendCvToEnterprise;
use App\Mail\MailUploadCV;
use App\Models\Candidate;
use App\Models\CandidateNote;
use App\Models\Major;
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
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    use TUploadImage;
    use TResponse, TStatus;

    public function __construct(
        private Candidate           $candidate,
        private Post                $post,
        private MCandidateCandidate $MCandidate,
        private DB                  $db,
        private Storage             $storage,
        private Major               $major,
    )
    {
    }

    public function index(Request $request)
    {

        $posts = $this->post::where('postable_type', Recruitment::class)->with(['enterprise'])->get();
        $candidates = $this->MCandidate->index($request);
        $count = $this->MCandidate->getList($request)->count();
        $majors = $this->major::select(['id', 'name'])->where('for_recruitment', 1)->get();

        return view('pages.candidate.index', [
            'candidates' => $candidates,
            'posts' => $posts,
            'majors' => $majors,
            'count' => $count,
        ]);
    }

    public function createNote(Request $request, $candidateId)
    {
        if (!$candidateId) {
            return abort(404);
        }

        $model = CandidateNote::create([
            'content' => $request->content,
            'candidate_id' => $candidateId,
            'user_id' => Auth::user()->id,
            'status' => 1, // TODO, 0: email not sent, 1: email sent
        ]);

        $candidate = $this->candidate::find($candidateId);
        $post = $candidate->post;

        $email = new SendMailNoteCV($candidate, $post, $model->content);
        dispatch($email);

        return redirect()->back();
    }

    public function detail(Request $request, $id)
    {
        if (!$id) return abort(404);
        $data = $this->candidate::find($id);
        if (!$data) return abort(404);

        $candidates = $this->MCandidate
            ->getList($request)
            ->with(['post:id,slug,code_recruitment,position', 'candidateNotes' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->where('email', $data->email)
            ->get();

        return view('pages.candidate.detail', compact('data', 'candidates'));
    }

    public function showCv($id)
    {
        if (!$id) return abort(404);
        $data = $this->candidate::find($id);

        if ($data->has_checked == 0) {
            $data->has_checked = 1;
            $data->save();
        }

        return view('pages.candidate.show-cv', compact('data'));
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

    public function changeStatus(Request $request)
    {
        [$status, $id] = explode("|", $request->status);

        if (!$candidate = $this->candidate::find($id)) return response()->json([
            'status' => false,
            'payload' => 'Không tìm thấy thông tin ứng viên tuyển dụng  !',
        ]);

        if ($status == config('util.CANDIDATE_OPTIONS.STATUS_KEYS.SEND_TO_ENTERPRISE')) {
            $email = new SendMailWhenSendCvToEnterprise($candidate);
            dispatch($email);
        }

        if ($status == config('util.CANDIDATE_OPTIONS.STATUS_KEYS.NOT_SUPPORT')) {
            $email = new SendMailWhenCandidateIsNotSupport($candidate);
            dispatch($email);
        }

        $candidate->update([
            'status' => $status
        ]);


        return response()->json([
            'status' => true,
            'payload' => 'Cập nhật thành công!',
        ]);
    }

    public function changeResult(Request $request)
    {
        [$result, $id] = explode("|", $request->result);

        if (!$candidate = $this->candidate::find($id)) return response()->json([
            'status' => false,
            'payload' => 'Không tìm thấy thông tin ứng viên tuyển dụng!',
        ]);

        $candidate->update([
            'result' => $result
        ]);

        return response()->json([
            'status' => true,
            'payload' => 'Cập nhật thành công  !',
        ]);
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
            'student_code' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'major_id' => 'required',
            'file_link' => 'required|mimes:pdf|file|max:10000',
            'student_status' => 'required',
        ];
        $message = [
            'post_id.required' => 'Mã tuyển dụng không được bỏ trống ',
            'name.required' => 'Họ Tên không được bỏ trống ',
            'student_code.required' => 'Mã sinh viên không được bỏ trống ',
            'email.required' => 'Email không được bỏ trống ',
            'email.email' => 'Email sai định dạng ',
            'phone.required' => 'Số điện thoại không được bỏ trống ',
            'major_id.required' => 'Chuyên ngành không được bỏ trống ',
            'file_link.required' => 'Link CV không được bỏ trống ',
            'file_link.mimes' => 'Link CV không đúng định dạng. Yêu cầu file pdf, tối đa dung lượng file 10MB  !',
            'file_link.file' => 'Link CV phải là một file. Yêu cầu file pdf, tối đa dung lượng file 10MB  !',
            'file_link.max' => 'Link CV dung lượng quá lớn. Tối đa 10MB !',
            'student_status.required' => 'Trạng thái sinh viên không được bỏ trống ',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        $addCandidate = $this->MCandidate->updateOrCreate($request);
        if (!$addCandidate) {
            return $this->responseApi(false, ' Lỗi upload CV !');
        }

        $sizeFile = Storage::disk('s3')->size($addCandidate->file_link);
        $sizeFileFormat = number_format($sizeFile / 1048576, 2);
        $addCandidate['file_link'] = Storage::disk('s3')->temporaryUrl($addCandidate->file_link, now()->addMinutes(5));
        $addCandidate['sizeFile'] = $sizeFileFormat;

        $email = new SendMailUploadCV($addCandidate);
        dispatch($email);

        return $this->responseApi(true, 'Upload CV thành công !', ['data' => $addCandidate]);
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
