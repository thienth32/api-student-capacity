<?php

namespace App\Services\Modules\MTakeExam;

use App\Models\TakeExam as ModelsTakeExam;
use App\Services\Traits\TResponse;
use Illuminate\Support\Facades\DB;

class TakeExam
{
    use TResponse;
    public function __construct(
        private ModelsTakeExam $model
    ) {
    }

    public function findBy($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with)->first();
    }
    public function find($id, $with = [])
    {
        return $this->model::with($with)->find($id);
    }
    public function whereGet($param = [], $with = [])
    {
        return $this->model::hasRequest($param)->with($with)->get();
    }
    public function where($param = [])
    {
        return $this->model::hasRequest($param);
    }

    public function create($data = [])
    {
        return $this->model::create($data);
    }
}