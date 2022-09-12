<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'candidates';
    protected $fillable = ['post_id', 'name', 'phone', 'email', 'file_link'];
    protected $casts = [
        // 'created_at' => FormatDate::class,
        // 'updated_at' =>  FormatDate::class,
        // 'file_link' => FormatImageGet::class,
    ];
}
