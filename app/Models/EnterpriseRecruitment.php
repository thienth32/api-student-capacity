<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseRecruitment extends Model
{
    use HasFactory;
    protected $table = 'enterprise_recruitments';
    protected $fillable = ['enterprise_id', 'recruitment_id'];
}
