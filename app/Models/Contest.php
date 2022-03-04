<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;
    protected $table='contests';

    public function teams(){
        return $this->hasMany(Team::class,'contest_id')->with('members');
    }
}
