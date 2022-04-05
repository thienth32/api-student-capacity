<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
  protected $table='donors';
  protected $fillable=['contest_id','enterprise_id'];
    use HasFactory;
}
