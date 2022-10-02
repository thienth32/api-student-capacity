<?php

namespace App\Services\Builder;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder extends  EloquentBuilder
{

    public function missingDate($column = null, $miss_date = null, $time = null)
    {
        if ($miss_date == null) return $this;
        return $this->where($column, "<", $time);
        // return $this->whereDate($column, "<", $time);
    }

    public function passDate($column = null, $pass_date = null, $time = null)
    {
        if ($pass_date == null) return $this;
        return $this->whereDate($column, ">", $time);
    }

    public function registration_date($column = null, $registration_date = null, $time = null)
    {
        if ($registration_date == null) return $this;
        return $this->whereDate($column, ">", $time)->whereDate('start_register_time', "<", $time);
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
        if (is_array($column) && $start_time && $end_time) {
            $this->where(function ($q) use ($column, $start_time, $end_time) {
                foreach ($column as $key => $col) {
                    if ($key == 0) {
                        $q->whereBetween($col, [$start_time, $end_time]);
                        continue;
                    } else {
                        $q->orWhereBetween($col, [$start_time, $end_time]);
                    }
                }
            });
            return $this;
        }
        if ($column && $start_time && $end_time) return $this->whereBetween($column, [$start_time, $end_time]);
        return $this;
    }

    /**
     *  Has sub time
     */
    public function hasSubTime($key = null, $data = null, $op_time = null, $column)
    {

        if (!$key) return $this;
        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $nowSub = Carbon::now('Asia/Ho_Chi_Minh');


        if ($op_time == 'sub') {
            switch ($key) {
                case 'day':

                    return $this->whereBetween($column, [$nowSub->subDays($data)->toDateTimeString(), $now->toDateTimeString()]);
                    break;
                case 'month':
                    return $this->whereBetween($column, [$nowSub->subMonths($data)->toDateTimeString(), $now->toDateTimeString()]);
                    break;
                case 'year':
                    return $this->whereBetween($column, [$nowSub->subYears($data)->toDateTimeString(), $now->toDateTimeString()]);
                    break;
                default:
                    return $this;
                    break;
            }
        } else {

            switch ($key) {
                case 'day':
                    return $this->whereBetween($column, [$now->toDateTimeString(), $nowSub->addDays($data)->toDateTimeString()]);
                    break;
                case 'month':
                    return $this->whereBetween($column, [$now->toDateTimeString(), $nowSub->addMonths($data)->toDateTimeString()]);
                    break;
                case 'year':
                    return $this->whereBetween($column, [$now->toDateTimeString(), $nowSub->addYears($data)->toDateTimeString()]);
                    break;
                default:
                    return $this;
                    break;
            }
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
    public function search($search = null, $search_by = null, $Flagtype = false)
    {
        if ($search == null)

            return $this;
        // if (!(\Str::contains($search, '@'))) $search = \Str::slug($search, " ");

        // if ($Flagtype) $this->where('type', request('type') ?? 0);
        $this->where($search_by[0], 'LIKE', "%" . $search . "%");
        foreach ($search_by as $key => $item) {
            if ($key !== 0) $this->orWhere($item, 'LIKE', "%" . $search . "%");
        }
        return $this;
    }

    /**
     * Has request url
     */
    public function hasRequest($data = [])
    {
        if (count($data) == 0) return $this;
        $q = $this;
        foreach ($data as $key => $v) {
            if ($v) $q = $q->where($key, $v);
        }
        return $q;
    }

    public function hasRequestNotNull($data = [])
    {
        if (count($data) == 0) return $this;
        $q = $this;
        foreach ($data as $key => $v) {
            if ($v) $q = $q->whereNotNull($key);
        }
        return $q;
    }

    public function hasRequestNull($data = [])
    {
        if (count($data) == 0) return $this;
        $q = $this;
        foreach ($data as $key => $v) {
            if ($v) $q = $q->whereNotNull($key);
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
    public function whenWhereHasRelationship($value = null, $relation = null, $tableColumn = null, $flagDosenHave = false)
    {
        if ($value == null) return $this;
        if ($relation == null) return $this;
        if ($tableColumn == null) return $this;
        if ($flagDosenHave) return $this->doesntHave($relation);
        return $this->whereHas($relation, function ($query) use ($value,  $tableColumn) {
            $query->where($tableColumn, $value);
        });
    }



    /**
     * Search keyword
     */
    public function searchKeyword($request = null, $column = null)
    {
        if ($request == null)
            return $this;
        $requestArr = explode(" ", $request);
        $this->where($column[0], 'LIKE', "%" . $requestArr[0] . "%");
        foreach ($column as $keyColumn => $item) {
            foreach ($requestArr as $keyRequest => $value) {
                if ($keyColumn !== 0 &&  $keyRequest !== 0) $this->orWhere($item, 'LIKE', "%" .  $value . "%");
            }
        }
        return $this;
    }
}