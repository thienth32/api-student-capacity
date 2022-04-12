<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use App\Models\Slider;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use TUploadImage;
    private $slider;
    private $major;
    public function __construct(Slider $slider, Major $major)
    {
        $this->slider = $slider;
        $this->major = $major;
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
                ->status(request('status') ?? null)
                ->hasReuqest([
                    'major_id' => request('major_id') ?? null,
                ])
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    $key,
                    $valueDate,
                    (request('op_time') == 'sub' ? 'sub' : 'add'),
                    'start_time'
                )
                ->with([
                    'major',
                ]);

            return $sliders;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function index()
    {
        $sliders =  $this->getList()->paginate(request('limit') ?? 5);
        $majors = $this->major::all();
        return view('pages.slider.index', [
            'sliders' => $sliders,
            'majors' => $majors
        ]);
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
        $majors = $this->major::all();
        return view('pages.slider.create', ['majors' => $majors]);
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
        try {
            if ($request->hasFile('image_url')) {
                $fileImage = $request->file('image_url');
                $filename = $this->uploadFile($fileImage);
            }
            $this->slider::create([
                'link_to' => $request->link_to,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'major_id' => $request->major_id,
                'image_url' => $filename,
                'status' => 1,
            ]);
            return redirect()->route('admin.sliders.list');;
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function edit(Request $request, $id)
    {
        if ($slider = $this->slider::find($id)->load("major")) {
            return view('pages.slider.edit', ['slider' => $slider, 'majors' => $this->major::all()]);
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
            $data = array_merge(request()->except('image_url'), [
                'image_url' => $nameFile
            ]);
        } else {
            $data = request()->only([
                'major_id', 'start_time', 'end_time', 'link_to'
            ]);
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