<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\County;
use App\Models\Course;
use App\Models\Review;
use App\Models\School;
use App\Models\Country;
use App\Models\Facility;
use App\Models\Religion;
use App\Models\Favourite;
use App\Models\SchoolFee;
use App\Models\Curriculum;
use App\Models\SchoolType;
use App\Models\SchoolImage;
use App\Models\SchoolLevel;
use Illuminate\Support\Str;
use App\Models\SchoolBranch;
use App\Models\SchoolCourse;
use App\Models\SchoolReview;
use Illuminate\Http\Request;
use App\Models\SchoolAddress;
use App\Models\SchoolContact;
use App\Models\SchoolUniform;
use App\Models\ContactPosition;
use App\Mail\ClaimSubmittedMail;
use App\Models\SchoolPopulation;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolOperationHour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ExtendedSchoolService;
use App\Models\SchoolExamPerformance;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Mail\UserSchoolAddedNotification;
use Illuminate\Support\Facades\Validator;
use App\Mail\AdminSchoolAddedNotification;
use App\Mail\AdminNewClaimNotificationMail;
use Illuminate\Validation\ValidationException;

class SchoolController extends Controller
{
  public function addSchoolStep1($id=null){
    $schoolDetails = School::where(DB::raw('id'),$id)->first();
    
    return view('listSchool.add_school_step1')->with([
      'school_details' => $schoolDetails,
    ]);
  }

  public function addSchoolStep1Save(Request $request){
    // dd($request);
    if($request->school_master_id != null){

    $upd = [];
    $upd['school_register'] = $request->school_register;
    $upd['school_same_address'] = $request->school_same_address?$request->school_same_address:null;
    $upd['no_of_school'] = $request->no_of_school?$request->no_of_school:null;

    SchoolMaster::where('id',$request->school_master_id)->update($upd);
    return redirect()->route('add.school.step2',[md5(@$request->school_master_id)]);

    }

    $ins = [];
    $ins['user_id'] = Auth::user()->id;
    $ins['school_register'] = $request->school_register;
    $ins['school_same_address'] = $request->school_same_address?$request->school_same_address:null;
    $ins['no_of_school'] = $request->no_of_school?$request->no_of_school:null;
    session(['school_register'=>$ins['school_register']]);
    session(['school_same_address'=>$ins['school_same_address']]);
    session(['no_of_school'=>$ins['no_of_school']]);
    //$create = SchoolMaster::create($ins);
    return redirect()->route('add.school.step2');
  }

  public function addSchoolStep2()
  {
    // Keep only the school_id in the session; clear any other remnants
    $schoolId = Session::get('school_creation.step2.school_id', null);

    // Reset the session but retain only the school_id (if exists)
    Session::forget('school_creation');
    Session::forget('school_slug');
    if ($schoolId) {
      Session::put('school_creation.step2.school_id', $schoolId);
    }

    // Fetch static lists
    $countries = Country::all();
    $counties = County::all();

    // Fetch school details only if we have a valid ID
    $schoolDetails = null;
    if ($schoolId) {
      $schoolDetails = School::with(['contact', 'address'])->find($schoolId);
    }

    // Prepare data for the view
    $data = [
      'countries' => $countries,
      'counties'  => $counties,
      'schoolDetails' => $schoolDetails,
    ];

    return view('listSchool.add_school_step2', $data);
  }

  public function addSchoolStep2Save(Request $request)
  {
    $validated = $request->validate([
      'school_name'      => 'required|string|max:255',
      'about_school'     => 'required|string|max:5000',
      'contact_title'    => 'required|array|min:1',
      'contact_title.*'  => 'required|string|max:255',
      'contact_email'    => 'required|array|min:1',
      'contact_email.*'  => 'required|email|max:255',
      'contact_phone'    => 'required|array|min:1',
      'contact_phone.*'  => 'required|string|max:20',
      'country'          => 'required|integer|exists:countries,id',
      'county'           => 'nullable|integer',
      'new_county_name'  => 'nullable|string|max:255',
      'full_address'     => 'required|string|max:500',
      'google_location'  => 'nullable|string|max:500',
    ], [], [
      'school_name'      => 'School name',
      'about_school'     => 'About the school',
      'contact_title.*'  => 'Contact full name',
      'contact_email.*'  => 'Contact email',
      'contact_phone.*'  => 'Contact phone',
      'country'          => 'Country',
      'county'           => 'Town',
      'new_county_name'  => 'New town name',
      'full_address'     => 'Full address',
      'google_location'  => 'Google map link',
    ]);

    $county_id = null;

    // ✅ If user selected "Other", create a new county first
    if ((int) $validated['county'] === 0) {
      if (empty($validated['new_county_name'])) {
        return back()->withErrors(['new_county_name' => 'Please enter a town name when selecting "Other".'])->withInput();
      }

      $new_county = County::create([
        'name' => $validated['new_county_name'],
      ]);
      $county_id = $new_county->id;
    } else {
      $county_id = $validated['county'];
    }

    DB::beginTransaction();

    try {
      // 1. Save school_contact
      $schoolContact = new SchoolContact();
      $schoolContact->full_names = $validated['contact_title'][0];
      $schoolContact->email = $validated['contact_email'][0];
      $schoolContact->phone_no = $validated['contact_phone'][0];
      $schoolContact->save();

      // Split names for user creation
      $names = explode(' ', trim($schoolContact->full_names));
      $firstName = $names[0] ?? '';
      $lastName  = $names[1] ?? '';

      // 2. Add contact as user (reuse logged-in user if same email)
      $existingUser = User::where('email', $schoolContact->email)->first();

      if ($existingUser) {
        // If the contact email matches the currently logged-in user, reuse it
        $school_contact_user = $existingUser;

        // Optionally update their phone number if missing or outdated
        if (empty($school_contact_user->phone)) {
          $school_contact_user->phone = $schoolContact->phone_no;
          $school_contact_user->save();
        }
      } else {
        // Otherwise, create a new user record for the school contact
        $school_contact_user = new User();
        $school_contact_user->first_name = $firstName;
        $school_contact_user->last_name = $lastName;
        $school_contact_user->email = $schoolContact->email;
        $school_contact_user->phone = $schoolContact->phone_no;
        $school_contact_user->password = Hash::make(env('SECURE_APP_PASSWORD'));
        $school_contact_user->save();
      }

      // 3. Save school_address
      $schoolAddress = new SchoolAddress();
      $schoolAddress->address_text = $validated['full_address'] ?? null;
      $schoolAddress->google_maps_link = $validated['google_location'] ?? null;
      $schoolAddress->save();

      // 4. Save school record
      $school = new School();
      $school->name = $validated['school_name'];
      $school->description = $validated['about_school'];
      $school->slug = Str::slug($validated['school_name'] . '-' . Str::random(5));
      $school->county_id = $county_id;
      $school->country_id = $validated['country'];
      $school->school_contact_id = $schoolContact->id;
      $school->school_address_id = $schoolAddress->id;
      $school->save();

      DB::commit();

      // ✅ Store only school_id in session
      Session::forget('school_creation');
      Session::put('school_creation.step2.school_id', $school->id);

      return redirect()->route('add.school.step3');

    } catch (\Exception $e) {
      DB::rollBack();
      return back()->withErrors(['error' => 'Failed to save school step 2: ' . $e->getMessage()]);
    }
  }

  public function addSchoolStep3(){
    $school_levels = SchoolLevel::all();
    $school_types_day = SchoolType::where('name', 'Day')->first();
    $school_types_boarding = SchoolType::where('name', 'Boarding')->first();
    $school_types_day_n_boarding = SchoolType::where('name', 'Day & Boarding')->first();
    $school_curricula = Curriculum::all();
    $school_uniforms = SchoolUniform::all();
    $school_contact_positions = ContactPosition::all();
    $school_religion = Religion::all();
    $facilities = Facility::all();
    
    return view('listSchool.add_school_step3')->with([
      'school_levels' => $school_levels,
      'school_types_day' => $school_types_day,
      'school_types_boarding' => $school_types_boarding,
      'school_types_day_n_boarding' => $school_types_day_n_boarding,
      'school_curricula' => $school_curricula,
      'school_uniform' => $school_uniforms,
      'school_contact_positions' => $school_contact_positions,
      'school_religion' => $school_religion,
      'facilities' => $facilities,
    ]);
  }

