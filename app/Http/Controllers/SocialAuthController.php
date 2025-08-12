<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        // if(@$request->redirect_uri){
        //     Session::put('redirect_uri', @$request->redirect_uri);
        // }
        // if(url()->previous() != url('login')) {
        //     session()->put('previous_url', url()->previous());
        // }
        // if(url()->previous() != url('sign-up')){

        //     session()->put('previous_url', url()->previous());
        // }
        return view('auth.register');
    }

    public function registerSave(Request $request)
    {
        // dd($request);
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'password2' => ['required', 'same:password'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login after registration
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully!');
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
