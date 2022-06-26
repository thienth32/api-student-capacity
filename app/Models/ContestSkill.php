<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestSkill extends Model
{
    use HasFactory;
    protected $table = 'contest_skills';
    protected $fillable = ['contest_id', 'skill_id'];
}
