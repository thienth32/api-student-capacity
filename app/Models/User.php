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
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'avatar',
        'mssv'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'avatar' => FormatImageGet::class,
    ];

    protected $appends = [
        'sum_point'
    ];

    public function getSumPointAttribute()
    {
        return $this->contest_user()->sum('reward_point');
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
}