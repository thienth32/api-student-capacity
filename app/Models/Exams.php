<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exams extends Model
{
    use SoftDeletes;
    protected $table = 'exams';
    protected $fillable = ['name', 'description', 'max_ponit', 'ponit', 'external_url', 'round_id', 'time', 'time_type'];
    use HasFactory;
}
