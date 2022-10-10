<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use App\Services\Traits\TGetAttributeColumn;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Round extends Model
{
    use SoftDeletes;
    use HasFactory, TGetAttributeColumn;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $table = "rounds";
    protected $primaryKey = "id";
    protected $appends = [
        'slug_name',
        'user_status_join',
    ];
    public $fillable = [
        'name',
        'image',
        'start_time',
        'end_time',
        'description',
        'contest_id',
        'type_exam_id',
    ];
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'image' => FormatImageGet::class,
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            // $q->results()->delete();
            //            $q->teams()->detach();
            //            $q->judges()->detach();
        });
    }

    public function format()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => Storage::disk('s3')->has($this->image) ? Storage::disk('s3')->temporaryUrl($this->image, now()->addMinutes(5)) : null,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "description" => $this->description,
            "contest_id" => $this->contest_id,
            "type_exam_id" => $this->type_exam_id,
            "contest" => $this->contest->toArray()
        ];
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id')->with(['teams', 'rounds']);
    }
    public function enterprise_contest()
    {
        return $this->belongsTo(Contest::class, 'contest_id')->with('enterprise:id,name,logo');
    }
    public function Donor()
    {
        return $this->belongsToMany(Donor::class, 'donor_rounds', 'round_id', 'donor_id')->withPivot('id')->with('Enterprise:id,name,logo');
    }
    public function type_exam()
    {
        return $this->belongsTo(TypeExam::class, 'type_exam_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'round_id');
    }

    public function judges() // Giám khảo
    {
        return $this->belongsToMany(Judge::class, 'judges_rounds', 'round_id', 'judge_id')->with(['user', 'evaluation']);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'round_teams', 'round_id', 'team_id')->wherePivot('status', 1); //đã công bố
    }

    public function add_Teams()
    {
        return $this->belongsToMany(Team::class, 'round_teams', 'round_id', 'team_id')->wherePivot('status', 2); //chưa công bố
    }

    public function sliders()
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'round_id');
    }
    public function result_capacity()
    {
        return
            $this->hasManyThrough(
                ResultCapacity::class,
                Exam::class,
                'round_id',
                'exam_id',
                'id'
            )
            ->with('user:id,name,email');
    }

    /** Dùng cho phần call api bài viết thuộc vòng thi có thêm doanh nghiệp */
    public function enterprise()
    {
        return $this->hasManyDeep(
            Enterprise::class,
            [
                'donor_rounds',
                Donor::class
            ],
            [
                'round_id',
                'id',
                'id'
            ],
            [
                'id',               // Local key on "tool_groups" table
                'donor_id',          // Local key on pivot table
                'enterprise_id'
            ]

        );
    }
}