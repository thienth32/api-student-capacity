<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Support\Facades\DB;

class Candidate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'candidates';
    protected $fillable = ['post_id', 'name', 'phone', 'email', 'file_link', 'student_code', 'major_id', 'status', 'result', 'student_status', 'has_checked', 'send_cv_at'];
    // protected $casts = [
    //     'file_link' => FormatImageGet::class,
    // ];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function countCv($email, $post_id)
    {
        return DB::table($this->table)->where('email', $email)->where('post_id', $post_id)->count();
    }

    public function candidateNotes()
    {
        return $this->hasMany(CandidateNote::class, 'candidate_id')->orderBy('created_at', 'desc');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}
