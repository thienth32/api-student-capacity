<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use SoftDeletes;
    protected $table = 'exams';
    protected $fillable = ['name', 'description', 'max_ponit', 'ponit', 'external_url', 'round_id', 'time', 'time_type', "type", "status", "room_code", "room_token", "room_progress"];
    use HasFactory;
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'external_url' => FormatImageGet::class,
    ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function round()
    {
        return $this->hasOne(Round::class, 'id', 'round_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions', 'exam_id', 'question_id');
    }
    public function resultCapacity()
    {
        return $this->hasMany(ResultCapacity::class, 'exam_id');
    }
}
