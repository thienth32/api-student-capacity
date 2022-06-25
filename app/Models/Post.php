<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posts';
    protected $fillable = ['content', 'description', 'published_at', 'postable_id', 'postable_type', 'external_link', 'thumbnail_url', 'link_to', 'user_id'];
}
