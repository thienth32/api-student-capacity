<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MentorInfo extends Model
{
    use HasFactory;

    protected $table = "mentor_infos";

    protected $fillable = [
        'mentor_id',
        'location',
        'experience',
        'education',
        'position',
        'note',
    ];

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
    ];

    protected $appends = ['location_name'];
    
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function getLocationNameAttribute()
    {
        return config('util.PROVINCES')[$this->location] ?? null;
    }
}
