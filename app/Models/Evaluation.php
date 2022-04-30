<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation extends Model
{
    use SoftDeletes;
    protected $table = 'evaluations';
    protected $guarded = [];
    use HasFactory;

    public function judge_round()
    {
        return $this->belongsTo(Judges_round::class, 'judge_round_id')->with('judge');
    }
}