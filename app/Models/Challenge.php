<?php

namespace App\Models;

use App\Services\Builder\Builder;
use App\Casts\FormatJson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challenge extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'challenges';
    protected $guarded = [];
    protected $casts = [
        'rank_point' => FormatJson::class,
    ];

    public function sample_code()
    {
        return $this->hasMany(SampleChallenge::class);
    }

    public function result()
    {
        return $this->hasMany(ResultCode::class);
    }

    public function test_case()
    {
        return $this->hasMany(TestCase::class);
    }


    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}