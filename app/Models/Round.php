<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;
    protected $table = "rounds";
    protected $primaryKey = "id";
    public $fillable = [
        'name',
        'image',
        'start_time',
        'end_time',
        'description',
        'contest_id',
        'type_exam_id',
    ];
}