<?php

namespace App\Models;

use App\Casts\CandidateNoteContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\FormatDate;
use App\Casts\FormatImageGet;
use Illuminate\Support\Facades\DB;

class CandidateNote extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'candidate_notes';
    protected $fillable = ['candidate_id', 'user_id', 'content', 'status'];
    protected $casts = [
        'content' => CandidateNoteContent::class,
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
