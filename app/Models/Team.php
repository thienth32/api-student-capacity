<?php

namespace App\Models;

use App\Services\Traits\TGetAttributeColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;

class Team extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'teams';
    protected $primaryKey = "id";
    public $fillable = [
        'name',
        'image',
        'contest_id',
    ];

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'image' => FormatImageGet::class,
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->members()->detach();
        });
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'members', 'team_id', 'user_id')->withPivot('bot');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'members', 'team_id', 'user_id');
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }

    public function roundTeam()
    {
        return $this->hasMany(RoundTeam::class);
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}