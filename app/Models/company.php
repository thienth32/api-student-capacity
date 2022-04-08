<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class company extends Model
{
   use SoftDeletes;
    protected $table='enterprises';
    use HasFactory;
}
