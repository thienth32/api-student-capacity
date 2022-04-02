<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table='members';
    protected $fillable=['user_id','team_id'];
    public function user(){
        return $this->hasMany(User::class,'id');
    }
    use HasFactory;
}