  public function addSchoolStep3Save(Request $request)
  {
    // dd($request);
    $validated = $request->validate([
      'ownership_type'         => 'required|string|in:Private,Public',
      'year_of_establishment'  => 'required|digits:4|integer|min:1900|max:' . now()->year,

      'school_level_id'        => 'required|array|min:1',
      'school_level_id.*'      => 'required|integer|exists:school_levels,id',

      'curricula'              => 'required|array|min:1',
      'curricula.*'            => 'required|string|max:255',

      'gender'                 => 'required|string|in:Mixed,Male,Female',

      'school_type_id'         => 'required|integer|exists:school_types,id',

      'contact_relationship_id'=> 'required|integer|exists:contact_positions,id',
      'other_relationship'     => 'nullable|string|max:255',

      'religion_id'            => 'required|integer|exists:religions,id',

      'facilities'             => 'required|array|min:1',
      'facilities.*'           => 'required|integer|exists:facilities,id',

      'other_facilities'       => 'nullable|string|max:255',

      'school_logo'            => 'nullable|image|mimes:jpeg,png,gif,jpg|max:2048', // 2MB max
    ]);

    $schoolId = Session::get('school_creation.step2.school_id');
    $currentSchoolInput = School::where('id', $schoolId)->first();
    // dd($currentSchoolInput->name);

    if (!$schoolId) {
      // dd('Previous school data not found');
      return back()->withErrors(['error' => 'Previous school data not found. Please restart the form.']);
    }

    // ✅ Fetch contact ID directly from the school record instead of session
    $contactId = $currentSchoolInput->school_contact_id;

    DB::beginTransaction();

    try {
      $school = School::findOrFail($schoolId);
      // dd($school);

      // Handle file upload
      $schoolLogoPath = "";

      // ✅ Updated: Save logo directly to "public/images/school_logo"
      if ($request->hasFile('school_logo')) {
        $image = $request->file('school_logo');

        // Sanitize school name -> lowercase, underscores instead of spaces, remove invalid chars
        $sanitizedName = Str::slug($currentSchoolInput->name, '_');
        $imageName = $sanitizedName . '_logo.' . $image->getClientOriginalExtension();

        // Save directly to public/images/school_logo
        $destination = public_path('images/school_logo');

        // Ensure directory exists
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move the file
        $image->move($destination, $imageName);

        $schoolLogoPath = 'images/school_logo/' . $imageName;
      }

      // save to storage also
      // if ($request->hasFile('school_logo')) {
      //   $image = $request->file('school_logo');

      //   // Sanitize school name -> lowercase, underscores instead of spaces, remove invalid chars
      //   $sanitizedName = Str::slug($currentSchoolInput->name, '_');

      //   $imageName = $sanitizedName . '_logo.' . $image->getClientOriginalExtension();

      //   $destination = storage_path('app/public/images/school_logo');
      //   $image->move($destination, $imageName);

      //   $schoolLogoPath = 'images/school_logo/' . $imageName;
      // }

      // Assuming one curriculum ID is picked (if not, you'll need a pivot table)
      // Also assuming first item from arrays is used for singular fields in the schools table
      $curriculumName = $request['curricula'][0];
      $curriculum = Curriculum::firstOrCreate(['name' => $curriculumName]);

      // manually updated school level if curriculum is 'Montessori'
      if($curriculum->name == "Montessori") {
        $updated_montessori_school_level = SchoolLevel::where('name', 'Nursery')->first();
        $request['school_level_id'] = $updated_montessori_school_level->id;
      }

      $school->update([
          'ownership'             => $request['ownership_type'] ?? null,
          'year_of_establishment' => $request['year_of_establishment'] ?? null,
          'school_level_id'       => $request['school_level_id'][0] ?? null, // using first level
          'curriculum_id'         => $curriculum->id ?? null,
          'gender_admission'      => $request['gender'] ?? null,
          'school_type_id'        => $request['school_type_id'] ?? null,
          'religion_id'           => $request['religion_id'] ?? null,
          'logo'                  => $schoolLogoPath ?? null,
      ]);

      // Optional: attach multiple levels/facilities if relationships exist
      // if (method_exists($school, 'schoolLevels')) {
      //     $school->schoolLevels()->sync($request['school_level_id']);
      // }

      if ($request->filled('facilities') && method_exists($school, 'facilities')) {
        $school->facilities()->sync($request['facilities']); // sync accepts array of IDs
      }

      $schoolContact = SchoolContact::firstOrCreate(['id' => $contactId]);
      $schoolContact->update([
        'contact_position_id' => $request['contact_relationship_id'],
      ]);

      DB::commit();

      // ✅ Save only school_id to session for step tracking
      Session::put('school_creation.step2.school_id', $school->id);

      return redirect()->route('add.school.step4');

    } catch (\Exception $e) {
      // dd($e);
      DB::rollBack();
      return back()->withErrors(['error' => 'Failed to save school step 3: ' . $e->getMessage()]);
    }
  }


