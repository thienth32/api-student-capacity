<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use SoftDeletes;
    protected $table = 'exams';
    protected $fillable = ['name', 'description', 'max_ponit', 'ponit', 'external_url', 'round_id', 'time', 'time_type', "type"];
    use HasFactory;



    public function round()
    {
        return $this->hasOne(Round::class, 'id', 'round_id');
    }

    public function questions()
    {
        return $this->belongsToMany(Questions::class, 'exam_questions', 'exam_id', 'question_id');
    }
}
