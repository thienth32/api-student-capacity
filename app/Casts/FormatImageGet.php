<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Storage;

class FormatImageGet implements CastsAttributes
{
    private $arrayCheckNameRoute = [
        "admin.round.detail.team.make.exam",
        "admin.exam.index"
    ];

    public function get($model, string $key, $value, array $attributes)
    {
        if ($this->__checkRoute()) return $value;

        if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addDays(7));
        // if (Storage::disk('s3')->has($value ?? "abc.jpg")) return Storage::disk('s3')->temporaryUrl($value, now()->addMinutes(60));
        return ($model->getTable() == 'users') ? $value : $value;
    }

    private function __checkRoute()
    {
        if (request()->route()) {
            $routeName = (request()->route()->getName() ?? "ABS");
            if (in_array($routeName, $this->arrayCheckNameRoute)) return true;
        };
        return false;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return $value;
    }
}
