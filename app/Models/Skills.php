<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skills extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'skills';
    protected $fillable = ['name', 'short_name', 'image_url', 'description'];
    public function majorSkill()
    {

        return $this->belongsToMany(Major::class, 'major_skills', 'skill_id', 'major_id');
    }

}
