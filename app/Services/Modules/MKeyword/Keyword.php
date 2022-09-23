<?php

namespace App\Services\Modules\MKeyword;

use App\Models\Keyword as ModelsKeyword;


class Keyword implements MKeywordInterface
{
    public function __construct(

        private ModelsKeyword $modelKeyword,

    ) {
    }

    public function getList($request)
    {

        $query = $this->modelKeyword::query();
        $query->orderBy('updated_at', 'desc');
        $query->when($request->has('q'), function ($q) use ($request) {
            return $q->search($request->q ?? null, ['keyword', 'keyword_en'], true);
        });
        $query->when($request->has('type'), function ($q) {
            $q->where('type', request('type'));
        });
        if ($request->has('status')) $query->status($request->status);
        if ($request->has('sort')) $query->sort(($request->sort == 'asc' ? 'asc' : 'desc'), $request->sort_by ?? null, 'keywords');
        return $query;
    }
    public function list()
    {
        return $this->getList(request())->paginate(request('limit') ?? 5);
    }

    public function find($id)
    {
        return $this->modelKeyword::find($id);
    }
    public function store($request)
    {
        return $this->modelKeyword::create($request);
    }
}