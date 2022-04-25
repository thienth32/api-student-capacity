<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MajorSkill extends Model
{
    use HasFactory;
    protected $table='major_skills';
    protected $fillable=['major_id','skill_id'];
}
