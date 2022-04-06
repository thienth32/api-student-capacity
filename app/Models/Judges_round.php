<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judges_round extends Model
{
    protected $table ='judges_rounds';
    protected $fillable=['judge_id','round_id'];
    use HasFactory;
}
