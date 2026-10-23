<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;
    protected $table = "sponsors";

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];

    protected $fillable = [
        'event_id',
        'sponsor_id',
        'priority',
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function company() {
        return $this->belongsTo(Enterprise::class, 'sponsor_id');
    }

    /** local scope */
    public function scopeHost($query) {//ban tổ chức
        return $query->where('priority', config('util.SPONSOR_PRIORITY.HOST'));
    }
    public function scopeParticipant($query) { //tham gia thường
        return $query->where('priority', config('util.SPONSOR_PRIORITY.PARTICIPANT'));
    }
    public function scopeSilver($query) { //tài trợ bạc
        return $query->where('priority', config('util.SPONSOR_PRIORITY.SILVER'));
    }
    public function scopeGold($query) { //tài trợ vàng
        return $query->where('priority', config('util.SPONSOR_PRIORITY.GOLD'));
    }
    public function scopeDiamond($query) { //tài trợ kim cương
        return $query->where('priority', config('util.SPONSOR_PRIORITY.DIAMOND'));
    }
}
