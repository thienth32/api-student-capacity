<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeExam extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = "type_exams";
    protected $primaryKey = "id";
    public $fillable = [
        'name','description'
    ];
}
 
