<?php

namespace App\Services\Traits;

use Illuminate\Support\Str;

trait TGetAttributeColumn
{
    public function  getSlugNameAttribute()
    {
        return Str::slug($this->name);
    }
}