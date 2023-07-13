<?php

namespace App\Models;

use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'status',
        'avatar',
        'mssv',
        'branch_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'avatar' => FormatImageGet::class,
    ];

    protected $appends = [
        // 'sum_point'
        "ctv_st_p"
    ];

    public function getCtvStPAttribute()
    {
        return $this->hasRole(config('util.ROLE_ADMINS'));
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'members', 'user_id', 'team_id')->with('contest');
    }

    public function contest_user()
    {
        return $this->hasMany(ContestUser::class, 'user_id');
    }

    // public function wishlistContests()
    // {
    //     return $this->morphedByMany(Contest::class, 'wishlistable');
    // }

    // public function wishlistContest()
    // {
    //     // return $this->morphOne(Contest::class,  'wishlistable');
    // }

    public function wishlistContests()
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'user_id');
    }

    public function candidateNotes()
    {
        return $this->hasMany(CandidateNote::class, 'user_id');
    }
}
