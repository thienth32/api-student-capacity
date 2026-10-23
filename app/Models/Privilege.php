<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $table = 'privileges';

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
        'thumbnail' => FormatImageGet::class,
    ];

    protected $fillable = [
        'title',
        'thumbnail',
        'register_deadline',
        'expire_date',
        'description',
        'short_description',
        'link',
    ];
}
