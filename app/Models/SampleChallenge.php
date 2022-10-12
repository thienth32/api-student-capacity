<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SampleChallenge extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'sample_challenge';
    protected $guarded = [];

    public function code_language()
    {
        return $this->belongsTo(CodeLanguage::class, 'code_language_id');
    }
}