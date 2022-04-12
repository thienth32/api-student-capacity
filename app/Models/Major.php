<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'majors';
    protected $fillable = [
        'name',
        'slug'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->contests()->delete();
        });
    }

    public function contests()
    {
        return $this->hasMany(Contest::class, 'major_id');
    }
    public function Skill()
    {
        return $this->belongsToMany(Skills::class, 'major_skills','major_id','skill_id');

    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
