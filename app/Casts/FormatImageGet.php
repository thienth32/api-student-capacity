<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class FormatImageGet implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if (request()->route()) if (((request()->route()->getName() ?? "ABS") == "admin.round.detail.team.make.exam")) return $value;
        if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addDays(7));
        // if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addMinutes(60));
        return ($model->getTable() == 'users') ? $value : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}