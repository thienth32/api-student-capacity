<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'answers';
    protected $primaryKey = "id";
    public $fillable = [
        'content',
        'question_id',
        'is_correct',
    ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    // protected $hidden = ['is_correct'];
    // public function questions()
    // {
    //     return $this->belongsTo(Question::class, 'question_id')->with('answers');
    // }
}