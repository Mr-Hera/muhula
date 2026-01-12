<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\SignupUserMail;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class SocialAuthController extends Controller
{

    public function userEmailCheck(Request $request) {
        $exists = User::where('email', $request->email)
            ->where('id', '!=', auth()->id())
            ->exists();
        return $exists ? 'false' : 'true'; // IMPORTANT: must return "true" or "false"
    }

    public function checkPassword(Request $request) {
        return Hash::check($request->current_password, auth()->user()->password) 
        ? 'true' : 'false';
    }

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

        // Send welcome email (Markdown)
        try {
            Mail::to($user->email)->send(new SignupUserMail($user));
        } catch (Exception $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    public function updateProfile(Request $request) {
        // dd($request);
        $user = Auth::user();

        // Validate input
        $validated = $request->validate([
            'first_name' => 'required|string|max:30',
            'last_name'  => 'required|string|max:30',
            'mobile'     => 'nullable|string|min:10|max:13',
            'old_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|string', // base64 string
        ]);

        // Update basic info
        $user->first_name = $validated['first_name'];
        $user->last_name  = $validated['last_name'];
        $user->phone      = $validated['mobile'] ?? $user->phone;

        // Handle profile picture (base64 image string)
        if (!empty($validated['profile_picture'])) {
            $image = $validated['profile_picture'];
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $image);
            $imageData = base64_decode($image);

            $imageName = 'profile_' . time() . '.png';
            $path = 'public/images/userImage/' . $imageName;

            Storage::put($path, $imageData);

            // delete old image if exists
            if ($user->profile_image) {
                Storage::delete('public/images/userImage/' . $user->profile_image);
            }

            $user->profile_image = $imageName;
        }

        // Handle password change
        if (!empty($validated['old_password']) && !empty($validated['new_password'])) {
            if (!Hash::check($validated['old_password'], $user->password)) {
                return redirect()->back()->withErrors(['old_password' => 'Your current password is incorrect']);
            }

            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updateEmail(Request $request) {
        // ✅ Step 1: Validate inputs
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(), // must be unique except current user
            'current_password' => 'required',
        ]);

        $user = Auth::user();

        // ✅ Step 2: Verify the current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Your current password is incorrect.',
            ])->withInput();
        }

        // ✅ Step 3: Update the email
        $user->email = $validated['email'];
        $user->save();

        // ✅ Step 4: Redirect with success message
        return redirect()->back()->with('success', 'Your email has been updated successfully.');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate a password reset token
        $token = Password::createToken($user);

        // send email notification
        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

        return redirect()->back()->with('success','A password reset link has been sent to your email address.');
    }

    public function showResetForm($token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
            'id' => ['required'], // token comes as "id"
        ]);

        $token = $request->id;

        // Get the password reset record (no where('token') because token is hashed)
        $record = DB::table('password_reset_tokens')->latest('created_at')->first();

        if (! $record || ! Hash::check($token, $record->token)) {
            return back()->with('error', 'Invalid or expired password reset token.');
        }

        $user = User::where('email', $record->email)->first();

        if (! $user) {
            return back()->with('error', 'User account not found.');
        }

        // Update password
        $user->password = bcrypt($request->password);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $record->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please login.');
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
