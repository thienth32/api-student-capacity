<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];

    protected $fillable = [
        'service_id',
        'register_id',
        'status',
        'note',
    ];

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function register() {
        return $this->belongsTo(User::class, 'register_id');
    }

    //scope
    public function scopeInProgress($query) {
        return $query->where('status', config('util.SERVICE.REQUEST_STATUS.IN_PROGRESS'));
    }
    public function scopeFinish($query) {
        return $query->where('status', config('util.SERVICE.REQUEST_STATUS.FINISH'));
    }
}
