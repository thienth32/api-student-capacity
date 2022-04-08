<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoundTeam extends Model
{
    use SoftDeletes;
    protected $table='round_teams';
    protected $fillable=['team_id','round_id'];
    use HasFactory;
}
