<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsNotificationMail;

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

    public function contactUsEmailNotification(Request $request) {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Mail::to(config('mail.admin_address'))
            ->send(new ContactUsNotificationMail($validated));

        return back()->with('success', 'Your message has been sent successfully.');
    }
    
    public function newsDetails($slug){
        $article_record = NewsArticle::where('slug', $slug)->first();
        return view('content.news_details')->with([
        'article_record' => $article_record,
        ]);
    }
}
