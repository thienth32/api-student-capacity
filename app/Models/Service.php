<?php

namespace App\Models;

use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' => FormatDate::class,
        'thumbnail' => FormatImageGet::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'thumbnail',
        'status',
        'created_by',
        'link',
    ];

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function requests() {
        return $this->hasMany(ServiceRequest::class);
    }
}
