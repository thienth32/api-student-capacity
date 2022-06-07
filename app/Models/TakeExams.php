<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TakeExams extends Model
{
    use SoftDeletes;
    use \Znck\Eloquent\Traits\BelongsToThrough;
    protected $table = 'take_exams';
    protected $fillable = [
        'exam_id',
        'round_team_id',
        'mark_comment',
        'final_point',
        'result_url',
        'file_url',
        'status'
    ];
    use HasFactory;
    public function exam()
    {
        return $this->belongsTo(Exams::class, 'exam_id', 'id');
    }
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'exams_team_id');
    }
    public function evaluation()
    {
        return $this->hasMany(Evaluation::class, 'exams_team_id')->with('judge_round');
    }
    public function history_point()
    {
        return $this->morphOne(HistoryPoints::class, 'historiable');
    }
    public function teams()
    {
        return $this->belongsToThrough(Team::class, RoundTeam::class);
    }
}