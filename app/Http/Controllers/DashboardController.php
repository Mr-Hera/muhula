<?php

namespace App\Http\Controllers;

use App\Models\SchoolReview;
use App\Models\School;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // DASHBOARD: LANDING PAGE
    public function dashboard(){
        $total_school = School::count();
        $total_reviews = SchoolReview::count();
        $unread_messages = Message::whereDoesntHave('reads', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->count();

        return view('dashboard.index')->with([
            'total_school' => $total_school,
            'total_reviews' => $total_reviews,
            'unread_messages' => $unread_messages,
        ]);
    }

    public function changePassword(){

        return view('modules.user.profile.change_password');
    }

    public function passwordUpdate(Request $request){

        $request->validate([
            'old_password'    => 'required|string',
            'new_password'    => 'required|string',
            'password_confirmation'   =>'required|string|same:new_password',
        ]);

        $id = Auth::user()->id;
        //dd($id);
        $password_check = User::where('id',$id)->first();

        $check = \Hash::check($request->old_password, $password_check->password);
        if(@$check)
        {
            $user = User::where('id',$id)->update([
            'password'      => \Hash::make($request->new_password),
            ]);
            return redirect()->back()->with('success','Password changed successfully.');
        }
        else
        {
            return redirect()->back()->with('error','Wrong current password');
        }
    }

    // DASHBOARD: EDIT-PROFILE PAGE
    public function profile(){
        // $data['user'] = Auth::user();
        return view('dashboard.edit_profile')->with([
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request){
       
        $this->validate($request, [
            'first_name' => ['required','max:30','regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['required','max:30','regex:/^[a-zA-Z\s]+$/'],
        ]);

        $upd = [];
        $user_id = Auth::user()->id;
        $user = User::where('id',$user_id)->first();
    
        $upd['first_name'] = $request->first_name;
        $upd['last_name'] = trim($request->last_name);
        //$upd['email'] = $request->email;
        $upd['mobile'] = $request->mobile;
        if (@$request->profile_picture != null) {
            // $image = $request->profile_picture;
            // $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs('public/userImage', $image, $filename);
            // $upd['profile_pic'] = $filename;
            // @unlink(storage_path('app/public/userImage/' . auth()->user()->profile_pic));

            $destinationPath = "storage/app/public/images/userImage/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['profile_pic'] = $img;
            @unlink(storage_path('app/public/images/userImage/' . @$user->profile_pic));
        }
        if (!empty($request->old_password) && !empty($user)) {
            if (\Hash::check($request->old_password, $user->password)) {
                $password = \Hash::make($request->new_password);
                $upd['password'] = $password;
                //User::where('id', $user->id)->update(['password' => $password]);
            }else {
                return redirect()->back()->with('error', 'Current password is wrong');
            }
        }

        $update =   User::where('id',$user->id)->update($upd);

        if($update){

                session()->flash('success','Profile updated successfully');
                return redirect()->back();
        }else{

                return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function profileImageDelete(){
        $user = User::where('id',Auth::user()->id)->first();
        
        @unlink(storage_path('app/public/images/userImage/' . @$user->profile_pic));
        $user->update(['profile_pic'=>null]);
        session()->flash('success','Profile picture deleted successfully');
        return redirect()->back();
    }

    public function updateEmail(Request $request)
    {    
        if(@$request->email){

            $this->validate($request, [
                'email' => ['required', 'string', 'email', 'max:200'
                ],             
            ]); 

            $input['temp_email']    = $request->email;
            $input['email_code']         = rand(10000,99999);
            User::where('id', Auth::User()->id)->update($input);
            $user = User::where('id', Auth::User()->id)->where('status', '!=', 'D')->first();

            $creates['link']        = route('user.email.update', [@$user->email_code,md5(@$user->id), 'type'=>'true']);
            $creates['name']        = $user->name;
            $creates['email']       = $user->temp_email;
            $creates['prevemail'] =$user->email;
            $creates['newemail']  =$user->temp_email;
            
            Mail::send(new ChangeEmailToPrevMail($creates));
            //Mail::send(new UserEmailVerifyMail($creates));

            return redirect()->back()->with('success', 'A verification link has been sent to your mail '.@$request->email.', Please verify email.');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }


      
    public function verifyEmail(Request $request, $vcode = null, $id = null)
    {
        $user = User::where('email_code', $vcode)->where(\DB::raw('MD5(id)'), $id)->first();
        //dd($user);
        if (@$user->email_code != null && (@$user->is_email_verified == 'N' || $request->type=='true')) 
        {   
            $update = [];
            $update['email_code'] = null;
            $update['status'] = 'A';
            if(@$request->type=="true"){
                $update['email'] = $user->temp_email;
                $update['temp_email'] = null;
            }
            $update['is_email_verified'] = 'Y';
            User::where('id', $user->id)->update($update);

            if(auth()->check()){
                return redirect()->route('user.profile')->with('success', 'Your email is verified successfully.');
            }
        } 
        else 
        {
            return redirect()->route('user.profile')->with('error', 'Your verification link has been expired.');
        }
    }

    public function userEmailCheck(Request $request)
    {

    $user = User::where('email', trim($request->email))->where('status', '!=', 'D')->first();
    if(@$user) {
        return response('false');
    } else {
        return response('true');
    }
    }

    public function userMobileCheck(Request $request){
        $user = User::where('mobile', trim($request->mobile))->where('id','!=',Auth::user()->id)->where('status', '!=', 'D')->first();

        if(@$user) {
            return response('false');
        } else {
            return response('true');
        }
    }

    public function passwordCheck(Request $request){
        $check_password = User::where('id',Auth::user()->id)->first();
        $check = Hash::check(@$request->current_password,@$check_password->password);

        if($check){
            return response('true');
        }else{
            return response('false');
        }
    }

    // DASHBOARD: MY_SCHOOL
    public function mySchool(){
        $user = Auth::user();
        $claimedSchools = $user->claimedSchools()
            ->with([
                'country',
                'county',
                'address',
                'contact.position',
                'curriculum',       // Curriculum relation
                'operationHours',    // Operation hours relation
                'type',
                'religion',          // Religion relation
                'population',
                'extendedSchoolServices',
                'facilities',
                'courses',
                'fees.level',
                'branches.county',   // County for each branch
                'branches.type',     // Type for each branch
                'branches.school'    // Parent school info
            ])
            ->get();

        return view('dashboard.my_school')->with([
        'claimedSchools' => $claimedSchools,
        ]);
    }
}
