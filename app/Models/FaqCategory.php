<?php

namespace App\Models;

use App\Casts\FormatDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;

    protected $table = 'faq_categories';

    protected $fillable = [
        'name',
        'parent_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' =>  'datetime:Y-m-d H:i:s',
    ];

    public function faqs() {
        return $this->hasMany(FrequentlyAskedQuestion::class, 'category_id');
    }

    public function parent() {
        return $this->belongsTo(FaqCategory::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(FaqCategory::class, 'parent_id')->orderBy('name');
    }

    public function scopeRoots($q) //Lấy các root nodes
    {
        return $q->whereNull('parent_id');
    }
}
