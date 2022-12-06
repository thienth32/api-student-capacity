<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use App\Services\Traits\TGetAttributeColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use SoftDeletes;
    use HasFactory, TGetAttributeColumn;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $table = 'contests';
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'img' => FormatImageGet::class,
        'image_banner' => FormatImageGet::class,
    ];
    protected $appends = [
        'slug_name',
        'status_user_has_join_contest',
        'user_wishlist'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            //            $q->teams()->delete();
            //            $q->rounds()->delete();
            //            $q->enterprise()->detach();
            //            $q->judges()->detach();
        });
    }

    public $fillable = [
        'name',
        'date_start',
        'register_deadline',
        'description',
        'major_id',
        'status',
        'start_register_time',
        'end_register_time',
        'max_user',
        'reward_rank_point',
        'post_new',
        'img',
        'image_banner'
    ];

    public function recruitment()
    {
        return $this->belongsToMany(Recruitment::class, 'contest_recruitments', 'contest_id', 'recruitment_id')->withTimestamps();
    }
    public function teams()
    {
        return $this->hasMany(Team::class, 'contest_id');
    }
    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
    public function judges() // Giám khảo
    {
        return $this->belongsToMany(User::class, 'judges', 'contest_id', 'user_id');
    }
    public function rounds()
    {
        return $this->hasMany(Round::class, 'contest_id')->with('result_capacity');
    }

    public function enterprise()
    {
        return $this->belongsToMany(Enterprise::class, 'donors', 'contest_id', 'enterprise_id')->withTimestamps();
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'contest_skills', 'contest_id', 'skill_id')->withTimestamps();
    }
    public function contest_users()
    {
        return $this->hasMany(ContestUser::class, 'contest_id');
    }
    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }
    public function take_exams()
    {
        return $this->hasManyDeep(
            TakeExam::class,
            [Round::class, Exam::class],
            [
                'contest_id',
                'round_id',
                'exam_id',
            ]
        );
    }

    public function userCapacityDone()
    {
        return $this->hasManyDeep(
            ResultCapacity::class,
            [
                Round::class,
                Exam::class
            ],
            [
                'contest_id',
                'round_id',
                'exam_id',
            ]
        )->where('result_capacity.status', config('util.STATUS_RESULT_CAPACITY_DONE'));
    }

    public function recruitmentEnterprise()
    {
        return $this->hasManyDeep(
            Enterprise::class,
            [
                'contest_recruitments',
                Recruitment::class,
                'enterprise_recruitments'
            ]
        );
    }

    public function resultCapacity()
    {
        return $this->hasManyDeep(
            ResultCapacity::class,
            [
                Round::class,
                Exam::class
            ],
            [
                'contest_id',
                'round_id',
                'exam_id',
            ]
        )->with('user:id,name,email,status');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function wishlist()
    {
        return $this->morphOne(Wishlist::class, 'wishlistable');
    }
    public function wishlistUsers()
    {
        return $this->morphMany(Wishlist::class, 'wishlistable');
    }


    public function user_top()
    {
        return $this->hasOneDeep(
            ResultCapacity::class,
            [
                Round::class,
                Exam::class
            ],
            [
                'contest_id',
                'round_id',
                'exam_id',
            ]
        )->with('user:id,name,email,avatar')
            ->where('result_capacity.status', config('util.STATUS_RESULT_CAPACITY_DONE'))
            ->groupBy('result_capacity.user_id')
            ->selectRaw('sum(result_capacity.scores) as total_scores, result_capacity.user_id')
            ->orderByDesc('total_scores');
    }
}
