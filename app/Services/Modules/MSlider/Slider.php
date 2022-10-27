<?php

namespace App\Services\Modules\MSlider;

use App\Models\Contest;
use App\Models\Major;
use App\Models\Round;
use App\Services\Traits\TUploadImage;

class Slider
{
    use TUploadImage;
    private $slider;
    private $major;
    private $contest;
    private $round;
    public function __construct(\App\Models\Slider $slider, Major $major, Round $round, Contest $contest)
    {
        $this->slider = $slider;
        $this->major = $major;
        $this->round = $round;
        $this->contest = $contest;
    }

    public function getList()
    {
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

        return $this->slider::when(request()
            ->has('slider_soft_delete'), function ($q) {
            return $q->onlyTrashed();
        })
            ->search(request('q') ?? null, ['link_to', 'image_url'])
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
    }

    public function index()
    {
        try {
            return $this->getList()->status(request('status') ?? null)->paginate(request('limit') ?? 5);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function apiIndex()
    {
        try {
            return $this->getList()
                ->where('status', 1)
                ->where('end_time', ">", date("Y-m-d H:i:s"))
                ->get();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function store($dataCreate, $request)
    {
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
    }

    public function update($slider, $data)
    {
        $slider->update($data);
    }
}