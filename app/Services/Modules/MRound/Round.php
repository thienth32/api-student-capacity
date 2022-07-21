<?php

namespace App\Services\Modules\MRound;

use App\Services\Traits\TUploadImage;

class Round
{
    use TUploadImage;
    public $round;
    public function __construct(\App\Models\Round $round)
    {
        $this->round = $round;
    }

    public function getList()
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

            return $this->round::when(request()
                ->has('round_soft_delete'), function ($q) {
                return $q->onlyTrashed();
            })
                ->search(request('q') ?? null, ['name', 'description'])
                ->sort((request('sort') == 'asc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'rounds')
                ->hasDateTimeBetween('start_time', request('start_time') ?? null, request('end_time') ?? null)
                ->hasSubTime(
                    $key,
                    $valueDate,
                    (request('op_time') == 'sub' ? 'sub' : 'add'),
                    'start_time'
                )
                ->hasRequest([
                    'contest_id' => request('contest_id') ?? null,
                    'type_exam_id' => request('type_exam_id') ?? null,
                ])
                ->with([
                    'contest',
                    'type_exam',
                ]);
        }catch (\Exception $e) {
            return false;
        }
    }

    public function index()
    {
        try {
            return $this->getList() ->withCount(['results','exams','posts','sliders'])->paginate(request('limit') ?? 5);
        }catch (\Exception $e) {
            return false;
        }
    }

    public function apiIndex()
    {
        try {
            return $this->getList()->get();
        }catch (\Exception $e) {
            return false;
        }
    }

    public function store($request)
    {

        if ($request->hasFile('image')) {
            $fileImage = $request->file('image');
            $filename = $this->uploadFile($fileImage);
        }
        $round = new $this->round();
        $round->name = $request->name;
        $round->image = $filename;
        $round->start_time = $request->start_time;
        $round->end_time = $request->end_time;
        $round->description = $request->description;
        $round->contest_id = $request->contest_id;
        $round->type_exam_id = $request->type_exam_id;
        $round->save();

    }

}
