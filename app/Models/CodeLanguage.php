<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeLanguage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'code_language';
    protected $guarded = [];
}