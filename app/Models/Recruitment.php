<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recruitment extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    use HasFactory, SoftDeletes;
    protected $table = 'recruitments';
    protected $fillable = ['amount', 'cost', 'hot', 'name', 'short_description', 'description', 'start_time', 'end_time', 'image'];
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'image' => FormatImageGet::class,
    ];
    public function recruitmentEnterprise()
    {
        return $this->belongsToMany(Recruitment::class, 'enterprise_recruitments', 'recruitment_id', 'enterprise_id')->withTimestamps();
    }
    public function enterprise()
    {
        return $this->belongsToMany(Enterprise::class, 'enterprise_recruitments', 'recruitment_id', 'enterprise_id')->withTimestamps();
    }
    public function contest()
    {
        return $this->belongsToMany(Contest::class, 'contest_recruitments', 'recruitment_id', 'contest_id')->withTimestamps();
    }
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }
    public function skill()
    {

        return $this->hasManyDeep(
            Skill::class,
            [
                'contest_recruitments',
                Contest::class,
                'contest_skills'
            ]
        );
    }
    public function rounds()
    {
        return $this->hasManyDeep(Round::class, ['contest_recruitments',    Contest::class,]);
    }
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}