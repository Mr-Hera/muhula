<?php

namespace App\Models;

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArticleCategory extends Model
{
    use HasFactory;

    public function article() 
    { 
        return $this->belongsTo(NewsArticle::class, 'article_id'); 
    }
    
    public function category() 
    { 
        return $this->belongsTo(NewsCategory::class, 'category_id'); }
}
