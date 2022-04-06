<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TakeExams extends Model
{
    use SoftDeletes;
    protected $table = 'take_exams';
    protected $fillable = ['exam_id', 'round_team_id'];
    use HasFactory;
}
