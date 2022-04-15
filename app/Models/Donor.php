<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donor extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'donors';
    protected $fillable = ['contest_id', 'enterprise_id'];

    public function Enterprise()
    {
    return $this->belongsTo(Enterprise::class,'enterprise_id');
    }
}
