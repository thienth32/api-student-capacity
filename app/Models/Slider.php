<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $table = 'sliders';
    protected $guarded = [];
    use HasFactory;

    protected $casts = [
        'image_url' => FormatImageGet::class,
    ];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function sliderable()
    {
        return $this->morphTo();
    }
}