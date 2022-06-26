<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;

class Recruitments extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'recruitments';
    protected $fillable = ['name', 'description', 'start_time', 'end_time', 'image'];
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'image' => FormatImageGet::class,
    ];
    public function enterprise()
    {
        return $this->BelongsToMany(Enterprise::class, 'enterprise_recruitments', 'recruitment_id', 'enterprise_id')->withTimestamps();
    }
    public function contest()
    {
        return $this->BelongsToMany(Contest::class, 'contest_recruitments', 'recruitment_id', 'contest_id')->with('skills')->withTimestamps();
    }
}
