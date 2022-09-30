<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'skills';
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'image_url' => FormatImageGet::class,
    ];

    protected $fillable = ['name', 'short_name', 'image_url', 'description'];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function majorSkill()
    {
        return $this->belongsToMany(Major::class, 'major_skills', 'skill_id', 'major_id')->withTimestamps();
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_skills', 'skill_id', 'question_id');
    }
}