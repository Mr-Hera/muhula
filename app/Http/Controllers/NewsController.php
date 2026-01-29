<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function newsList(Request $request){
        $allNews = NewsArticle::all();
        return view('content.news')->with([
            'allNews' => $allNews,
        ]);
    }
}
