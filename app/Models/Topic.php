<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = "topics";

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];

    protected $fillable = [
        'name',
    ];

    public function projects()
    {
        return $this->morphToMany(Project::class, 'participant', 'project_participants');
    }
}
