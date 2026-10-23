<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
        'thumbnail' => FormatImageGet::class,
        'timeline' => FormatImageGet::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'start_at',
        'end_at',
        'created_by',
        'thumbnail',
        'timeline',
        'status',
        'register_link',
        'interview_count',
        'jobs_opening_count',
        'note',
    ];

    public function participants() {
        return $this->hasMany(EventParticipant::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sponsors() {
        return $this->hasMany(Sponsor::class, 'event_id');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }
}
