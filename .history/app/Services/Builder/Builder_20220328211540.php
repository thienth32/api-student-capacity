<?php

namespace App\Services\Builder;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder extends  EloquentBuilder
{

    // Sort
    public function sort($sort = null, $sort_by = null, $table = null)
    {
        if ($table !== null) $sort_by = collect(\Arr::listColumnOfTable($table))->contains($sort_by) ? $sort_by : 'id';
        return $this->orderBy($sort_by ?? 'id', $sort);
    }


    // Status
    public function status($status = null)
    {
        if ($status == null) return $this;
        return $this->where('status', $status);
    }

    // Search
    public function search($search = null, $search_by = null)
    {
        if ($search == null) return $this;
        if (!(\Str::contains($search, '@'))) $search = \Str::slug($search, " ");

        $this->where($search_by[0], 'like', "%$search%");
        foreach ($search_by as $key => $item) {
            if ($key !== 0) $this->orWhere($item, 'like', "%$search%");
        }
        return $this;
    }

    //  Has Major
    public function hasMajor($majorId = null)
    {
        if ($majorId) return $this->where('major_id', $majorId);
        return $this;
    }

    //  Has Contest
    public function hasContest($contestId = null)
    {
        if ($contestId) return $this->where('contest_id', $contestId);
        return $this;
    }

    //  Has Type Exam
    public function hasTypeExam($typeExamId = null)
    {
        if ($typeExamId) return $this->where('type_exam_id', $typeExamId);
        return $this;
    }


    public function has_role($role = null)
    {
        $this->with('roles');
        if ($role == null) return $this;
        $role = \Str::slug($role, " ");
        if (!(\Spatie\Permission\Models\Role::where('name', $role)->exists())) $role = \Spatie\Permission\Models\Role::first()->name;
        return $this->role($role);
    }
}