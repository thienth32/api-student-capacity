<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    protected $table = "stats";

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
        'icon' => FormatImageGet::class,
        'data' => 'array',
    ];

    protected $fillable = [
        'name',
        'icon',
        'data',
        'type',
    ];
}
