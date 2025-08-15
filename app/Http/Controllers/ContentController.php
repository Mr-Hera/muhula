<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function aboutUs(){
        return view('content.about_us');
    }

    public function privacyPolicy(){

        return view('content.privacy_policy');
    }

    public function disclaimer(){

        return view('content.disclaimer');
    }

    public function faq(){

        return view('content.faq');
    }

    public function contactUs(){

        return view('content.contact_us');
    }
    
    public function newsDetails($slug){
        $article_record = NewsArticle::where('slug', $slug)->first();
        return view('content.news_details')->with([
        'article_record' => $article_record,
        ]);
    }
}
