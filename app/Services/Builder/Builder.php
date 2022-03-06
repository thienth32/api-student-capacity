<?php

namespace App\Services\Builder;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder extends  EloquentBuilder
{

    public function sort($sort = null, $sort_by = null, $table = null)
    {
        if ($table !== null) $sort_by = collect(\Arr::listColumnOfTable($table))->contains($sort_by) ? $sort_by : 'id';
        return $this->orderBy($sort_by ?? 'id', $sort);
    }

    public function status($status = null)
    {
        if ($status == null) return $this;
        return $this->where('status', $status);
    }

    public function search($search = null)
    {
        if ($search == null) return $this;
        if (!(\Str::contains($search, '@'))) $search = \Str::slug($search, " ");
        return $this->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
    }

    public function has_role($role = null)
    {
        if ($role == null) return $this;
        $role = \Str::slug($role, " ");
        if (!(\Spatie\Permission\Models\Role::where('name', $role)->exists())) $role = \Spatie\Permission\Models\Role::first()->name;
        return $this->role($role);
    }
}