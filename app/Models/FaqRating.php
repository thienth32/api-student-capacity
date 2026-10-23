<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'faq_id',
        'type',
        'content',
    ];

    protected $casts = [
        'created_at' => FormatDate::class,
        'updated_at' =>  FormatDate::class,
    ];

    public function scopeUp($query) {
        return $query->where('type', config('util.FAQ.RATING.TYPE.UPVOTE'));
    }

    
    public function scopeDown($query) {
        return $query->where('type', config('util.FAQ.RATING.TYPE.DOWNVOTE'));
    }

    public function faq() {
        return $this->belongsTo(FrequentlyAskedQuestion::class, 'faq_id');
    }
}
