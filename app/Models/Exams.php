<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exams extends Model
{
    protected $table='exams';
protected $fillable=['name','description','max_ponit','ponit','external_url','round_id'];
    use HasFactory;
}
