<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $table = 'enterprises';
    protected $fillable = ['name', 'logo', 'description'];
    public function donors()
    {
        return $this->belongsToMany(Contest::class, 'donors', 'contest_id', 'enterprise_id');
    }
    use HasFactory;
}
