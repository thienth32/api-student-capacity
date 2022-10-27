<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoundTeam extends Model
{
    // use SoftDeletes;
    protected $table = 'round_teams';
    protected $fillable = ['team_id', 'round_id', 'status'];
    use HasFactory;

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function takeExam()
    {
        return $this->hasOne(TakeExam::class, 'round_team_id')->with(['exam', 'evaluation']);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'round_id', 'round_id');
    }
}