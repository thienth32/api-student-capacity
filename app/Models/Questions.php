<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questions extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'questions';

    public function answers()
    {
        return $this -> hasMany(Answers::class,'question_id');
    }

    public function skill()
    {
        return $this -> belongsToMany(Skills::class,'question_skills' , 'question_id' ,'skill_id');
    }
}
