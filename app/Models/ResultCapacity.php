<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultCapacity extends Model
{
    use HasFactory, SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \Znck\Eloquent\Traits\BelongsToThrough;
    protected $table = "result_capacity";
    protected $primaryKey = "id";
    public $fillable = [
        'scores',
        'status',
        'exam_id',
        'user_id',
        'type',
        'donot_answer',
        'false_answer',
        'true_answer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function resultCapacityDetail()
    {
        return $this->hasMany(ResultCapacityDetail::class, 'result_capacity_id');
    }

    public function contests()
    {

        return $this->belongsToThrough(
            Contest::class,
            [Round::class, Exam::class],
            [
                'contest_id',
                'round_id',
                'exam_id',
            ]
        );
    }
    public function exam()
    {
        return $this->hasMany(Exam::class, 'id', 'exam_id');
    }
}