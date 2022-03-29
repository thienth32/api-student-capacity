<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;
    protected $table = 'contests';

    public function teams()
    {
        return $this->hasMany(Team::class, 'contest_id')->with('members');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}