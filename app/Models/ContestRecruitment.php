<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestRecruitment extends Model
{
    use HasFactory;
    protected $table = 'contest_recruitments';
    protected $fillable = ['contest_id', 'recruitment_id'];
}
