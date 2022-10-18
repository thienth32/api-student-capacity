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
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function challenge()
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }
    public function codeLanguage()
    {
        return $this->hasOne(CodeLanguage::class, 'id', 'code_language_id');
    }
}