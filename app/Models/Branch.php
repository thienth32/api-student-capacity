<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Builder\Builder;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    protected $primaryKey = 'id';
    protected $table = 'branches';
    protected $fillable = [
        'name',
        'code',
        'description',
        'logo',
        'address',
        'phone',
        'status',
        'email',
        'website',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function ($q) {
    //         $q->contests()->delete();
    //     });
    // }

    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function enterprises()
    {
        return $this->hasMany(Enterprise::class, 'branch_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'branch_id');
    }

    public function recruitments()
    {
        return $this->hasMany(Recruitment::class, 'branch_id');
    }
}
