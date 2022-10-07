<?php

namespace App\Services\Modules\MExam;

use App\Models\Exam as ModelsExam;
use App\Models\ResultCapacity;

class Exam implements MExamInterface
{

    public function __construct(
        private ModelsExam $model,
        private ResultCapacity $resultCapacity
    ) {
    }

    public function findById($id, $with = [], $select = [], $countWith = true)
    {
        if (count($select) > 0) {
            if ($countWith === true) {
                $data = $this->model::select($select)->whereId($id)->with($with)->withCount($with)->first();
            } else {
                $data = $this->model::select($select)->whereId($id)->withCount($with)->first();
            }
        } else {
            if ($countWith === true) {
                $data = $this->model::whereId($id)->with($with)->withCount($with)->first();
            } else {
                $data = $this->model::whereId($id)->withCount($with)->first();
            }
        }

        return $data;
    }

    public function find($id)
    {
        return $this->model::find($id);
    }

    public function whereGet($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with)->get();
    }

    public function where($param = [])
    {
        return $this->model::hasRequest($param);
    }

    public function getResult($id)
    {
        return $this->resultCapacity::where('exam_id', $id)
            ->with(['user'])
            ->get();
    }

    public function getExamCapacityPlay($params = [], $with = [])
    {
        return $this->model::whereNull('round_id')
            ->where(function ($q) {
                return $q->search(request()->q ?? null, ['name', 'room_code', 'description']);
            })
            ->with($with)
            ->orderBy('status', 'asc')
            ->paginate(request('limit') ?? 5);
    }

    public function storeCapacityPlay($data)
    {
        $exam = $this->model::create(
            [
                "name" => $data->name,
                "description" => $data->description,
                "max_ponit" => $data->max_ponit,
                "type" => $data->type,
                "ponit" => $data->max_ponit,
                "external_url" => "null",
                "room_code" => MD5(uniqid() . time()),
            ]
        );
        $exam->questions()->attach($data->questions ?? []);
        return $exam;
    }

    public function updateCapacityPlay($id, $data)
    {
        $model = $this->model::whereId($id)->withCount(['questions'])->first();
        $model->update($data);
        return $model;
    }

    public function getExamBtyTokenRoom($code, $with = [], $withCount = [])
    {
        return $this->model::where('room_code', $code)
            ->with($with)
            ->withCount($withCount)
            ->first();
    }

    public function attachQuestion($id, $questionsId)
    {
        return $this->model::find($id)->questions()->attach([$questionsId]);
    }

    public function getCapacityPlayGameOnline()
    {
        return $this->model::where('status', 1)
            ->whereNull('round_id')
            ->whereNull('room_token')
            ->get();
    }
}