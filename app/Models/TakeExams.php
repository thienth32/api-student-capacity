<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakeExams extends Model
{
    protected $table = 'take_exams';
    protected $fillable = ['exam_id', 'round_team_id'];
    use HasFactory;
}
