<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table='teams';
    public function members(){
        return $this->hasMany(Member::class, 'team_id');
    }
    public function results(){
        return $this->hasMany(Result::class, 'team_id');
    }

}
