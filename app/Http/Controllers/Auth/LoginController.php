<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

     protected $redirectTo = '/dashboard';

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // dd($this->middleware('guest')->except(['handleProviderCallback','logout']));
        $this->middleware('guest')->except(['handleProviderCallback','logout']);
    }


    protected function guard()
    {
        return Auth::guard();
    }

    public function showUserLoginForm(Request $request)
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

        // if(@$request->re_url){
        //     Session::put('redirect_uri', @$request->re_url);
        // }
        // if(@$request->re_url == null && url()->previous() != url('sign-up')){
        //     // dd(url('sign-up'));
        //     Session::put('redirect_uri', NULL);
        // }

        $data = [];
        if(Cookie::get('email') != null && Cookie::get('password') != null && Cookie::get('remember') != null) {
            $data['email'] = Cookie::get('email');
            $data['password'] = Cookie::get('password');
            $data['remember'] = Cookie::get('remember');
        }
        return view('auth.login')->with($data);
    }

    protected function credentials(Request $request)
    {
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password'), 'status'=>'A'];
          }
          return ['email' => $request->get('email'), 'password'=>$request->get('password'), 'status'=>'A',];
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())?: redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {


        $errors = [$this->username() => trans('auth.failed')];
        $user = \App\User::where($this->username(), $request->{$this->username()})
                            ->where('status', '!=', 'D')
                            ->first();

        // if ($user && \Hash::check($request->password, $user->password)) {
        //     $errors = [$this->username() => "Your email address is not verified yet. Please verify it to activate your account."];
        // }


        if ($user && Hash::check($request->password, $user->password) && $user->status == 'I') {
            $errors = [$this->username() => "Your Account is not Active."];
        }
        if ($user && Hash::check($request->password, $user->password) && $user->status == 'U') {
            $errors = [$this->username() => "Your Account is not Verified."];
        }
        if ($user && Hash::check($request->password, $user->password) && $user->is_mobile_verified == 'N') {
            $errors = [$this->username() => "Your mobile is not Verified."];
        }
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        // dd($errors);
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    protected function authenticated(Request $request, $user)
    {
        $user = Auth::user();
        $previous_url = Session::get('previous_url');
        //dd($previous_url);
        $lastUserID = Session::get('authID');
        $type = Session::get('type');
        //dd($type);
        if(@$type == 'LS'){
            Session::put('type', NULL);
            return redirect()->route('add.school.step1');
        }
        else if(@$user->school_id != 0){
          
            $schoolData = SchoolMaster::where('id',@$user->school_id)->first();
            User::where('id',@$user->id)->update(['school_id'=>0]);
            session(['school_id'=>null]);
            return redirect()->route('school.details',@$schoolData->slug);
               
        }
        else if(@$previous_url){
            Session::put('previous_url', NULL);
            // return redirect()->away($previous_url);
            // dd($previous_url);
             return Redirect::to($previous_url);

        }

        $redirect_uri = Session::get('redirect_uri');
        if($user->status == "A" && @$request->remember == 'on') {
            // check remember me cookie have or not
            // set remember me cookie
            $email_cookie = Cookie::queue('email', $request->email, 10080);
            $pass_cookie = Cookie::queue('password', $request->password, 10080);
            $remember_coockie = Cookie::queue('remember', $request->remember, 10080);
        }
        else {
            Cookie::queue(Cookie::forget('remember'));
            Cookie::queue(Cookie::forget('email'));
            Cookie::queue(Cookie::forget('password'));
        }

    }


    public function redirectToProvider()
    {
      
            $config = [
                'client_id' => env('GOOGLE_CLIENT_ID'),
                'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                'redirect' => route('login.social.callback'),
            ];

            $provider = Socialite::buildProvider(
                GoogleProvider::class,

                $config
            )->stateless();
        return $provider->redirect();
    }


    public function handleProviderCallback()
    {
        try {
            
                $config = [
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'redirect' => route('login.social.callback'),
                ];

                $provider = Socialite::buildProvider(
                    GoogleProvider::class,

                    $config
                )->stateless();
            
             $user = $provider->user();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong with social login');
            return redirect()->route('user.error.msg');
        }
        // dd($provider);

        // dd ($user);

        if(@$user->email==null){
            session()->flash('error', 'Email not added with this account');
            return redirect()->route('user.error.msg');
        }

         // dd ($user);
        $upd = [];
        $ins = [];
        // dd(session()->get('last_url'));
            $social_id_check = User::where('google_id', $user->id)->whereIn('status', ['U', 'A'])->first();
            $social_id_check_inactive= User::where('google_id', $user->id)->whereIn('status', ['I'])->first();
            if(@$social_id_check_inactive){
                session()->flash('error', 'Account Inactive please contact admin');
                return redirect()->route('user.error.msg');
            }
            if (@$social_id_check) {
                Auth::login($social_id_check);
                $previous_url = Session::get('previous_url');
                if(@$previous_url){
                    Session::put('previous_url', NULL);
                     return Redirect::to($previous_url);

                }else{

                    return redirect()->route('user.dashboard');
                }
              
            }
        

        // email check
        $user_check = User::where('email', @$user->email)->whereIn('status', ['U','A'] )->first();
        $user_check_inactive = User::where('email', @$user->email)->whereIn('status', ['I'] )->first();
        if(@$user_check_inactive){
            session()->flash('error', 'Account Inactive please contact admin');
            return redirect()->route('user.error.msg');
        }
        if (@$user_check) {
           
         
                $upd['google_id'] = $user->id;
                $upd['status'] = 'A';
                User::where('email', $user->email)->whereIn('status', ['U', 'A'])->update($upd);
                Auth::login($user_check);
                $previous_url = Session::get('previous_url');
                if(@$previous_url){
                    Session::put('previous_url', NULL);
                     return Redirect::to($previous_url);

                }else{

                    return redirect()->route('user.dashboard');
                }
        }
        $data['user']=$user;
        $full_name = explode(" ",$user->getName());
        if(array_key_exists(1,$full_name)){
            $data['user_data']['fname']  = $full_name[0];
            $data['user_data']['lname']  = $full_name[1];
        }
        return view('auth.social_login')->with($data);


    }

    public function socialRegistation(Request $request){
        $this->validate($request, [
            'g-recaptcha-response' => new Captcha(),  
            'first_name'  =>['required','max:30'],
            'last_name'   =>['required','max:30'], 
            'email'    => ['required', 'email',
                  Rule::unique('users')->ignore('D', 'status')
              ],
              //'password' => ['required'],          
          ]);

        //$ins['name']= @$request->social_user_name;
        $ins['first_name'] = @$request->first_name;
        $ins['last_name'] = @$request->last_name;
        $ins['email']=@$request->email;
        //$ins['password'] = Hash::make($request->password);
        $ins['status']='A';
        $ins['is_email_verified']='Y';
         $ins['google_id']=@$request->social_user_id;
         $ins['signup_from']='G';

        // return $ins;
        $user= User::create($ins);
        
        if($user){
          
            Auth::login($user);
            $previous_url = Session::get('previous_url');
            if(@$previous_url){
                Session::put('previous_url', NULL);
                 return Redirect::to($previous_url);

            }else{

                return redirect()->route('user.dashboard');
            }
        
        }
        return redirect()->route('home');
    }





    public function userUsernameCheck(Request $request)
    {

     $user = User::where([
                  'username' => trim($request->username)
                ])
                  ->where('status', '!=', 'D')
                  ->first();

      if(@$user) {
          return response('false');
      } else {
          return response('true');
      }
    }

     public function userMobileCheck(Request $request)
    {

     $user = User::where([
                  'whatsapp' => trim($request->mobile)
                ])
                  ->where('status', '!=', 'D')
                  ->first();

      if(@$user) {
          return response('false');
      } else {
          return response('true');
      }
    }


    protected function validateLogin(Request $request)
    {

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    public function username()
    {
        return 'email';
    }

    public function logout(Request $request)
    {
        $lastUserID = Auth::user() ? auth()->user()->id : '';
        $this->guard()->logout();
        $request->session()->invalidate();
        Session::put('authID', $lastUserID);
        $previous_url = url()->previous();
        if(@$previous_url != route('user.dashboard') && @$previous_url != route('user.profile') && @$previous_url != route('user.my.school')
         && @$previous_url != route('user.edit.school') && @$previous_url != route('user.message.list') && @$previous_url != route('user.my.review.by.me')
         && @$previous_url != route('user.subscription') && @$previous_url != route('payment.success') && @$previous_url != route('add.school.step1')){
            Session::put('previous_url', NULL);
            // return redirect()->away($previous_url);
            // dd($previous_url);
             return Redirect::to($previous_url);

        }else{

            return $this->loggedOut($request) ?: redirect('/');
        }
        
    }
}
