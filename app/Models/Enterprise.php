<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use SoftDeletes;
    protected $table = 'enterprises';
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'logo' => FormatImageGet::class,
    ];
    protected $fillable = ['name', 'logo', 'description'];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            $q->donors()->detach();
        });
    }
    public function donors()
    {
        return $this->belongsToMany(Contest::class, 'donors');
    }
    public function recruitment()
    {
        return $this->BelongsToMany(Recruitments::class, 'enterprise_recruitments', 'enterprise_id', 'recruitment_id')->with('contest')->withTimestamps();
    }
    use HasFactory;
}
