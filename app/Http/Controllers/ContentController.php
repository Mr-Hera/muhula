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
}
