<?php

namespace App\Models;

use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'author_id',
        'published_at',
        'is_published',
    ];

    public function author() 
    { 
        return $this->belongsTo(User::class, 'author_id'); 
    }
    
    public function categories() 
    { 
        return $this->belongsToMany(NewsCategory::class, 'article_category', 'article_id', 'category_id'); }
}
