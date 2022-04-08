<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes;
    protected $table = 'enterprises';
    protected $fillable = ['name', 'logo', 'description'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->donors()->detach();
        });
    }
    public function donors()
    {
        return $this->belongsToMany(Contest::class, 'donors');
    }
    use HasFactory;
}
