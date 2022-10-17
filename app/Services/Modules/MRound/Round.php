<?php

namespace App\Services\Modules\MRound;

use App\Models\Result;
use App\Services\Traits\TUploadImage;

class Round implements MRoundInterface
{
    use TUploadImage;
    public $round;
    public function __construct(
        \App\Models\Round $round,
        private Result $result
    ) {
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
        } catch (\Exception $e) {
            return false;
        }
    }

    public function index()
    {
        try {
            return $this->getList()->withCount(['results', 'exams', 'posts', 'sliders'])->paginate(request('limit') ?? 5);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function apiIndex()
    {
        try {
            return $this->getList()->get();
        } catch (\Exception $e) {
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

    public function find($id, $with = [])
    {
        return $this->round::whereId($id)->with($with)->first();
    }

    public function getTeamByRoundId($id, $flagGetAll = false)
    {
        $teams = $this->round::find($id)
            ->teams()
            ->with([
                'members:name,email,avatar',
                'result' => function ($q) use ($id) {
                    return $q->where('round_id', $id)
                        ->orderBy('point', 'desc')
                        ->orderBy('created_at', 'asc');
                }
            ])
            ->sort((request('sort') == 'desc' ? 'asc' : 'desc'), request('sort_by') ?? null, 'results')
            ->search(request('q') ?? null, ['name']);
        if ($flagGetAll) return $teams->get();
        return $teams->paginate(request('limit') ?? 10);
    }

    public function where($param = [])
    {
        return $this->round::hasRequest($param);
    }

    public function whereIn($key, $val = [])
    {
        return $this->round::whereIn($key, $val);
    }


    public function results($id)
    {
        if (request()->has('q')) {
            $resultIds = $this->round::find($id)
                ->teams()
                ->search(request('q') ?? null, ['name'])
                ->with([
                    'result' => function ($q) use ($id) {
                        return $q->where('round_id', $id);
                    }
                ])->get()->map(function ($q) {
                    return $q->result->id;
                })->toArray();
        }
        $result = $this->result::query();
        $result->where('round_id', $id);
        if (request()->has('q')) {
            $result->whereIn('id', $resultIds);
        }
        $result->orderBy('point', (request('sort') == 'asc' ? 'asc' : 'desc'))
            ->orderBy('updated_at', (request('sort') == 'asc' ? 'asc' : 'desc'))
            ->with(['team' => function ($q) {
                $q->with('users:name,email,avatar');
                return $q;
            }]);
        return $result->paginate(request('limit') ?? 6);
    }
}