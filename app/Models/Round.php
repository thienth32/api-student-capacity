<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Round extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public static function boot(){
    //     parent::boot();
    // }

    public function format()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => Storage::disk('google')->has($this->image) ? Storage::disk('google')->url($this->image) : null,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "description" => $this->description,
            "contest_id" => $this->contest_id,
            "type_exam_id" => $this->type_exam_id,
        ];
    }

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

    public function results()
    {
        return $this->hasMany(Result::class, 'round_id');
    }
}