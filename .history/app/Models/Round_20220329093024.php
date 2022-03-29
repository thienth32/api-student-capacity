<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    // public static function boot(){
    //     parent::boot();
    // }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }

    public function type_exam()
    {
        return $this->belongsTo(TypeExam::class, 'type_exam_id');
    }
}