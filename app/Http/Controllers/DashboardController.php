<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\School;
use App\Models\Message;
use App\Models\Favourite;
use App\Models\NewsArticle;
use Illuminate\Support\Str;
use App\Models\SchoolReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\ClaimApprovedUserMail;
use App\Mail\ClaimRejectedUserMail;
use App\Mail\ClaimApprovedAdminMail;
use App\Mail\ClaimRejectedAdminMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    // DASHBOARD: MANAGE-CLAIMS PAGE
    public function getManageClaims(){
        $claims = DB::table('school_user')
            ->join('users', 'school_user.user_id', '=', 'users.id')
            ->join('schools', 'school_user.school_id', '=', 'schools.id')
            ->leftJoin('contact_positions', 'school_user.contact_position_id', '=', 'contact_positions.id')
            ->select(
                'school_user.id as claim_id',
                'users.first_name',
                'users.last_name',
                'schools.name as school_name',
                'contact_positions.name as position_name',
                'school_user.claim_status'
            )
            ->get();

        return view('dashboard.manage_claims')->with([
            'user' => Auth::user(),
            'claims' => $claims
        ]);
    }

    public function updateClaimStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $pivot = DB::table('school_user')->where('id', $id)->first();

        if (! $pivot) {
            return redirect()->back()->with('error', 'Claim not found.');
        }

        // Update claim status
        DB::table('school_user')
            ->where('id', $id)
            ->update([
                'claim_status' => $request->status,
                'claimed_at' => now(),
            ]);

        // Fetch related user and school
        $user = User::find($pivot->user_id);
        $school = School::find($pivot->school_id);

        if (! $user || ! $school) {
            return redirect()->back()->with('error', 'Associated user or school not found.');
        }

        // Build URLs for mail buttons
        $viewSchoolUrl = route('school.details', ['slug' => $school->slug]);
        $dashboardUrl  = route('user.dashboard');

        // Send appropriate mail depending on status
        if ($request->status === 'approved') {
            // To user
            Mail::to($user->email)->send(
                new ClaimApprovedUserMail($user, $school, $viewSchoolUrl, $dashboardUrl)
            );

            // To admin
            Mail::to(config('mail.admin_address'))->send(
                new ClaimApprovedAdminMail($user, $school, $viewSchoolUrl, $dashboardUrl)
            );
        } elseif ($request->status === 'rejected') {
            // To user
            Mail::to($user->email)->send(
                new ClaimRejectedUserMail($user, $school, $dashboardUrl)
            );

            // To admin
            Mail::to(config('mail.admin_address'))->send(
                new ClaimRejectedAdminMail($user, $school, $dashboardUrl)
            );
        }

        return redirect()->back()->with('success', 'Claim status updated and notifications sent successfully!');
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

    // DASHBOARD: MY FAVOURITE
    public function myFavourite(){
        $user = Auth::user();
        // Fetch only favourite schools for the logged-in user
        $favourites = Favourite::where('user_id', $user->id)
            ->where('favouritable_type', School::class)
            ->with('favouritable.type') // eager load the related School
            ->orderBy('id', 'desc')
            ->paginate(10);                                             

        return view('dashboard.my_favourite')->with([
            'favourites' => $favourites,
        ]);
    }

    // DASHBOARD: ADD NEWS
    public function addNews(){
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
        return view('dashboard.add_news')->with([
        'claimedSchools' => $claimedSchools,
        ]);
    }

    public function createNewsSave(Request $request)
    {
        // 1️⃣ Validate request
        $validated = $request->validate([
            'news_title'   => 'required|string|max:255',
            'news_excerpt' => 'nullable|string|max:500',
            'description'  => 'required|string',
            'news_image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2️⃣ Prepare slug from title
        $slug = Str::slug($validated['news_title']);

        // 3️⃣ Handle cover image upload
        $coverImagePath = null;

        // stores to storage
        // if ($request->hasFile('news_image') && $request->file('news_image')->isValid()) {
        //     $file = $request->file('news_image');

        //     // Sanitize news title for filename
        //     $sanitizedTitle = Str::slug($validated['news_title'], '_');

        //     // Create unique filename: title_timestamp_random.ext
        //     $imageName = $sanitizedTitle . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        //     // Destination inside storage/app/public/images/news_covers
        //     $destination = storage_path('app/public/images/news_covers');
        //     $file->move($destination, $imageName);

        //     // Relative path for DB (like your school images)
        //     $coverImagePath = 'images/news_covers/' . $imageName;
        // }

        // stores to public folder
        if ($request->hasFile('news_image') && $request->file('news_image')->isValid()) {
            $file = $request->file('news_image');

            // Sanitize news title for filename
            $sanitizedTitle = Str::slug($validated['news_title'], '_');

            // Create unique filename: title_timestamp_random.ext
            $imageName = $sanitizedTitle . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Destination inside public/images/news_covers
            $destination = public_path('images/news_covers');

            // Ensure the directory exists
            if (!file_exists($destination)) {
                mkdir($destination, 0775, true);
            }

            // Move the uploaded file to the public directory
            $file->move($destination, $imageName);

            // Relative path for DB (relative to 'public' folder)
            $coverImagePath = 'images/news_covers/' . $imageName;
        }

        // 4️⃣ Insert into DB
        $article = NewsArticle::create([
            'title'        => $validated['news_title'],
            'slug'         => $slug,
            'excerpt'      => $validated['news_excerpt'] ?? null,
            'body'         => $validated['description'],
            'cover_image'  => $coverImagePath, // either null or path
            'author_id'    => Auth::id(), // current logged in user
            'published_at' => now(),
            'is_published' => true, // Or false if you want to draft first
        ]);

        // 5️⃣ Redirect with success
        return redirect()->back()->with('success', 'News article created successfully.');
    }

    public function myReviewsByMe(){

        $reviews = SchoolReview::with([
                'school.address',
                'school' => function ($q) {
                    $q->withAvg('reviews', 'rating'); // 👈 load average rating
                }
            ])
            ->where('user_id', Auth::id())
            ->orderBy('id','desc')
            ->paginate(10);

        return view('dashboard.my_review_by_me')->with([
            'reviews' => $reviews,
        ]);
    }

    public function myReviewsBySchool(){
        $user = Auth::user();

        // Get IDs of schools claimed by this user
        $claimedSchoolIds = $user->claimedSchools()->pluck('schools.id');

        // Fetch reviews for those claimed schools
        $reviews = SchoolReview::with([
                'school.country',
                'school.county',
                'school.address',
                'school.contact.position',
                'school.curriculum',
                'school.operationHours',
                'school.type',
                'school.religion',
                'school.population',
                'school.extendedSchoolServices',
                'school.facilities',
                'school.courses',
                'school.fees.level',
                'school.branches.county',
                'school.branches.type',
                'school.branches.school',
                'school' => function ($q) {
                    $q->withAvg('reviews', 'rating'); // 👈 load average rating
                }
            ])
            ->whereIn('school_id', $claimedSchoolIds)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('dashboard.my_review_by_school')->with([
            'reviews' => $reviews,
            'user' => $user,
        ]);
    }
}
