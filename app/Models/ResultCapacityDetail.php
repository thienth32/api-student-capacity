<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultCapacityDetail extends Model
{
    use HasFactory;
    protected $table = "result_capacity_detail";
    protected $primaryKey = "id";
    // public $fillable = [];
    protected $guarded = [];
}