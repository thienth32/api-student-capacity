<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answers extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'answers';
    protected $primaryKey = "id";
    public $fillable = [
        'content',
        'question_id',
        'is_correct',
    ];
    // protected $hidden = ['is_correct'];
    // public function questions()
    // {
    //     return $this->belongsTo(Question::class, 'question_id')->with('answers');
    // }
}