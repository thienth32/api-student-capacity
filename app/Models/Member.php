<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'members';
    protected $fillable = ['user_id', 'team_id'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}