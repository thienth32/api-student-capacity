<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keyword extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'keywords';
    protected $fillable = ['keyword', 'keyword_en', 'keyword_slug', 'type', 'status'];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        // 'image' => FormatImageGet::class,
    ];
}