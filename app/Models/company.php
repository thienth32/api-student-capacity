<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $table='enterprises';
    use HasFactory;
    public function feedbacks(){
        return $this->hasMany(feedback::class,'company_id');
      }

}
