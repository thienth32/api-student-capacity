<?php

namespace App\Services\Modules\MEnterprise;

use App\Models\Contest;
use App\Models\Enterprise as ModelsEnterprise;
use App\Services\Traits\TUploadImage;
use Illuminate\Http\Request;

class Enterprise
{
    use TUploadImage;
    public function __construct(
        private Contest $contest,
        private ModelsEnterprise $enterprise,
        // private DB $db,
        // private Storage $storage
    ) {
    }
    public function getList(Request $request)
    {

        $keyword = $request->has('keyword') ? $request->keyword : "";
        $contest = $request->has('contest') ? $request->contest : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';

        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('enterprise_soft_delete') ? $request->enterprise_soft_delete : null;

        if ($softDelete != null) {
            $query = $this->enterprise::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query =  $this->enterprise::where('name', 'like', "%$keyword%");
        if ($contest != null) {
            $query = Contest::find($contest);
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        return $query;
    }
    public function index(Request $request)
    {
        if ($request->contest) {
            return $this->getList($request)->enterprise()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        }
        return $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
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
            $logo = $this->uploadFile($fileImage);
            $enterprise->logo = $logo;
        }
        $enterprise->save();
    }
}
