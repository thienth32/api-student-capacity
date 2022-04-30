<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoundTeam extends Model
{
    use SoftDeletes;
    protected $table = 'round_teams';
    protected $fillable = ['team_id', 'round_id','status'];
    use HasFactory;
    public function takeExam()
    {
        return $this->hasOne(TakeExams::class, 'round_team_id')->with(['exam', 'evaluation']);
    }
}