  public function addSchoolStep3UniformSave(Request $request){
    // dd($request);
    $validated = $request->validate([
      'uniform_type' => 'required|in:Male,Female,Mixed',
      'uniform_title' => 'nullable|string|max:255',
      'uniform_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Map uniform_type to gender shorthand
    $genderMap = [
        'Male' => 'M',
        'Female' => 'F',
        'Mixed' => 'U',
    ];

    $gender = $genderMap[$request->uniform_type];

    // Store image
    $image = $request->file('uniform_image');
    $imageName = time() . '_' . $image->getClientOriginalName();

    $imagePath = $image->storeAs('images/uniform_image', $imageName, 'public');

    // Save to database
    $uniform = new SchoolUniform();
    $uniform->gender = $gender;
    $uniform->name = $request->uniform_title ?? '';
    $uniform->image = $imageName;
    $uniform->save();

    return redirect()->back()->with('success', 'Uniform added successfully!');
  }

  public function schoolUniformDelete($id=null){

    $uniform = SchoolUniform::where('id',@$id)->first();
    if(@$uniform == null){

     return redirect()->back()->with('error','Something went wrong');
    }

    $uniform->delete();
    return redirect()->route('add.school.step3'); 
  }

  public function addSchoolStep4()
  {
    $extended_school_services = ExtendedSchoolService::all();
    $schoolId = Session::get('school_creation.step2.school_id');
    $school   = School::findOrFail($schoolId);
    // dd($school);

    // Prefer DB values, fallback to session
    $operationHours = $school->operationHours()->get()->toArray();
    if (empty($operationHours)) {
      $operationHours = []; // No longer fetching from session, rely only on DB
    }

    // Try to get school details from session if exists
    $schoolDetails = null;
    if ($schoolId) {
      $schoolDetails = School::with(['contact', 'address'])->find($schoolId);
    }

    // ✅ Fetch extended services directly from DB (assuming pivot relation)
    // If your pivot table is named 'extended_school_service_school' or similar,
    // ensure that your School model has a relationship like:
    // public function extendedServices() { return $this->belongsToMany(ExtendedSchoolService::class); }
    $schoolExtendedServices = [];
    if (method_exists($school, 'extendedSchoolServices')) {
      $schoolExtendedServices = $school->extendedSchoolServices()->pluck('extended_school_services.id')->toArray();
    }

    // ✅ Fetch school population directly from DB
    $schoolPopulation = SchoolPopulation::where('school_id', $schoolId)->first();

    // ✅ Provide safe defaults if no record exists
    if (!$schoolPopulation) {
      $schoolPopulation = [
        'total_students'  => null,
        'student_boys'    => null,
        'student_girls'   => null,
        'total_teachers'  => null,
        'teacher_male'    => null,
        'teacher_female'  => null,
      ];
    } else {
      // Convert to array for direct Blade access
      $schoolPopulation = [
        'total_students'  => $schoolPopulation->total_students,
        'student_boys'    => $schoolPopulation->male_students,
        'student_girls'   => $schoolPopulation->female_students,
        'total_teachers'  => $schoolPopulation->total_teachers,
        'teacher_male'    => $schoolPopulation->male_teachers,
        'teacher_female'  => $schoolPopulation->female_teachers,
      ];
    }

    return view('listSchool.add_school_step4')->with([
      'extended_school_services' => $extended_school_services,
      'extended_services'        => $schoolExtendedServices, // replaced session with DB data
      'school_population'        => $schoolPopulation,       // replaced session with DB data
      'operation_hours'          => $operationHours,
      'schoolDetails'            => $schoolDetails,
    ]);
  }

  public function addSchoolStep4RatioSave(Request $request)
  {
    // dd($request);
    // Validate the request
    $validated = $request->validate([
      'total_students'   => 'required|integer|min:0',
      'student_boys'     => 'required|integer|min:0',
      'student_girls'    => 'required|integer|min:0',
      'total_teachers'   => 'required|integer|min:0',
      'teacher_male'     => 'required|integer|min:0',
      'teacher_female'   => 'required|integer|min:0',
    ]);

    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::findOrFail($schoolId);

    // Optional: You can check consistency like so
    if ($validated['total_students'] != ($validated['student_boys'] + $validated['student_girls'])) {
      return back()->withErrors(['total_students' => 'Sum of boys and girls must equal total students']);
    }

    if ($validated['total_teachers'] != ($validated['teacher_male'] + $validated['teacher_female'])) {
      return back()->withErrors(['total_teachers' => 'Sum of male and female teachers must equal total teachers']);
    }

    // Create or update the school population
    $school->population()->updateOrCreate(
      ['year' => now()->year], // Assuming you want one record per year
      [
        'total_students'  => $validated['total_students'],
        'total_teachers'  => $validated['total_teachers'],
        'male_students'   => $validated['student_boys'],
        'female_students' => $validated['student_girls'],
        'male_teachers'   => $validated['teacher_male'],
        'female_teachers' => $validated['teacher_female'],
      ]
    );

    // ✅ We no longer store population or extended services in session.
    // Only school_id remains in session.

    session()->flash('success', 'School population data saved successfully.');

    // ✅ Fetch latest data directly from DB
    $schoolPopulation = SchoolPopulation::where('school_id', $schoolId)->get();

    // ✅ Fetch extended services from DB (assuming belongsToMany relation)
    $extendedServices = [];
    if (method_exists($school, 'extendedSchoolServices')) {
      $extendedServices = $school->extendedSchoolServices()->pluck('extended_school_services.id')->toArray();
    }

    return redirect()->back()->with('success', 'School population saved successfully.')->with([
      'school_population' => $schoolPopulation,
      'extended_services' => $extendedServices,
    ]);
  }

  public function addSchoolStep4RulesSave(Request $request)
  {
    // dd($request);
    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::findOrFail($schoolId);
    
    // 1. Attach extended services to pivot table via many-to-many
    $extendedServiceIds = $request->input('extended_school_services_id', []);
    if (!empty($extendedServiceIds)) {
      $school->extendedSchoolServices()->sync($extendedServiceIds);
    }

    // 2. Insert operation hours via hasMany
    $operationHours = [
      [
        'period_of_day' => 'Day',
        'starts_at'     => $request->input('day_learn_period_from'),
        'ends_at'       => $request->input('day_learn_period_until'),
      ],
      [
        'period_of_day' => 'Evening',
        'starts_at'     => $request->input('evening_studies_from'),
        'ends_at'       => $request->input('evening_studies_until'),
      ],
    ];

    foreach ($operationHours as $data) {
      $school->operationHours()->updateOrCreate(
        ['period_of_day' => $data['period_of_day']], // match by period
        $data // update values
      );
    }
    // dd("operation hours added!");

    // ✅ We no longer store extended services or operation hours in session.
    // Only the school_id remains in session.

    // Flash success and redirect
    session()->flash('success', 'School services updated successfully');

    // ✅ Fetch data directly from DB instead of session
    $extendedServices = [];
    if (method_exists($school, 'extendedSchoolServices')) {
      $extendedServices = $school->extendedSchoolServices()->pluck('extended_school_services.id')->toArray();
    }

    return redirect()->route('add.school.step4')->with([
      'extended_services' => $extendedServices, // pulled fresh from DB
    ]);
  }

  public function addSchoolStep5($id=null){
    // Try to get school details from session if exists
    $schoolDetails = null;
    if (Session::has('school_creation.step2.school_id')) {
      $schoolId = Session::get('school_creation.step2.school_id');
      $schoolDetails = School::with(['contact', 'address'])->find($schoolId);
    }

    return view('listSchool.add_school_step5')->with([
      'schoolDetails'  => $schoolDetails,
    ]);
  }

  public function addSchoolStep5Save(Request $request){
    // dd($request);
    $request->validate([
        'school_image'   => 'required|array', 
        'school_image.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
        'school_image.required'   => 'Please upload at least one image.',
        'school_image.*.image'    => 'Each file must be a valid image.',
        'school_image.*.mimes'    => 'Only jpeg, png, jpg, gif, and webp formats are allowed.',
        'school_image.*.max'      => 'Each image must not exceed 2MB.',
    ]);

    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::findOrFail($schoolId);

    // saving to storage
    // if ($request->hasFile('school_image')) {
    //   foreach ($request->file('school_image') as $uploadedImage) {
    //     if ($uploadedImage->isValid()) {
    //       // Sanitize school name
    //       $sanitizedName = Str::slug($school->name, '_');

    //       // Create a unique name (e.g. schoolName_timestamp_random.ext)
    //       $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

    //       // Destination inside storage/app/public/images/school_images
    //       $destination = storage_path('app/public/images/school_images');
    //       $uploadedImage->move($destination, $imageName);

    //       // Relative path for DB (matches your logo method)
    //       $path = 'images/school_images/' . $imageName;

    //       // Save to DB
    //       $school->images()->create([
    //         'image_path' => $path,
    //         'caption'    => $school->name, // Keep original name for caption
    //       ]);
    //     }
    //   }
    // }

    // saving directly to public
    if ($request->hasFile('school_image')) {
      foreach ($request->file('school_image') as $uploadedImage) {
        if ($uploadedImage->isValid()) {
          // Sanitize school name
          $sanitizedName = Str::slug($school->name, '_');

          // Create a unique name (e.g. schoolName_timestamp_random.ext)
          $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

          // ✅ Destination inside public/images/school_images
          $destination = public_path('images/school_images');

          // ✅ Create directory if it doesn’t exist
          if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
          }

          // ✅ Move the uploaded file to the public folder
          $uploadedImage->move($destination, $imageName);

          // ✅ Relative path for DB (still matches how you display it)
          $path = 'images/school_images/' . $imageName;

          // Save to DB
          $school->images()->create([
            'image_path' => $path,
            'caption'    => $school->name, // Keep original name for caption
          ]);
        }
      }
    }

    // Redirect or proceed to next step
    return redirect()->route('add.school.step6')->with('success', 'Images uploaded successfully.');
  }


  public function addSchoolStep6()
  {
    $schoolId = Session::get('school_creation.step2.school_id');

    if (!$schoolId) {
      return redirect()->route('add.school.step2')
        ->withErrors(['error' => 'School not found. Please restart the process.']);
    }

    $school = School::with(['curriculum', 'schoolLevel'])->findOrFail($schoolId);

    // If your school has multiple levels or curricula, adjust to use whereIn
    $courses = Course::query()
      ->when($school->curriculum_id, function ($query) use ($school) {
        $query->where('curriculum_id', $school->curriculum_id);
      })
      ->when($school->school_level_id, function ($query) use ($school) {
        $query->where('school_level_id', $school->school_level_id);
      })
      ->orderBy('name')
      ->get();

    // ✅ Fetch selected courses directly from DB instead of session
    $selectedCourses = SchoolCourse::where('school_id', $schoolId)
        ->pluck('course_id')
        ->toArray();

    return view('listSchool.add_school_step6')->with([
      'school'          => $school,
      'courses'         => $courses,
      'selectedCourses' => $selectedCourses,
    ]);
  }

  public function addSchoolStep6SubjectSave(Request $request)
  {
    $request->validate([
      'courses' => 'required|array|min:1',
      'courses.*' => 'string|max:255',
    ]);

    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::findOrFail($schoolId);
    
    $courseNames = $request->input('courses', []);
    $courseIds = [];
    $courseDataList = [];
    
    foreach ($courseNames as $courseId) {
      $course = Course::firstOrCreate(['id' => $courseId]);
      $courseIds[] = $course->id;
      $courseDataList[] = [
        'id' => $course->id,
        'name' => $course->name,
      ];
    }
    
    // Attach or sync courses to the pivot table
    $school->courses()->sync($courseIds);
    
    // ✅ No longer store anything except school_id in session
    // Session::put('school_creation.extended_services.step6.courses', $courseNames);
    // Session::put('school_creation.courses.step6.course_data', $courseDataList);
    
    return redirect()->route('add.school.step7')->with('success', 'Courses saved successfully.');
  }

  public function schoolSubjectDelete($id=null){
    // Get school ID from session
    $schoolId = Session::get('school_creation.step2.school_id');

    if (!$schoolId) {
      return redirect()->back()->with('error', 'School context missing. Please restart the process.');
    }

    // Find the school
    $school = School::find($schoolId);

    if (!$school) {
        return redirect()->back()->with('error', 'School not found.');
    }

    // Detach the course from the pivot table only
    $school->courses()->detach($id);

    return redirect()->back()->with('success', 'Subject removed from school successfully.');
  }

  public function addSchoolStep7()
  {
    $schoolId = Session::get('school_creation.step2.school_id');

    // Fetch exam performance records directly from the database
    $examPerformanceRecords = SchoolExamPerformance::where('school_id', $schoolId)
        ->latest()
        ->get();

    return view('listSchool.add_school_step7')->with([
      'examPerformanceRecords' => $examPerformanceRecords,
    ]);
  }

  public function addSchoolStep7Save(Request $request){
    // dd($request);
    $request->validate([
      'exam' => 'required|string|max:255',
      'ranking_position' => 'nullable|integer',
      'region' => 'nullable|string|max:255',
      'mean_score_point' => 'nullable|numeric',
      'mean_grade' => 'nullable|string|max:10',
      'no_of_candidate' => 'nullable|integer',
    ]);
    try {
      // dd("Here");

      $schoolId = Session::get('school_creation.step2.school_id');
      // dd($schoolId);

      if (!$schoolId || !School::find($schoolId)) {
        return redirect()->back()->with('error', 'School ID is missing or invalid.');
      }

      $examPerformance = SchoolExamPerformance::create([
        'school_id' => $schoolId,
        'exam' => $request->input('exam'),
        'ranking_position' => $request->input('ranking_position'),
        'region' => $request->input('region'),
        'mean_score_points' => $request->input('mean_score_point'),
        'mean_grade' => $request->input('mean_grade'),
        'number_of_candidates' => $request->input('no_of_candidate'),
      ]);

      return redirect()->back()->with('success', 'Exam performance data saved successfully.');
    } catch (\Throwable $e) {
      // dd($e);
      Log::error('Error saving school exam performance: '.$e->getMessage(), [
        'trace' => $e->getTraceAsString(),
        'request' => $request->all(),
      ]);

      return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
    }
  }

  public function addSchoolStep8($branchId = null){
    $schoolId = Session::get('school_creation.step2.school_id');
    $school_branches = SchoolBranch::where('school_id', $schoolId)->get();
    $countries = Country::all();
    $counties = County::all();
    $school_levels = SchoolLevel::all();

    // If editing, load branch details, else null
    $schoolBranchDetails = null;
    if ($branchId) {
        $schoolBranchDetails = SchoolBranch::find($branchId);
    }
    
    return view('listSchool.add_school_step8')->with([
      'school_branches' => $school_branches,
      'countries' => $countries,
      'counties' => $counties,
      'school_levels' => $school_levels,
      'schoolBranchDetails' => $schoolBranchDetails,
    ]);
  }

  public function addSchoolStep8Save(Request $request)
  {
    // Step 1: Validate request
    $validated = $request->validate([
      'school_name'    => 'nullable|string|max:255',
      'school_type'    => 'nullable|array',
      'school_type.*'  => 'exists:school_types,id',
      'country'        => 'nullable|exists:countries,id',
      'town'           => 'nullable|exists:counties,id',
      'full_address'   => 'nullable|string|max:255',
      'google_location'=> 'nullable|string',
      'google_lat'     => 'nullable|numeric',
      'google_long'    => 'nullable|numeric',
      'email'          => 'nullable|email',
      'phone'          => 'nullable|string|max:20',
      'school_image'     => 'nullable|array',
      'school_image.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ], [
      'school_name.nullable'   => 'The school name is required.',
      'school_type.nullable'   => 'Please select at least one school type.',
      'country.nullable'       => 'Please select a country.',
      'town.nullable'          => 'Please select a town.',
    ]);

    // Step 2: Check if *any* relevant data has been passed
    $hasData = collect($validated)->filter(function ($value) {
      return !is_null($value) && $value !== '' && $value !== [];
    })->isNotEmpty();

    if ($hasData) {
      $schoolId = Session::get('school_creation.step2.school_id');
      $school   = School::findOrFail($schoolId);

      // Save school_address
      $schoolAddress = new SchoolAddress();
      $schoolAddress->address_text = $validated['full_address'] ?? null;
      $schoolAddress->google_maps_link = $validated['google_location'] ?? null;
      $schoolAddress->save();

      // Create branch
      $branch = new SchoolBranch();
      $branch->name = $validated['school_name'] ?? null;
      $branch->school_id = $schoolId;
      $branch->school_type_id = $validated['school_type'][0] ?? null;
      $branch->county_id = $validated['town'] ?? null;
      $branch->school_address_id = $schoolAddress->id;
      $branch->school_image_id = 1;
      $branch->email = $validated['email'] ?? null;
      $branch->phone_no = $validated['phone'] ?? null;
      $branch->save();

      // 🔹 Handle school images (multiple uploads to public folder)
      if ($request->hasFile('school_image')) {
        foreach ($request->file('school_image') as $uploadedImage) {
          if ($uploadedImage->isValid()) {
            // Sanitize school name
            $sanitizedName = Str::slug($school->name ?? 'school', '_');

            // Create a unique filename
            $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

            // ✅ Destination inside *public/images/school_images* instead of storage
            $destination = public_path('images/school_images');
            if (!file_exists($destination)) {
              mkdir($destination, 0777, true);
            }

            // Move image to public folder
            $uploadedImage->move($destination, $imageName);

            // Relative path for DB (accessible publicly)
            $path = 'images/school_images/' . $imageName;

            // Save to DB (assuming School has images() relation -> hasMany(SchoolImage::class))
            $image = $school->images()->create([
              'image_path' => $path,
              'caption'    => $school->name ?? 'School Image',
            ]);

            // Optionally set the *first uploaded image* as branch->school_image_id
            if (!$branch->school_image_id) {
              $branch->school_image_id = $image->id;
              $branch->save();
            }
          }
        }
      }

      // 🔹 Handle school images (multiple uploads to storage folder)
      if ($request->hasFile('school_image')) {
        foreach ($request->file('school_image') as $uploadedImage) {
          if ($uploadedImage->isValid()) {
            // Sanitize school name
            $sanitizedName = Str::slug($school->name ?? 'school', '_');

            // Create a unique filename
            $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

            // Destination inside storage/app/public/images/school_images
            $destination = storage_path('app/public/images/school_images');
            if (!file_exists($destination)) {
              mkdir($destination, 0777, true);
            }
            $uploadedImage->move($destination, $imageName);

            // Relative path for DB (accessible via storage:link)
            $path = 'images/school_images/' . $imageName;

            // Save to DB (assuming School has images() relation -> hasMany(SchoolImage::class))
            $image = $school->images()->create([
              'image_path' => $path,
              'caption'    => $school->name ?? 'School Image',
            ]);

            // Optionally set the *first uploaded image* as branch->school_image_id
            if (!$branch->school_image_id) {
              $branch->school_image_id = $image->id;
              $branch->save();
            }
          }
        }
      }
    }

    // Step 3: Always redirect
    return redirect()->route('add.school.step9')->with('success', 'School branch created successfully.');
  }

  public function schoolBranchImageDelete($id=null){

    $school_image = SchoolGallery::where('id',@$id)->first();
    if($school_image){

      @unlink(storage_path('app/public/images/school_image/' . @$school_image->image));
      $school_image->delete();

      return redirect()->back();
    }else{

        return redirect()->back()->with('error','Something went wrong');
    }

  }

     
  public function schoolImageDelete($id=null)
  {
    $school_image = SchoolGallery::where('id',@$id)->first();
    if($school_image){

        @unlink(storage_path('app/public/images/school_image/' . @$school_image->image));
        $school_image->delete();

        return redirect()->back();
    }else{

        return redirect()->back()->with('error','Something went wrong');
    }
  }

  public function addSchoolStep9(){
    $schoolId = Session::get('school_creation.step2.school_id');
    $school_levels = SchoolLevel::all();

    // Fetch all fees for the current school
    $school_fees = SchoolFee::with('level')
        ->where('school_id', $schoolId)
        ->get();

    return view('listSchool.add_school_step9')->with([
      'school_levels' => $school_levels,
      'school_fees' => $school_fees,
    ]);
  }

  public function addSchoolStep9FeesSave(Request $request){
    // Validate the input
    $validated = $request->validate([
      'grade_level' => 'required|exists:school_levels,id',
      'min_amount' => 'required|numeric|min:0',
      'max_amount' => 'required|numeric|gte:min_amount',
    ], [
        'grade_level.required' => 'Please select a grade level.',
        'grade_level.exists'   => 'The selected grade level is invalid.',
        'min_amount.required'  => 'Please enter a minimum fee.',
        'min_amount.numeric'   => 'Minimum fee must be a number.',
        'max_amount.required'  => 'Please enter a maximum fee.',
        'max_amount.numeric'   => 'Maximum fee must be a number.',
        'max_amount.gte'       => 'Maximum fee must be greater than or equal to minimum fee.',
    ]);
    
    // Get the school_id from session
    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::find($schoolId);

    // Create the school fee record
    $school_fee_record = SchoolFee::create([
      'school_id' => $schoolId,
      'level_id' => $validated['grade_level'],
      'min_amount' => $validated['min_amount'],
      'max_amount' => $validated['max_amount'],
      'currency' => 'KES', // You can dynamically pass this if needed
    ]);
    Session::put(['school_slug' => $school->slug]);

    return redirect()->route('add.school.step9')->with('success', 'Fee added successfully.');
  }

  public function addSchoolStep9Complete()
  {
    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::find($schoolId);

    if (!$school) {
      return redirect()->back()->with('error', 'School record not found.');
    }

    // Send emails
    try {
      // Notify Admin
      $adminEmail = config('mail.admin_address');
      Mail::to($adminEmail)->send(new AdminSchoolAddedNotification($school));

      // Notify User
      $user = auth()->user();
      if ($user && $user->email) {
        Mail::to($user->email)->send(new UserSchoolAddedNotification($school));
      }
    } catch (Exception $e) {
      Log::error('Failed to send notification emails: '.$e->getMessage());
    }

    return redirect()->route('add.school.success')->with('success', 'School listing added successfully.')->with([
      'school_name' => $school->name,
      'school_slug' => $school->slug,
    ]);
  }

  public function addSchoolSuccessPage()
  {
    $school_slug = session()->get('school_slug');

    // Clear everything under "school_creation.*"
    Session::forget('school_creation');

    return view('listSchool.add_school_success_page')->with([
      'school_slug' => $school_slug,
    ]);
  }

    
  public function schoolFeesDelete($id = null)
  {
    // dd($id);
    // Try to find the record
    $schoolFee = SchoolFee::find($id);

    // If not found, return with an error message
    if (!$schoolFee) {
      return redirect()->back()->with('error', 'Something went wrong. Record not found.');
    }

    // Store the school ID before deleting
    $schoolId = $schoolFee->school_id;

    // Delete the record
    $schoolFee->delete();

    // Redirect back to step 9 (or the same page)
    return redirect()->route('add.school.step9')->with('success', 'Fee record deleted successfully.');
  }

  public function getClassLevel(Request $request){
    $response = [
        'jsonrpc' => '2.0'
    ];
    $response['result']['classLevel'] = ClassLevel::get();
    if(@$request->data['board_id']){
        $response['result']['classLevel'] = ClassLevel::where(['board_id'=>@$request->data['board_id']])->get();
    }
    return response()->json($response);
  }

  public function getCity(Request $request){
    $response = [
      'jsonrpc' => '2.0'
    ];
    if(@$request->data['country']){
      $response['result']['city'] = City::where(['country_id'=>@$request->data['country']])->get();
    }
    return response()->json($response);
  }

  public function deleteContact($id=null){

    SchoolContact::where('id',@$id)->delete();
    return redirect()->back();
  }

  public function schoolSearch(Request $request)
  {
    // Fetch filters from request
    $school_type = $request->school_type;
    $school_level = $school_type ? SchoolLevel::find($school_type) : null;
    $dynamic_school_level = $school_level ? $school_level->name : null;
    // dd($dynamic_school_level);
    $keyword     = $request->keyword;
    $location    = $request->location;
    $curriculum_id = $request->curriculum_id;
    $county_id = $request->county_id;
    $city = $request->city;
    $school_name   = $request->school; // 👈 comes from school listing success page

    // Start building query
    $query = School::query()->with(['schoolLevel', 'type', 'curriculum', 'country', 'county', 'address', 'courses'])
      ->withAvg('reviews', 'rating'); // 👈 this gives us avg_review

    // If school_name is provided, override other filters and return only that record
    if ($school_name) {
        $query->where('name', $school_name);
    } else {

      // Filter: school type
      if ($school_type) {
        $query->where('school_level_id', $school_type);
      }
  
      // Filter: curriculum
      if ($curriculum_id) {
        $query->where('curriculum_id', $curriculum_id);
      }
  
      // Filter: county by name (from city param)
      if ($city) {
        $query->whereHas('county', function ($q) use ($city) {
          $q->where('name', $city);
        });
      }
  
      // Filter: keyword (search in name, description, and course name)
      if ($keyword) {
        $query->where(function ($q) use ($keyword) {
          $q->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->orWhereHas('courses', function ($q2) use ($keyword) {
              $q2->where('name', 'LIKE', "%{$keyword}%");
            });
        });
      }
  
      // Filter: location (search in county name, country name, or address text)
      if ($location) {
        $query->where(function ($q) use ($location) {
          $q->whereHas('county', function ($q1) use ($location) {
            $q1->where('name', 'LIKE', "%{$location}%");
          })
          ->orWhereHas('country', function ($q2) use ($location) {
            $q2->where('name', 'LIKE', "%{$location}%");
          })
          ->orWhereHas('address', function ($q3) use ($location) {
            $q3->where('address_text', 'LIKE', "%{$location}%");
          });
        });
      }
    }

    // Final results
    $schools = $query->get();

    // Static lists (unchanged from your original code)
    $countries = Country::all();
    $counties = County::all();
    $school_levels = SchoolLevel::all();
    // Fetch courses filtered by school_type (school_level_id)
    if ($school_type) {
        $courses = Course::where('school_level_id', $school_type)->get();
    } else {
        $courses = Course::all();
    }
    $school_types_day = SchoolType::where('name', 'Day')->first();
    $school_types_boarding = SchoolType::where('name', 'Boarding')->first();
    $school_types_day_n_boarding = SchoolType::where('name', 'Day & Boarding')->first();
    $key = $request->all();

    return view('search_school.school_list')->with([
        'countries' => $countries,
        'counties' => $counties,
        'school_levels' => $school_levels,
        'courses' => $courses,
        'school_types_day' => $school_types_day,
        'school_types_boarding' => $school_types_boarding,
        'school_types_day_n_boarding' => $school_types_day_n_boarding,
        'schools' => $schools,
        'key' => $key,
        'dynamic_school_level' => $dynamic_school_level,
    ]);
  }

  public function schoolSearchMap(Request $request)
  {
    // Fetch filters from request
    $school_type = $request->school_type;
    $school_level = $school_type ? SchoolLevel::find($school_type) : null;
    $dynamic_school_level = $school_level ? $school_level->name : null;
    // dd($dynamic_school_level);
    $keyword     = $request->keyword;
    $location    = $request->location;
    $curriculum_id = $request->curriculum_id;
    $county_id = $request->county_id;
    $city = $request->city;
    $school_name   = $request->school; // 👈 comes from school listing success page

    // Start building query
    $query = School::query()->with(['schoolLevel', 'type', 'curriculum', 'country', 'county', 'address', 'courses'])
      ->withAvg('reviews', 'rating'); // 👈 this gives us avg_review

    // If school_name is provided, override other filters and return only that record
    if ($school_name) {
        $query->where('name', $school_name);
    } else {

      // Filter: school type
      if ($school_type) {
        $query->where('school_level_id', $school_type);
      }
  
      // Filter: curriculum
      if ($curriculum_id) {
        $query->where('curriculum_id', $curriculum_id);
      }
  
      // Filter: county by name (from city param)
      if ($city) {
        $query->whereHas('county', function ($q) use ($city) {
          $q->where('name', $city);
        });
      }
  
      // Filter: keyword (search in name, description, and course name)
      if ($keyword) {
        $query->where(function ($q) use ($keyword) {
          $q->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('description', 'LIKE', "%{$keyword}%")
            ->orWhereHas('courses', function ($q2) use ($keyword) {
              $q2->where('name', 'LIKE', "%{$keyword}%");
            });
        });
      }
  
      // Filter: location (search in county name, country name, or address text)
      if ($location) {
        $query->where(function ($q) use ($location) {
          $q->whereHas('county', function ($q1) use ($location) {
            $q1->where('name', 'LIKE', "%{$location}%");
          })
          ->orWhereHas('country', function ($q2) use ($location) {
            $q2->where('name', 'LIKE', "%{$location}%");
          })
          ->orWhereHas('address', function ($q3) use ($location) {
            $q3->where('address_text', 'LIKE', "%{$location}%");
          });
        });
      }
    }

    // Final results
    $schools = $query->get();

    // Static lists (unchanged from your original code)
    $countries = Country::all();
    $counties = County::all();
    $school_levels = SchoolLevel::all();
    // Fetch courses filtered by school_type (school_level_id)
    if ($school_type) {
        $courses = Course::where('school_level_id', $school_type)->get();
    } else {
        $courses = Course::all();
    }
    $school_types_day = SchoolType::where('name', 'Day')->first();
    $school_types_boarding = SchoolType::where('name', 'Boarding')->first();
    $school_types_day_n_boarding = SchoolType::where('name', 'Day & Boarding')->first();
    $key = $request->all();

    return view('search_school.school_map_view')->with([
        'countries' => $countries,
        'counties' => $counties,
        'school_levels' => $school_levels,
        'courses' => $courses,
        'school_types_day' => $school_types_day,
        'school_types_boarding' => $school_types_boarding,
        'school_types_day_n_boarding' => $school_types_day_n_boarding,
        'schools' => $schools,
        'key' => $key,
        'dynamic_school_level' => $dynamic_school_level,
    ]);
  }

  public function schoolDetails($slug)
  {
    $school_record = School::with([
      'country',
      'county',
      'address',
      'contact.position',
      'address',
      'curriculum',       // Curriculum relation
      'operationHours',    // Operation hours relation
      'type',
      'religion', // eager load religion
      'population',
      'extendedSchoolServices',
      'facilities',
      'courses',
      'fees.level',
      'branches.county', // load county for each branch
      'branches.type',   // load type for each branch
      'branches.school',  // just in case you need parent school info
      'claimingUsers', // check claims
      'images'
    ])->where('slug', $slug)->firstOrFail();
    // dd($school_operation_hours);

    // Structure branches for display
    $school_branches = $school_record->branches->map(function ($branch) {
      return (object) [
        'school_name'   => $branch->name,
        'full_address'  => optional($branch->county)->name ?? 'N/A',
        'contact_phone' => $branch->phone_no ?? 'N/A',
        'contact_email' => $branch->email ?? 'N/A'
      ];
    })->groupBy(function ($branch, $index) {
      // Optional: group branches in pairs or any grouping logic
      return floor($index / 2);
    });

    // Fetch all contact positions
    $contactPositions = ContactPosition::all();

    $currentUserClaim = null;
    if (Auth::check()) {
      $currentUserClaim = $school_record->claimingUsers
        ->where('id', Auth::id())
        ->first();
    }

    // Get ONLY reviews for this school & include user
    $reviews = SchoolReview::with('user')
        ->where('school_id', $school_record->id)
        ->latest()
        ->get();

    return view('search_school.school_details')->with([
      'school_record' => $school_record,
      'school_branches' => $school_branches,
      'contactPositions'  => $contactPositions,
      'currentUserClaim' => $currentUserClaim,
      'reviews' => $reviews,
      'school_gallery'  => $school_record->images
    ]);
  }

  public function shoolClaimSave(Request $request){
    // dd($request);
    // Validate the request
    $validated = $request->validate([
      'school_id'            => 'required|exists:schools,id',
      'user_name'            => 'required|string|max:255',
      'contact_position_id'  => 'required|exists:contact_positions,id',
      'email_address'        => 'required|email|max:255',
      'claim_file'           => 'required|array',
      'claim_file.*'         => 'file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB limit per file
    ]);

    // Handle file uploads
    if ($request->hasFile('claim_file')) {
      foreach ($request->file('claim_file') as $file) {
        // Sanitize school name -> lowercase, underscores, remove invalid chars
        $school = School::find($validated['school_id']);
        $sanitizedName = Str::slug($school->name, '_');

        // Build file name
        $fileName = $sanitizedName . '_claim_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Define destination and move file
        $destination = storage_path('app/public/claims');
        $file->move($destination, $fileName);

        // Store relative path for database
        $storedFiles[] = 'claims/' . $fileName;
      }
    }

    // Insert into pivot table
    DB::table('school_user')->insert([
      'user_id'              => Auth::id(),
      'school_id'            => $validated['school_id'],
      'contact_position_id'  => $validated['contact_position_id'],
      'proof_of_association' => !empty($storedFiles) ? json_encode($storedFiles) : null,
      'claim_status'         => 'pending',
      'claimed_at'           => now(),
      'created_at'           => now(),
      'updated_at'           => now(),
    ]);

    // Send email notifications
    // 1. To the user (claim received confirmation)
    Mail::to($validated['email_address'])->send(
      new ClaimSubmittedMail($school, $validated['user_name'])
    );

    // 2. To the admin (new claim alert)
    Mail::to(config('mail.admin_address'))->send(
      new AdminNewClaimNotificationMail($school, $validated['user_name'], $validated['email_address'])
    );

    return redirect()->back()->with('success', 'Your school claim has been submitted and is pending approval.');
  }

  public function addFavourite(Request $request) {
    // dd($request);
    // Ensure user is logged in
    if (!Auth::check()) {
      return redirect()->back()->withErrors('You need to be logged in to favourite a school.');
    }

    // Validate & sanitize input
    $validated = $request->validate([
        'school_id' => 'required|integer|exists:schools,id',
    ]);

    $userId = Auth::id();
    $schoolId = $validated['school_id'];

    // Check if already favourited
    $favourite = Favourite::where('user_id', $userId)
        ->where('favouritable_id', $schoolId)
        ->where('favouritable_type', School::class)
        ->first();

    if ($favourite) {
        // If already favourited → remove (toggle behaviour)
        $favourite->delete();
        return redirect()->back()->with('success', 'Removed from favourites successfully.');
    }

    // Otherwise → add new favourite
    Favourite::create([
        'user_id'          => $userId,
        'favouritable_id'  => $schoolId,
        'favouritable_type'=> School::class,
    ]);

    return redirect()->back()->with('success', 'Added to favourites successfully.');
  }

  public function editSchool($id = null, $sub_id = null)
  {
    // ─────────────────────────────
    // 1. Fetch school & related data
    // ─────────────────────────────
    $school_types_day = SchoolType::where('name', 'Day')->first();
    $school_types_boarding = SchoolType::where('name', 'Boarding')->first();
    $school_types_day_n_boarding = SchoolType::where('name', 'Day & Boarding')->first();

    // Fetch the school
    $school = School::with(['fees'])->findOrFail($id);

    // Related images
    $schoolPhotos = $school->images()->get();

    // All school types
    $school_types = SchoolType::all();

    // All curricula (boards)
    $curricula = Curriculum::all();

    // Current school curriculum (for pre-selecting checkbox)
    $selected_school_curricula = [$school->curriculum_id];

    // ─────────────────────────────
    // 2. School contact information
    // ─────────────────────────────
    $contact_info = collect();
    $school_contact = null;

    if ($school->school_contact_id) {
        $school_contact = SchoolContact::find($school->school_contact_id);
        $contact_info = collect([$school_contact]);
    }

    // ─────────────────────────────
    // 3. Facilities
    // ─────────────────────────────
    $facilities = Facility::all();
    $school_facilities = $school->facilities->pluck('id')->toArray();

    // ─────────────────────────────
    // 4. Extended School Services (School Rules)
    // ─────────────────────────────
    $extended_school_services = ExtendedSchoolService::all();

    // IDs of already-selected services for this school
    $selected_extended_services = $school->extendedSchoolServices->pluck('id')->toArray();

    // ─────────────────────────────
    // 5. Operation Hours
    // ─────────────────────────────
    $operation_hours = $school->operationHours ?? collect([
        ['starts_at' => null, 'ends_at' => null],
    ]);

    // ─────────────────────────────
    // 6. Population (Teacher-Student Ratio)
    // ─────────────────────────────
    $latest_population = $school->population()->orderBy('year', 'desc')->first();

    $school_population = $latest_population ? [
        'total_students'  => $latest_population->total_students,
        'student_boys'    => $latest_population->male_students,
        'student_girls'   => $latest_population->female_students,
        'total_teachers'  => $latest_population->total_teachers,
        'teacher_male'    => $latest_population->male_teachers,
        'teacher_female'  => $latest_population->female_teachers,
    ] : [];

    // ─────────────────────────────
    // 7. Courses & Subjects
    // ─────────────────────────────
    $courses = Course::all();
    $already_selected_courses_id = $school->courses->pluck('id')->toArray();
    // dd($already_selected_courses_id);
    $school_subject = $school->schoolCourses()->with('course')->get();

    // ─────────────────────────────
    // 8. Exam Performance
    // ─────────────────────────────
    $schoolResults = SchoolExamPerformance::where('school_id', $school->id)->latest()->get();
    $schoolResult = SchoolExamPerformance::where('school_id', $school->id)->latest()->first();

    if (!$schoolResult) {
        $schoolResult = new \stdClass();
        $schoolResult->exam = '';
        $schoolResult->ranking_position = '';
        $schoolResult->region = '';
        $schoolResult->mean_score_points = '';
        $schoolResult->mean_grade = '';
        $schoolResult->number_of_candidates = '';
    }

    $feeRange = $school->fees()
      ->selectRaw('MIN(min_amount) as min_fee, MAX(max_amount) as max_fee, MAX(currency) as currency')
      ->first();

    $min_fee = $feeRange && $feeRange->min_fee ? number_format($feeRange->min_fee, 0) : null;
    $max_fee = $feeRange && $feeRange->max_fee ? number_format($feeRange->max_fee, 0) : null;
    $currency = $feeRange && $feeRange->currency ? $feeRange->currency : 'KES';

    // ─────────────────────────────
    // 9. Return view
    // ─────────────────────────────
    return view('dashboard.edit_school')->with([
      'school' => $school,
      'school_types' => $school_types,
      'curricula' => $curricula,
      'school_types_day' => $school_types_day,
      'school_types_boarding' => $school_types_boarding,
      'school_types_day_n_boarding' => $school_types_day_n_boarding,
      'selected_school_curricula' => $selected_school_curricula,
      'contact_info' => $contact_info,
      'school_contact' => $school_contact,
      'facilities' => $facilities,
      'school_facilities' => $school_facilities,
      'extended_school_services' => $extended_school_services,
      'selected_extended_services' => $selected_extended_services,
      'operation_hours' => $operation_hours,
      'school_population' => $school_population,
      'courses' => $courses,
      'already_selected_courses_id' => $already_selected_courses_id,
      'school_subject' => $school_subject,
      'schoolResult' => $schoolResult,
      'schoolResults' => $schoolResults,
      'schoolPhotos' => $schoolPhotos,
      'min_fee' => $min_fee,
      'max_fee' => $max_fee,
      'currency' => $currency,
    ]);
  }

  public function schoolInfoUpdate(Request $request)
  {
    // 🔹 Validate input
    $validated = $request->validate([
        'school_master_id'  => 'required|exists:schools,id',
        'school_name'       => 'required|string|max:255',
        'about_school'      => 'required|string|max:5000',
        'gender_admission'  => 'required|in:Male,Female,Mixed',
        'school_type_id'    => 'required|exists:school_types,id',

        'board'             => 'nullable|array',
        'board.*'           => 'nullable|integer|exists:curricula,id',
        'other_board'       => 'nullable|string|max:255',

        'contact_title'     => 'required|array|min:1',
        'contact_title.*'   => 'required|string|max:255',
        'contact_email'     => 'required|array|min:1',
        'contact_email.*'   => 'required|email|max:255',
        'contact_phone'     => 'required|array|min:1',
        'contact_phone.*'   => 'required|string|max:20',
    ], [], [
        'school_master_id'  => 'School',
        'school_name'       => 'School name',
        'about_school'      => 'About the school',
        'gender_admission'  => 'Gender',
        'school_type_id'    => 'School type',
        'board'             => 'Curriculum',
        'board.*'           => 'Curriculum option',
        'contact_title.*'   => 'Contact name',
        'contact_email.*'   => 'Contact email',
        'contact_phone.*'   => 'Contact phone number',
    ]);

    DB::beginTransaction();

    try {
        // ────────────────────────────────
        // 1️⃣ Fetch existing school
        // ────────────────────────────────
        $school = School::findOrFail($validated['school_master_id']);

        // ────────────────────────────────
        // 2️⃣ Handle curriculum logic
        // ────────────────────────────────
        $curriculum_id = null;

        if (!empty($validated['board'])) {
            // Use first selected curriculum if multiple
            $curriculum_id = $validated['board'][0];
        }

        if (isset($validated['other_board']) && !empty($validated['other_board'])) {
            // If "Other" selected, create new curriculum
            $newCurriculum = Curriculum::firstOrCreate([
                'name' => $validated['other_board']
            ]);
            $curriculum_id = $newCurriculum->id;
        }

        // ────────────────────────────────
        // 3️⃣ Update SchoolContact info
        // ────────────────────────────────
        if ($school->school_contact_id) {
            $contact = SchoolContact::find($school->school_contact_id);
        } else {
            $contact = new SchoolContact();
        }

        $contact->full_names = $validated['contact_title'][0];
        $contact->email = $validated['contact_email'][0];
        $contact->phone_no = $validated['contact_phone'][0];
        $contact->save();

        // ────────────────────────────────
        // 4️⃣ Update School main info
        // ────────────────────────────────
        $school->update([
            'name'             => $validated['school_name'],
            'description'      => $validated['about_school'],
            'gender_admission' => $validated['gender_admission'],
            'school_type_id'   => $validated['school_type_id'],
            'curriculum_id'    => $curriculum_id,
            'school_contact_id'=> $contact->id,
        ]);

        DB::commit();

        // ────────────────────────────────
        // ✅ Redirect back to edit page
        // ────────────────────────────────
        return redirect()
            ->route('user.edit.school', ['id' => $school->id])
            ->with('success', 'School information updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Failed to update school: ' . $e->getMessage()]);
    }
  }

