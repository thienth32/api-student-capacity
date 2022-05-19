<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\Major;
use App\Models\Round;
use App\Models\Slider;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use TUploadImage;
    private $slider;
    private $major;
    private $contest;
    private $round;
    public function __construct(Slider $slider, Major $major, Round $round, Contest $contest)
    {
        $this->slider = $slider;
        $this->major = $major;
        $this->round = $round;
        $this->contest = $contest;
    }

    private function getList()
    {
        try {
            $key = null;
            $valueDate = null;
            if (request()->has('day')) {
                $valueDate = request('day');
                $key = 'day';
            }
            if (request()->has('month')) {
                $valueDate = request('month');
                $key = 'month';
            };
            if (request()->has('year')) {
                $valueDate = request('year');
                $key = 'year';
            };

            $sliders = $this->slider::when(request()->has('slider_soft_delete'), function ($q) {
                return $q->onlyTrashed();
            })->search(request('q') ?? null, ['link_to', 'image_url'])
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'sliders')
                ->when(request()->has('major'), function ($q) {
                    return $q->where('sliderable_id', request('major_id'))->where('sliderable_type', $this->major::class);
                })
                ->when(request()->has('round'), function ($q) {
                    return $q->where('sliderable_id', request('round_id'))->where('sliderable_type', $this->round::class);
                })
                ->when(request()->has('home'), function ($q) {
                    return $q->whereNull('sliderable_id')->whereNull('sliderable_type');
                })
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    $key,
                    $valueDate,
                    (request('op_time') == 'sub' ? 'sub' : 'add'),
                    'start_time'
                )
                ->with(['sliderable']);

            return $sliders;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function index()
    {
        $round = null;
        if (request()->has('round_id')) $round = $this->round::find(request('round_id'))->load('contest');
        $sliders = $this->getList()->status(request('status') ?? null)->paginate(request('limit') ?? 5);
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

    public function apiIndex()
    {
        try {
            $data = $this->getList();
            return response()->json(
                [
                    "status" => true,
                    "payload" => $data->where('status', 1)->get(),
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Serve not found",
                ]
            );
        }
    }

    public function un_status($id)
    {
        try {
            $slider = $this->slider::find($id);
            $slider->update([
                'status' => 0,
            ]);

            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
    }

    public function re_status($id)
    {
        try {
            $slider = $this->slider::find($id);
            $slider->update([
                'status' => 1,
            ]);
            return response()->json([
                'status' => true,
                'payload' => 'Success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => 'Không thể câp nhật trạng thái !',
            ]);
        }
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

    public function store(Request $request)
    {
        $request->validate(
            [
                'link_to' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'image_url' => 'image|mimes:jpeg,png,jpg|max:10000',
            ],
            [
                'link_to.required' => 'Không để trống trường này !',
                'start_time.required' => 'Không để trống trường này !',
                'end_time.required' => 'Không để trống trường này !',
                'end_time.after' => 'Trường này thời gian nhỏ hơn trường thời gian bắt đầu  !',
                'image_url.image' => 'Không để trống trường này !',
                'image_url.mimes' => 'Trường này không đúng định dạng  !',
                'image_url.max' => 'Trường này kích cỡ quá lớn  !',
            ]
        );
        // try {
        if ($request->hasFile('image_url')) {
            $fileImage = $request->file('image_url');
            $filename = $this->uploadFile($fileImage);
        }
        $dataCreate = [
            'link_to' => $request->link_to,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'image_url' => $filename,
            'status' => 1,
        ];
        if ($request->major_id != 0) {
            $major = $this->major::find($request->major_id);
            $major->sliders()->create($dataCreate);
        } elseif ($request->round_id != 0) {
            $round = $this->round::find($request->round_id);
            $round->sliders()->create($dataCreate);
        } else {
            $dataCreate = array_merge($dataCreate, ['sliderable_id' => null, 'sliderable_type' => null]);
            $this->slider::create($dataCreate);
        }
        return redirect()->route('admin.sliders.list');;
        // } catch (\Throwable $th) {
        //     return abort(404);
        // }
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

    public function update(Request $request, $id)
    {
        if (!($slider = $this->slider::find($id))) return abort(404);
        $request->validate(
            [
                'link_to' => 'required',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ],
            [
                'link_to.required' => 'Không để trống trường này !',
                'start_time.required' => 'Không để trống trường này !',
                'end_time.required' => 'Không để trống trường này !',
                'end_time.after' => 'Trường này thời gian nhỏ hơn trường thời gian bắt đầu  !',
            ]
        );
        $data = null;
        if (request()->has('image_url')) {

            $request->validate(
                [
                    'image_url' => 'image|mimes:jpeg,png,jpg|max:10000',
                ],
                [
                    'image_url.image' => 'Không để trống trường này !',
                    'image_url.mimes' => 'Trường này không đúng định dạng  !',
                    'image_url.max' => 'Trường này kích cỡ quá lớn  !',
                ]
            );
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
        $slider->update($data);
        return redirect()->route('admin.sliders.list');
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
        $listSliderSoft = $this->getList()->paginate(request('limit') ?? 5);
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
