<?php

namespace App\Models;

use App\Services\Builder\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = "wishlists";
    // protected $primaryKey = "id";
    public $fillable = ['user_id', 'status'];

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
    public function wishlistable()
    {
        return $this->morphTo();
    }
}