  public function updateFacility(Request $request)
  {
    // 🔹 Validate input
    $validated = $request->validate([
        'school_master_id'  => 'required|exists:schools,id',
        'facilities'        => 'nullable|array',
        'facilities.*'      => 'integer|exists:facilities,id',
        'other_facilities'  => 'nullable|string|max:255',
    ], [
        'school_master_id.required' => 'School ID is required.',
        'school_master_id.exists'   => 'The selected school does not exist.',
        'facilities.array'          => 'Facilities must be an array of IDs.',
        'facilities.*.exists'       => 'One or more selected facilities are invalid.',
    ]);

    DB::beginTransaction();

    try {
        // Fetch the school
        $school = School::findOrFail($validated['school_master_id']);

        // Sync selected facilities
        if (!empty($validated['facilities'])) {
            $school->facilities()->sync($validated['facilities']);
        } else {
            // If no facilities selected, detach all
            $school->facilities()->detach();
        }

        // If 'other_facilities' is provided, create a new Facility record and attach it
        if (!empty($validated['other_facilities'])) {
          $newFacility = Facility::create([
            'name' => $validated['other_facilities'],
          ]);

          // Attach the new facility to this school
          $school->facilities()->attach($newFacility->id);
        }

        DB::commit();

        // Redirect back to edit school page
        return redirect()
            ->route('user.edit.school', ['id' => $school->id])
            ->with('success', 'Facilities and amenities updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Failed to update facilities: ' . $e->getMessage()]);
    }
  }

  public function updateSchoolSubject(Request $request)
  {
    // 🔹 Validate input
    $validated = $request->validate([
        'school_master_id' => 'required|exists:schools,id',
        'subject'          => 'nullable|array',
        'subject.*'        => 'integer|exists:courses,id',
        'other_subject'    => 'nullable|string|max:255',
    ], [
        'school_master_id.required' => 'School ID is required.',
        'school_master_id.exists'   => 'The selected school does not exist.',
        'subject.array'             => 'Subjects must be an array of IDs.',
        'subject.*.exists'          => 'One or more selected subjects are invalid.',
    ]);

    DB::beginTransaction();

    try {
        // 🔹 Fetch the school record
        $school = School::findOrFail($validated['school_master_id']);

        // 🔹 Sync selected subjects (existing courses)
        if (!empty($validated['subject'])) {
            $school->courses()->sync($validated['subject']);
        } else {
            // If no subjects selected, detach all
            $school->courses()->detach();
        }

        // 🔹 If 'other_subject' is provided, create a new Course record and attach it
        if (!empty($validated['other_subject'])) {
            // Avoid creating duplicates
            $newCourse = Course::firstOrCreate([
                'name' => trim($validated['other_subject']),
            ]);

            // Attach the new course to the school
            $school->courses()->attach($newCourse->id);
        }

        DB::commit();

        // 🔹 Redirect back to edit school page
        return redirect()
            ->route('user.edit.school', ['id' => $school->id])
            ->with('success', 'Subjects updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Failed to update subjects: ' . $e->getMessage()]);
    }
  }

  public function updateSchoolResult(Request $request)
  {
    // 🔹 Validate the incoming data
    $validated = $request->validate([
        'school_master_id'   => 'required|exists:schools,id',
        'exam'               => 'required|string|max:255',
        'ranking_position'   => 'nullable|integer|min:0',
        'region'             => 'nullable|string|max:255',
        'mean_score_point'   => 'nullable|numeric|min:0',
        'mean_grade'         => 'nullable|string|max:10',
        'no_of_candidate'    => 'nullable|integer|min:0',
    ], [
        'school_master_id.required' => 'School ID is required.',
        'school_master_id.exists'   => 'The selected school does not exist.',
        'exam.required'             => 'Please select an exam.',
    ]);

    DB::beginTransaction();

    try {
        // 🔹 Retrieve the school
        $school = School::findOrFail($validated['school_master_id']);

        // 🔹 Create or update the school exam performance
        $examPerformance = SchoolExamPerformance::updateOrCreate(
            [
                'school_id' => $school->id,
                'exam'      => $validated['exam'], // ensures per-school exam uniqueness
            ],
            [
                'ranking_position'   => $validated['ranking_position'] ?? null,
                'region'             => $validated['region'] ?? null,
                'mean_score_points'  => $validated['mean_score_point'] ?? null,
                'mean_grade'         => $validated['mean_grade'] ?? null,
                'number_of_candidates' => $validated['no_of_candidate'] ?? null,
            ]
        );

        // 🔹 Optionally update number_of_candidates on the school record
        if (!empty($validated['no_of_candidate'])) {
            $school->update([
                'number_of_candidates' => $validated['no_of_candidate']
            ]);
        }

        DB::commit();

        // 🔹 Redirect back to edit school page with success message
        return redirect()
            ->route('user.edit.school', ['id' => $school->id])
            ->with('success', 'School exam performance updated successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Error updating school exam performance: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request' => $request->all(),
        ]);

        return back()->with('error', 'An unexpected error occurred: ' . $e->getMessage());
    }
  }

  public function updateSchoolRules(Request $request)
  {
    $request->validate([
        'school_master_id' => 'required|exists:schools,id',
        'extended_school_services_id' => 'nullable|array',
        'extended_school_services_id.*' => 'exists:extended_school_services,id',
        'day_learn_period_from' => 'required|string',
        'day_learn_period_until' => 'required|string',
        'evening_studies_from' => 'required|string',
        'evening_studies_until' => 'required|string',
    ]);

    try {
        DB::beginTransaction();

        $schoolId = $request->input('school_master_id');
        $school = School::findOrFail($schoolId);

        // 🔹 Update Extended School Services
        $extendedServices = $request->input('extended_school_services_id', []);
        $school->extendedSchoolServices()->sync($extendedServices);

        // 🔹 Update or Create Day Operation Hours
        SchoolOperationHour::updateOrCreate(
            [
                'school_id' => $schoolId,
                'period_of_day' => 'day',
            ],
            [
                'starts_at' => $request->input('day_learn_period_from'),
                'ends_at' => $request->input('day_learn_period_until'),
            ]
        );

        // 🔹 Update or Create Evening Operation Hours
        SchoolOperationHour::updateOrCreate(
            [
                'school_id' => $schoolId,
                'period_of_day' => 'evening',
            ],
            [
                'starts_at' => $request->input('evening_studies_from'),
                'ends_at' => $request->input('evening_studies_until'),
            ]
        );

        DB::commit();

        return redirect()
            ->route('user.edit.school', ['id' => $schoolId])
            ->with('success', 'School rules updated successfully.');
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Failed to update school rules', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all(),
        ]);

        return redirect()
            ->back()
            ->with('error', 'Failed to update school rules: ' . $e->getMessage());
    }
  }

  public function addSchoolStep4RatioUpdate(Request $request)
  {
    // dd($request);
    // Validate incoming request
    $validated = $request->validate([
        'school_master_id' => 'required|exists:schools,id',
        'total_students'   => 'required|integer|min:0',
        'student_boys'     => 'required|integer|min:0',
        'student_girls'    => 'required|integer|min:0',
        'total_teachers'   => 'required|integer|min:0',
        'teacher_male'     => 'required|integer|min:0',
        'teacher_female'   => 'required|integer|min:0',
    ], [
        'school_master_id.required' => 'School ID is required.',
        'school_master_id.exists'   => 'The selected school does not exist.',
    ]);

    // Retrieve the school by ID
    $school = School::findOrFail($validated['school_master_id']);

    // Optional data consistency checks
    if ($validated['total_students'] != ($validated['student_boys'] + $validated['student_girls'])) {
        return back()->withErrors(['total_students' => 'Sum of boys and girls must equal total students']);
    }

    if ($validated['total_teachers'] != ($validated['teacher_male'] + $validated['teacher_female'])) {
        return back()->withErrors(['total_teachers' => 'Sum of male and female teachers must equal total teachers']);
    }

    // Create or update population record for the school
    $school->population()->updateOrCreate(
        ['year' => now()->year], // One record per year
        [
            'total_students'  => $validated['total_students'],
            'total_teachers'  => $validated['total_teachers'],
            'male_students'   => $validated['student_boys'],
            'female_students' => $validated['student_girls'],
            'male_teachers'   => $validated['teacher_male'],
            'female_teachers' => $validated['teacher_female'],
        ]
    );

    // Flash success message
    session()->flash('success', 'School population data updated successfully.');

    // Redirect back to the edit page (or wherever you prefer)
    return redirect()->back()->with('success', 'School population data updated successfully.');
  }

  public function updateImage(Request $request)
  {
    // ✅ Validate request
    $validated = $request->validate([
      'school_master_id' => 'required|exists:schools,id',
      'school_image'     => 'required|file|mimes:jpg,jpeg,png,webp|max:2048',
      'image_id'         => 'nullable|exists:school_images,id',
    ]);

    try {
      // ✅ Find the school
      $school = School::findOrFail($validated['school_master_id']);

      // ✅ Handle image upload
      if ($request->hasFile('school_image')) {
          $uploadedImage = $request->file('school_image');

          if ($uploadedImage->isValid()) {
              // Sanitize school name
              $sanitizedName = Str::slug($school->name, '_');

              // Generate unique filename
              $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

              // Destination path inside storage/app/public/images/school_images
              $destination = storage_path('app/public/images/school_images');
              if (!file_exists($destination)) {
                  mkdir($destination, 0755, true);
              }

              // Move uploaded file
              $uploadedImage->move($destination, $imageName);

              // Relative path for DB
              $path = 'images/school_images/' . $imageName;

              // ✅ If image_id provided → update existing record
              if (!empty($validated['image_id'])) {
                  $schoolImage = SchoolImage::findOrFail($validated['image_id']);

                  // Delete old image file (optional but recommended)
                  if ($schoolImage->image_path && Storage::disk('public')->exists($schoolImage->image_path)) {
                      Storage::disk('public')->delete($schoolImage->image_path);
                  }

                  $schoolImage->update([
                      'image_path' => $path,
                      'caption'    => $school->name,
                  ]);
              } else {
                  // ✅ Otherwise → create new image record
                  $school->images()->create([
                      'image_path' => $path,
                      'caption'    => $school->name,
                  ]);
              }

              return redirect()->back()->with('success', 'School image saved successfully.');
          }
      }

      return redirect()->back()->with('error', 'Invalid image upload. Please try again.');
    } catch (\Exception $e) {
      return redirect()->back()->with('error', 'Failed to update school image: ' . $e->getMessage());
    }
  }

  public function uploadPhotoSave(Request $request)
  {
    // ✅ Validate incoming files
    $request->validate([
      'school_master_id' => 'required|exists:schools,id',
      'school_image'     => 'required|array',
      'school_image.*'   => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ], [
      'school_image.required'   => 'Please upload at least one image.',
      'school_image.*.image'    => 'Each file must be a valid image.',
      'school_image.*.mimes'    => 'Only jpeg, png, jpg, gif, and webp formats are allowed.',
      'school_image.*.max'      => 'Each image must not exceed 2MB.',
    ]);

    // ✅ Find the school record
    $school = School::findOrFail($request->school_master_id);

    // ✅ Process and store images
    if ($request->hasFile('school_image')) {
      foreach ($request->file('school_image') as $uploadedImage) {
        // saves image to storage
        // if ($uploadedImage->isValid()) {
        //   // Sanitize school name for filename
        //   $sanitizedName = Str::slug($school->name, '_');

        //   // Create unique image filename
        //   $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

        //   // Destination inside storage/app/public/images/school_images
        //   $destination = storage_path('app/public/images/school_images');
        //   $uploadedImage->move($destination, $imageName);

        //   // Relative DB path
        //   $path = 'images/school_images/' . $imageName;

        //   // ✅ Save record in DB
        //   $school->images()->create([
        //     'image_path' => $path,
        //     'caption'    => $school->name,
        //   ]);
        // }

        // saves images directly to public folder
        if ($uploadedImage->isValid()) {
          // Sanitize school name for filename
          $sanitizedName = Str::slug($school->name, '_');

          // Create unique image filename
          $imageName = $sanitizedName . '_' . time() . '_' . uniqid() . '.' . $uploadedImage->getClientOriginalExtension();

          // ✅ Destination inside public/images/school_images
          $destination = public_path('images/school_images');

          // Ensure the folder exists
          if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
          }

          // Move the uploaded file to the public folder
          $uploadedImage->move($destination, $imageName);

          // ✅ Relative DB path (relative to /public)
          $path = 'images/school_images/' . $imageName;

          // Save record in DB
          $school->images()->create([
            'image_path' => $path,
            'caption'    => $school->name,
          ]);
      }
      }
    }

    // ✅ Redirect back with success message
    return redirect()->back()->with('success', 'School image(s) added successfully.');
  }
}
