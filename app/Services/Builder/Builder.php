<?php

namespace App\Services\Builder;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Builder extends  EloquentBuilder
{
    public function missingDate($column = null, $miss_date = null, $time = null)
    {
        if ($miss_date == null) return $this;
        return $this->whereDate($column, "<", $time);
    }

    public function passDate($column = null, $pass_date = null, $time = null)
    {
        if ($pass_date == null) return $this;
        return $this->whereDate($column, ">", $time);
    }

    // public function upComingDate($column = null, $pass_date = null, $time = null)
    // {
    //     if ($pass_date == null) return $this;
    //     return $this->whereDate($column, ">=", $time);
    // }

    /**
     *  Has date time between
     */
    public function hasDateTimeBetween($column = null, $start_time = null, $end_time = null)
    {
        if ($column && $start_time && $end_time) return $this->whereBetween($column, [$start_time, $end_time]);
        return $this;
    }

    /**
     *  Has sub time
     */
    public function hasSubTime($key = null, $data = null, $column)
    {
        if (!$key) return $this;
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        switch ($key) {
            case 'day':
                return $this->whereDate($column, '>', $now->subDays($data));
                break;
            case 'month':
                return $this->whereDate($column, '>', $now->subMonths($data));
                break;
            case 'year':
                return $this->whereDate($column, '>', $now->subYears($data));
                break;
            default:
                return $this;
                break;
        }
    }

    /**
     * Sort
     */
    public function sort($sort = null, $sort_by = null, $table = null)
    {
        if ($table !== null) $sort_by = collect(\Arr::listColumnOfTable($table))->contains($sort_by) ? $sort_by : 'id';
        return $this->orderBy($sort_by ?? 'id', $sort);
    }

    /**
     * Status
     */
    public function status($status = null)
    {
        if ($status == null) return $this;
        return $this->where('status', $status);
    }

    /**
     * Search
     */
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

    /**
     * Has request url
     */
    public function hasReuqest($data = [])
    {
        if (count($data) == 0) return $this;
        $q = $this;
        foreach ($data as $key => $v) {
            if ($v) $q = $q->where($key, $v);
        }
        return $q;
    }

    /**
     *  Has role
     */
    public function has_role($role = null)
    {
        $this->with('roles');
        if ($role == null) return $this;
        $role = \Str::slug($role, " ");
        if (!(\Spatie\Permission\Models\Role::where('name', $role)->exists())) $role = \Spatie\Permission\Models\Role::first()->name;
        return $this->role($role);
    }
}