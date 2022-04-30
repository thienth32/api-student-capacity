<?php

namespace App\Models;

use App\Services\Builder\Builder;
use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "results";
    protected $primaryKey = "id";
    public $fillable = [
        'team_id',
        'round_id',
        'point'
    ];
    // protected $casts = [
    //     'created_at' => FormatDate::class,
    //     'updated_at' =>  FormatDate::class,
    // ];
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    public function team()
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }
    public function round()
    {
        return $this->hasOne(Round::class, 'id', 'round_id');
    }
}