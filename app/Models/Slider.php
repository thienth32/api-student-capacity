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
    protected $fillable = ['link_to', 'major_id', 'start_time', 'end_time', 'status', 'image_url'];
    use HasFactory;

    protected $casts = [
        'image_url' => FormatImageGet::class,
    ];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}