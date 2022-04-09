<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $slider;
    public function __construct($slider)
    {
        $this->slider = $slider;
    }

    private function getList()
    {
        try {
            $sliders = $this->slider::search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'rounds')
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    ((request('day') ? 'day' : '') ??
                        (request('month') ? 'month' : '') ??
                        (request('year') ? 'year' : '')) ?? null,
                    (request('day') ??
                        request('month') ??
                        request('year')) ?? null,
                    'start_time'
                )
                ->with([
                    'contest',
                    'type_exam',
                ]);
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function index()
    {
        return view('pages.slider.index');
    }
}