<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    protected $table = 'event_participants';

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];

    protected $fillable = [
        'event_id',
        'user_id',
        'role',
        'status',
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //scope
    public function scopeMentor($query)
    {
        return $query->where('role', config('util.EVENT.PARTICIPANT.ROLE.MENTOR'));
    }
    public function scopeNormalUser($query)
    {
        return $query->where('role', config('util.EVENT.PARTICIPANT.ROLE.USER'));
    }
}
