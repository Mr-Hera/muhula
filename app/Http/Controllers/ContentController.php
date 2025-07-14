<?php

namespace App\Http\Controllers;

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
}
