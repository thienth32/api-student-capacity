<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;
    protected $table = 'majors';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function contests()
    {
        return $this->hasMany(Contest::class, 'major_id');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}