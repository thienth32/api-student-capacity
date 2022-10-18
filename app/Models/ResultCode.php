<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultCode extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'result_code';
    protected $guarded = [];

    public function challenge()
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }
    public function code_language()
    {
        return $this->belongsTo(CodeLanguage::class, 'code_language_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}