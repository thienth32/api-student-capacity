<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPoint extends Model
{
    use HasFactory;
    protected $table = "history_points";
    protected $guarded = [];
    public function historiable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
