<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class FormatImageGet implements CastsAttributes
{

    public function get($model, string $key, $value, array $attributes)
    {
        if (request()->route()) {
            $routeName = (request()->route()->getName() ?? "ABS");
            $arrayCheckNameRoute = [
                "admin.round.detail.team.make.exam",
                "admin.exam.index"
            ];
            if (in_array($routeName, $arrayCheckNameRoute)) return $value;
        };
        if (request()->method() === "DELETE") return $value;

        if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addDays(7));
        // if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addMinutes(60));
        return ($model->getTable() == 'users') ? $value : null;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
