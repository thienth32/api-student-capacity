<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $table = 'sliders';
    protected $fillable = ['link_to', 'major_id', 'start_time', 'end_time', 'status', 'image_url'];
    use HasFactory;
}