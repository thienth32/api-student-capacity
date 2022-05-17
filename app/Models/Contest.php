<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use App\Services\Traits\TGetAttributeColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use SoftDeletes;
    use HasFactory, TGetAttributeColumn;
    protected $table = 'contests';
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'img' => FormatImageGet::class,
    ];
    protected $appends = [
        'slug_name',
    ];
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->teams()->delete();
            $q->rounds()->delete();
            $q->enterprise()->detach();
            $q->judges()->detach();
        });
    }
    public $fillable = [
        'name',
        'date_start',
        'register_deadline',
        'description',
        'major_id',
        'status',
        'start_register_time',
        'end_register_time',
        'max_user'
    ];
    public function teams()
    {
        return $this->hasMany(Team::class, 'contest_id')->with('members');
    }
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function judges() // Giám khảo
    {
        return $this->belongsToMany(User::class, 'judges', 'contest_id', 'user_id');
    }
    public function rounds()
    {
        return $this->hasMany(Round::class, 'contest_id');
    }

    public function enterprise()
    {
        return $this->belongsToMany(Enterprise::class, 'donors', 'contest_id', 'enterprise_id')->withTimestamps();
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}