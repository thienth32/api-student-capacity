<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;

class Question extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'questions';
    protected $primaryKey = "id";
    public $fillable = [
        'content',
        'status',
        'type',
        'rank'
    ];
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        // 'image' => FormatImageGet::class,
    ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->answers()->delete();
            $q->skills()->detach();
        });
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'question_skills', 'question_id', 'skill_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function resultCapacityDetail()
    {
        return $this->hasMany(ResultCapacityDetail::class, 'question_id');
    }
}