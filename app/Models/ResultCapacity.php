<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultCapacity extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "result_capacity";
    protected $primaryKey = "id";
    public $fillable = [
        'scores',
        'status',
        'exam_id',
        'user_id',
        'type'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
