<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundTeam extends Model
{

    protected $table='round_teams';
    protected $fillable=['team_id','round_id'];
    use HasFactory;
}
