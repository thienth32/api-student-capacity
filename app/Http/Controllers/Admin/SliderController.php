<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\RequestSlider;
use App\Models\Contest;
use App\Models\Major;
use App\Models\Round;
use App\Models\Slider;
use App\Services\Traits\TResponse;
use App\Services\Traits\TStatus;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use TUploadImage, TStatus, TResponse;

    private $slider;
    private $major;
    private $contest;
    private $round;
    private $modulesSlider;

    public function __construct(Slider $slider, \App\Services\Modules\MSlider\Slider  $modulesSlider, Major $major, Round $round, Contest $contest)
    {
        $this->slider = $slider;
        $this->major = $major;
        $this->round = $round;
        $this->contest = $contest;
        $this->modulesSlider = $modulesSlider;
    }

    public function index()
    {
        $round = null;
        if (request()->has('round_id')) $round = $this->round::find(request('round_id'))->load('contest');
        $sliders = $this->modulesSlider->index();
        $majors = $this->major::withCount('sliders')->get();
        $rounds = $this->round::withCount('sliders')->get();
        $contests = $this->contest::withCount('rounds')->get();

        return view('pages.slider.index', [
            'sliders' => $sliders,
            'majors' => $majors,
            'rounds' => $rounds,
            'contests' => $contests,
            'round' => $round
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/public/sliders",
     *     description="Description api slider",
     *     tags={"Slider"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Tìm kiếm ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Lọc theo chiều asc hoặc desc ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="sort_by",
     *         in="query",
     *         description="Các cột cần lọc  ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="major",
     *         in="query",
     *         description="Slider của chuyên ngành    ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="major_id",
     *         in="query",
     *         description="Slider lọc theo chuyên ngành    ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="round",
     *         in="query",
     *         description="Slider của vòng thi     ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="round_id",
     *         in="query",
     *         description="Slider lọc theo vòng thi    ",
     *         required=false,
     *     ),
     *     @OA\Parameter(
     *         name="home",
     *         in="query",
     *         description="Slider của trang chủ      ",
     *         required=false,
     *     ),
     *     @OA\Response(response="200", description="{ status: true , data : data }"),
     *     @OA\Response(response="404", description="{ status: false , message : 'Not found' }")
     * )
     */
    public function apiIndex()
    {
        try {
            $data = $this->modulesSlider->apiIndex();
            return $this->responseApi(true, $data);
        } catch (\Throwable $th) {
            return $this->responseApi(false);
        }
    }

    public function getModelDataStatus($id)
    {
        return $this->slider::find($id);
    }

    public function create()
    {
        $majors = $this->major::withCount('sliders')->get();
        $rounds = $this->round::withCount('sliders')->get();
        $contests = $this->contest::withCount('rounds')->get();
        return view('pages.slider.create', [
            'majors' => $majors,
            'rounds' => $rounds,
            'contests' => $contests
        ]);
    }

    public function store(RequestSlider $request)
    {

        try {
            if ($request->hasFile('image_url')) {
                $fileImage = $request->file('image_url');
                $filename = $this->uploadFile($fileImage);
            }
            $this->modulesSlider->store([
                'link_to' => $request->link_to,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'image_url' => $filename,
                'status' => 1,
            ], $request);
            return redirect()->route('admin.sliders.list');;
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit(Request $request, $id)
    {
        $round = null;
        if ($slider = $this->slider::find($id)->load('sliderable')) {
            if ($slider->sliderable && (get_class($slider->sliderable) == $this->round::class)) {
                $round = $this->round::find($slider->sliderable->id)->load('contest');
            }
            return view('pages.slider.edit', [
                'slider' => $slider,
                'contests' => $this->contest::all(),
                'majors' => $this->major::withCount('sliders')->get(),
                'rounds' => $this->round::withCount('sliders')->get(),
                'round' => $round
            ]);
        }
        return abort(404);
    }

    public function update(RequestSlider $request, $id)
    {
        if (!($slider = $this->slider::find($id))) return abort(404);

        try {

            $data = null;
            if (request()->has('image_url')) {
                $nameFile = $this->uploadFile(request()->image_url, $slider->image_url);
                $data = array_merge(request()->except('image_url', 'major_id', 'round_id'), [
                    'image_url' => $nameFile
                ]);
            } else {
                $data = request()->only([
                    'start_time', 'end_time', 'link_to'
                ]);
            }
            if ($request->major_id != 0) {
                $data = array_merge($data, ['sliderable_id' => $request->major_id, 'sliderable_type' => $this->major::class]);
            } elseif ($request->round_id != 0) {
                $data = array_merge($data, ['sliderable_id' => $request->round_id, 'sliderable_type' => $this->round::class]);
            } else {
                $data = array_merge($data, ['sliderable_id' => null, 'sliderable_type' => null]);
            }
            $this->modulesSlider->update($slider, $data);
            return redirect()->route('admin.sliders.list');
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function destroy($id)
    {
        // dd($slug);
        if (!($slider = $this->slider::find($id))) return abort(404);
        $slider->delete();
        return redirect()->back();
    }

    public function softDelete()
    {
        $listSliderSoft = $this->modulesSlider->getList()->paginate(request('limit') ?? 5);
        return view('pages.slider.slider-soft-delete', [
            'listSliderSoft' => $listSliderSoft
        ]);
    }

    public function backUpSlider($id)
    {
        try {
            $this->slider::withTrashed()->where('id', $id)->restore();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }


    public function deleteSlider($id)
    {
        try {
            $this->slider::withTrashed()->where('id', $id)->forceDelete();
            return redirect()->back();
        } catch (\Throwable $th) {
            return abort(404);
        }
    }
}