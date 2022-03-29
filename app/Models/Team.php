<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $primaryKey = "id";
    public $fillable = [
        'name',
        'image',
        'contest_id',
    ];
    public function members()
    {
        return $this->hasMany(Member::class, 'team_id');
    }
}