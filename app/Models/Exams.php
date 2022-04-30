<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exams extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'exams';
    protected $fillable = ['name', 'description', 'max_ponit', 'ponit', 'external_url', 'round_id'];


    public function round()
    {
        return $this->hasOne(Round::class, 'id', 'round_id');
    }
}