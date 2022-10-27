<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobQueue extends Model
{
    use HasFactory;
    protected $table = 'job_shedule';
    protected $guarded = [];
}