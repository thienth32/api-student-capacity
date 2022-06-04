<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestUser extends Model
{
    use HasFactory;
    protected $table = 'contest_users';
    protected $guarded = [];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }
}
