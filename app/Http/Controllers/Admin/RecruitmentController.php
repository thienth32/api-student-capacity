<?php

namespace App\Http\Controllers\Admin;

use App\Services\Traits\TUploadImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Recruitment\RequestsRecruitment;
use App\Models\Contest;
use App\Models\Enterprise;
use App\Models\Recruitment;
use App\Services\Modules\MRecruitment\Recruitment as MRecruitmentRecruitment;
use Carbon\Carbon;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Sheet;

class RecruitmentController extends Controller
{
    use TUploadImage;
    use TResponse, TStatus;

    public function __construct(

        private Contest $contest,
        private MRecruitmentRecruitment $modulesRecruitment,
        private Enterprise $enterprise,
        private Recruitment $recruitment,
        private DB $db,
        private Storage $storage
    ) {
    }

    public function index(Request $request)
    {
        try {
            $enterprises = $this->enterprise::all();
            $contests = $this->contest::where('type', 1)->get();
            $recruitments = $this->modulesRecruitment->index($request);
            return view('pages.recruitment.index', [
                'recruitments' => $recruitments,
                'enterprises' => $enterprises,
                'contests' => $contests
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('error');
        };
    }

    public function create(Request $request)
    {

        DB::beginTransaction();
        try {
            $enterprise = $this->enterprise::all();
            $contest = $this->contest::where('type', 1)->get();
            DB::commit();
            return view('pages.recruitment.form-add', ['enterprise' => $enterprise, 'contest' => $contest]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => '404 not found'
            ]);
        };
    }

    public function store(RequestsRecruitment $request)
    {

        DB::beginTransaction();
        try {
            $this->modulesRecruitment->store($request);
            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }

    public function destroy($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) abort(404);
            DB::transaction(function () use ($id) {
                if (!($data = $this->recruitment::find($id))) abort(404);
                $data->delete();
            });
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit(Request $request, $id)
    {

        $data =  $this->modulesRecruitment->find($id);
        $enterprises = $this->enterprise::all();
        $contests = $this->contest::where('type', 1)->get();

        return view('pages.recruitment.form-edit', compact('data', 'enterprises', 'contests'));
    }
    public function update(RequestsRecruitment $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->modulesRecruitment->update($request, $id);

            Db::commit();

            return Redirect::route('admin.recruitment.list');
        } catch (\Throwable $th) {
            Db::rollBack();
            return redirect('error');
        }
    }

    public function listRecordSoftDeletes(Request $request)
    {
        $listSofts = $this->modulesRecruitment->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        return view('pages.recruitment.soft-delete', compact('listSofts'));
    }

    public function backUpRecruitment($id)
    {
        try {
            $this->recruitment::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    //xóa vĩnh viễn
    public function delete($id)
    {
        try {
            if (!(auth()->user()->hasRole('super admin'))) abort(404);
            $this->recruitment::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function getModelDataHot($id)
    {
        return $this->modulesRecruitment->find($id);
    }

    public function detail($id)
    {
        $data = $this->modulesRecruitment->find($id);
        return view('pages.recruitment.detailRecruitment', compact('data'));
    }

    /**
     * @OA\Get(
     *     path="/api/public/recruitments",
     *     description="Description api recruitments",
     *     tags={"Recruitment"},
     *     @OA\Parameter(
     *         name="keyword",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *       @OA\Parameter(
     *         name="qq",
     *         in="query",
     *         description="Tìm kiếm tách chuỗi ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sortBy",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="orderBy",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="contest_id",
     *         in="query",
     *         description="Tuyển dụng thuộc bài test",
     *         required=false,
     *     ),
     *  @OA\Parameter(
     *         name="major_id",
     *         in="query",
     *         description="Tuyển dụng thuộc chuyên ngành",
     *         required=false,
     *     ),
     * *  @OA\Parameter(
     *         name="skill_id",
     *         in="query",
     *         description="Tuyển dụng thuộc kỹ năng",
     *         required=false,
     *     ),
     *    *     @OA\Parameter(
     *         name="recruitmentHot",
     *         in="query",
     *         description="Bài tuyển dụng Hot (recruitmentHot='hot' list tuyển dụng hot ,
     * recruitmentHot='normal' list tuyển dụng bthuong
     * )",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="enterprise_id",
     *         in="query",
     *         description="Tuyển dụng cho các doanh nghiệp  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="progress",
     *         in="query",
     *         description="Trạng thái của bài đăng
     * 'pass_date'= sắp diễn ra,
     * 'registration_date'= đang diễn ra
     * 'miss_date'= đã diễn ra ",
     *         required=false,
     *     ),
     *
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiShow(Request $request)
    {
        $data = $this->modulesRecruitment->getList($request)->withCount('contest')->paginate(request('limit') ?? 6);
        if (!$data) abort(404);
        $data->load([
            'contest:id',
            'contest.resultCapacity:result_capacity.id,result_capacity.user_id',
            'contest.resultCapacity.user:id', 'enterprise:id,name,logo',
            'skill' => function ($q) {
                $q->select(['skills.id', 'skills.short_name', 'skills.name'])->distinct();
            }
        ])->makeHidden([
            'contest', 'resultCapacity',
        ]);
        $this->modulesRecruitment->LoadSkillAndUserApiShow($data);
        return $this->responseApi(
            true,
            $data,
        );
    }

    /**
     * @OA\Get(
     *     path="/api/public/recruitments/{id}",
     *     description="Description api recruitment",
     *     tags={"Recruitment"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id Tuyển dụng  ",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiDetail($id)
    {
        $data = $this->modulesRecruitment->find($id);
        if (!$data) abort(404);
        // $data->load([
        //     'contest',
        //     'contest.resultCapacity:result_capacity.id,result_capacity.user_id',
        //     'contest.resultCapacity.user:id', 'enterprise:id,name,logo',
        //     'enterprise:id,name,logo', 'skill' => function ($q) {
        //         $q->select(['skills.id', 'skills.short_name', 'skills.name'])->distinct();
        //     }
        // ])->loadCount('rounds');

        $data->load(['skill', 'contest' => function ($q) {
            return $q->with(['skills:id,short_name,name'])->withCount(['userCapacityDone', 'rounds']);
        }, 'enterprise']);
        $this->modulesRecruitment->loadSkillAndUserApiDetail($data);
        return $this->responseApi(
            true,
            $data
        );
    }
}