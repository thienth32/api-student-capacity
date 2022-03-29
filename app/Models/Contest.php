<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;
    protected $table = 'contests';

    public $fillable = [
        'name',
        'img',
        'date_start',
        'register_deadline',
        'description',
        'major_id',
        'status',
    ];
    public function teams()
    {
        return $this->hasMany(Team::class, 'contest_id')->with('members');
    }
}