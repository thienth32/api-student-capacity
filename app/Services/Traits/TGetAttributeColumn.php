<?php

namespace App\Services\Traits;

trait TGetAttributeColumn
{
    public function  getSlugNameAttribute()
    {
        return \Str::slug($this->name);
    }
}