<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table="projects";

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
        'thumbnail' => FormatImageGet::class,
    ];

    public $fillable = [
        'name',
        'thumbnail',
        'description',
        'contact_name',
        'status',
    ];

    public function topics() {
        return $this->morphedByMany(Topic::class, 'participant', 'project_participants');
    }

    public function mentors() {
        return $this->morphedByMany(User::class, 'participant', 'project_participants');
    }

    public function enterprises() {
        return $this->morphedByMany(Enterprise::class, 'participant', 'project_participants');
    }
}
