<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    public function showUserLoginForm(Request $request)
    {
        // if(@$request->redirect_uri){
        //     Session::put('redirect_uri', @$request->redirect_uri);
        // }
        // if(url()->previous() != url('login')) {
        //     session()->put('previous_url', url()->previous());
        // }
        // if(url()->previous() != url('sign-up')){

        //     session()->put('previous_url', url()->previous());
        // }

        // $data = [];
        // if(Cookie::get('email') != null && Cookie::get('password') != null && Cookie::get('remember') != null) {
        //     $data['email'] = Cookie::get('email');
        //     $data['password'] = Cookie::get('password');
        //     $data['remember'] = Cookie::get('remember');
        // }
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ], [
            'email.exists' => 'These credentials do not match our records.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    { 
        if(@$request->redirect_uri){
            Session::put('redirect_uri', @$request->redirect_uri);
        }
        if(url()->previous() != url('login')) {
            session()->put('previous_url', url()->previous());
        }
        if(url()->previous() != url('sign-up')){

            session()->put('previous_url', url()->previous());
        }
        return view('auth.register');
    }

    public function registerSave(Request $request)
    { 
        //dd(session()->get('school_id'));
        $this->validate($request, [
          'g-recaptcha-response' => new Captcha(),  
          'first_name'  =>['required','max:30'],
          'last_name'   =>['required','max:30'], 
          'email'    => ['required', 'email',
                Rule::unique('users')->ignore('D', 'status')
            ],
            'password' => ['required'],          
        ]);

        $creates['first_name']        = $request->first_name;
        $creates['last_name']        = $request->last_name;
        $creates['email']       = $request->email;
        $creates['password'] = Hash::make($request->password);
        $creates['email_code'] = rand(10000,99999); 
        $creates['status']  = 'U';
        $creates['school_reg']  = $request->school_reg?$request->school_reg:'N';
        if(session()->has('school_id')){

            $creates['school_id'] = session()->get('school_id');
        }
        
        $user = User::create($creates);

        if(!$user){
            return redirect()->back()->with('error','Something went wrong!');
        }
        $creates['name'] = @$user->first_name. ' '.@$user->last_name;
        $creates['link'] = route('verify.user.email', [@$user->email_code,md5(@$user->id)]);
        Mail::send(new UserVerifyMail($creates));
        return redirect()->route('user.success.msg')->with('success','Thanks for signing up! Please verify your email to activate your account. A verification link has been sent to your email. If not found, check your spam folder too.');

    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
