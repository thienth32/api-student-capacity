<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{
    use HasFactory;

    protected $table = 'frequently_asked_questions';

    protected $fillable = [
        'question',
        'answer',
        'category_id',
        'view'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' =>  'datetime:Y-m-d H:i:s',
    ];

    public function upRatings() {
        return $this->hasMany(FaqRating::class, 'faq_id')->up();
    }

    public function downRatings() {
        return $this->hasMany(FaqRating::class, 'faq_id')->down();
    }

    public function category() {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
}
