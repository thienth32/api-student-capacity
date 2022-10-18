<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $fillable = ['hot', 'code_recruitment', 'status_capacity', 'content', 'status', 'description', 'published_at', 'postable_id', 'postable_type', 'title', 'slug', 'thumbnail_url', 'link_to', 'user_id'];
    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
        'thumbnail_url' => FormatImageGet::class,
    ];
    protected $appends = [
        'user_wishlist'
    ];

    public function postable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function wishlist()
    {
        return $this->morphOne(Wishlist::class, 'wishlistable');
    }

    public function  getUserWishlistAttribute()
    {
        if (!auth('sanctum')->id()) return false;
        $wishlist = Wishlist::where('user_id', auth('sanctum')->id())
            ->where(function ($query) {
                $query->where('wishlistable_type', $this::class);
                $query->where('wishlistable_id', $this->id);
                return $query;
            })->first();
        if ($wishlist) {
            return true;
        }
        return false;
    }
}