<?php

namespace App\Services\Modules\MEnterprise;

use App\Models\Contest;
use App\Models\Donor;
use App\Models\Enterprise as ModelsEnterprise;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class Enterprise
{
    use TUploadImage;
    public function __construct(
        private Contest $contest,
        private ModelsEnterprise $enterprise,
        private Donor $donor,
    ) {
    }
    public function getList(Request $request)
    {

        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $status = $request->has('status') ? $request->status : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('enterprise_soft_delete') ? $request->enterprise_soft_delete : null;

        if ($softDelete != null) {
            $query = $this->enterprise::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query =  $this->enterprise::where('name', 'like', "%$keyword%");
        if ($status != null) {
            $query->where('status', $status);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        if ($contest != null) {
            $enterprisesId =  $this->donor::where('contest_id', $contest)->pluck('enterprise_id')->toArray();
            $query->whereIn('id', $enterprisesId);
        }
        return $query;
    }
    public function index(Request $request)
    {
        return $this->getList($request)->paginate(request('limit') ?? config('util.HOMEPAGE_ITEM_AMOUNT'));
    }
    public function find($id)
    {
        return $this->enterprise::find($id);
    }
    public function store($dataCreate, $request)
    {

        $this->enterprise::create($dataCreate);
    }
    public function update($request, $id)
    {
        $enterprise = $this->enterprise::find($id);
        $enterprise->name = $request->name;
        $enterprise->description = $request->description;
        $enterprise->link_web = $request->link_web;
        if ($request->has('logo')) {
            $fileImage =  $request->file('logo');
            $logo = $this->uploadFile($fileImage, $enterprise->logo);
            $enterprise->logo = $logo;
        }
        $enterprise->save();
    }
}
