<?php

namespace App\Models;

use App\Services\Traits\TGetAttributeColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'teams';
    protected $primaryKey = "id";
    public $fillable = [
        'name',
        'image',
        'contest_id',
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->members()->detach();
        });
    }
    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'members', 'team_id', 'user_id')->withPivot('bot');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'members', 'team_id', 'user_id');
    }
}