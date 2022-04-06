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
    public function donors()
    {
        return $this->belongsToMany(Contest::class, 'donors', 'contest_id', 'enterprise_id');
    }
    use HasFactory;
}
