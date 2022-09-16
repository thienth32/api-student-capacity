<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TakeExam extends Model
{
    use HasFactory;
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
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
    ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
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
        return $this->morphOne(HistoryPoint::class, 'historiable');
    }

    public function teams()
    {
        return $this->belongsToThrough(Team::class, RoundTeam::class);
    }
}