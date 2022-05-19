<?php

namespace App\Services\Traits;

use Illuminate\Support\Str;

trait TGetAttributeColumn
{
    public function  getSlugNameAttribute()
    {
        return Str::slug($this->name);
    }

    public function  getStatusUserHasJoinContestAttribute()
    {
        if (!auth('sanctum')->check()) return false;
        foreach ($this->teams as $team) {
            foreach ($team->members as $user) {
                if (auth('sanctum')->user()->email == $user->email) return true;
            }
        }
        return false;
    }
}