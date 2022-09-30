<?php

namespace App\Services\Modules\MSkill;

use App\Models\Major;
use App\Models\MajorSkill;
use App\Models\Skill as ModelsSkill;
use App\Services\Traits\TUploadImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Skill implements MSkillInterface
{
    use TUploadImage;
    public function __construct(
        private Major $major,
        private ModelsSkill $skill,
        private MajorSkill $majorSkill,
        private Carbon $carbon
    ) {
    }
    public function getList(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->keyword : "";
        $major = $request->has('major_id') ? $request->major_id : null;
        $orderBy = $request->has('orderBy') ? $request->orderBy : 'id';
        $timeDay = $request->has('day') ? $request->day : Null;
        $sortBy = $request->has('sortBy') ? $request->sortBy : "desc";
        $softDelete = $request->has('skill_soft_delete') ? $request->skill_soft_delete : null;

        if ($softDelete != null) {
            $query = $this->skill::onlyTrashed()->where('name', 'like', "%$keyword%")->orderByDesc('deleted_at');
            return $query;
        }
        $query = $this->skill::where('name', 'like', "%$keyword%");
        if ($major != null) {
            $query = $this->major::find($major);
        }
        if ($timeDay != null) {
            $current = $this->carbon::now();
            $query->where('created_at', '>=', $current->subDays($timeDay));
        }
        if ($sortBy == "desc") {
            $query->orderByDesc($orderBy);
        } else {
            $query->orderBy($orderBy);
        }
        // dd($query->get());
        return $query;
    }
    public function index(Request $request)
    {

        if ($request->major_id) {
            return $this->getList($request)->Skill()->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
        }
        return $this->getList($request)->paginate(config('util.HOMEPAGE_ITEM_AMOUNT'));
    }
    public function find($id)
    {

        return $this->skill::find($id);
    }
    public function store($request)
    {
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'short_name' => $request->short_name
        ];

        if ($request->has('image_url')) {
            $fileImage =  $request->file('image_url');
            $logo = $this->uploadFile($fileImage);
            $data['image_url'] = $logo;
        }

        $newSkill = $this->skill::create($data);

        if ($newSkill) {

            if ($request->major_id != null) {

                foreach ($request->major_id as $item) {

                    $this->majorSkill::create([
                        'major_id' => $item,
                        'skill_id' => $newSkill->id,
                    ]);
                }
            }
        }
    }
    public function update($request, $id)
    {
        $skill = $this->skill::find($id);

        if (!$skill) {
            return redirect('error');
        }
        $skill->name = $request->name;
        $skill->short_name = $request->short_name;
        $skill->description = $request->description;
        if ($request->has('image_url')) {
            $fileImage =  $request->file('image_url', $skill->image_url);
            $logo = $this->uploadFile($fileImage);
            $skill->image_url = $logo;
        }
        $skill->save();
        if ($request->major_id != null) {

            $dataMajorSkill = $this->majorSkill::where('skill_id', $id)->pluck('major_id')->toArray();

            $result = array_diff($request->major_id, $dataMajorSkill);
            $dropResult = array_diff($dataMajorSkill, $request->major_id);
            if ($dropResult != null) {
                $skill->majorSkill()->detach($dropResult);
            }
            if ($result != null) {
                $skill->majorSkill()->syncWithoutDetaching($result);
            }
        } else {
            $this->majorSkill::where('skill_id', $id)->delete();
        }
    }

    public function getAll($selects = [])
    {
        if (count($selects) > 0) {
            return $this->skill::select($selects ?? [])->get();
        } else {
            return $this->skill::all();
        }


        // return $this->skill::searchKeyword(request('q') ?? null, ['name', 'short_name', 'description'])->get();
    }
}