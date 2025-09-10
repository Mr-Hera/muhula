<?php

namespace App\Http\Controllers;

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
use App\Models\SchoolLevel;
use Illuminate\Support\Str;
use App\Models\SchoolBranch;
use App\Models\SchoolReview;
use Illuminate\Http\Request;
use App\Models\SchoolAddress;
use App\Models\SchoolContact;
use App\Models\SchoolUniform;
use App\Models\ContactPosition;
use Illuminate\Support\Facades\DB;
use App\Models\SchoolOperationHour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ExtendedSchoolService;
use App\Models\SchoolExamPerformance;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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

  public function addSchoolStep2(){
    $countries = Country::all();
    $counties = County::all();

    // Try to get school details from session if exists
    $schoolDetails = null;
    if (Session::has('school_creation.step2.school_id')) {
      $schoolId = Session::get('school_creation.step2.school_id');
      $schoolDetails = School::with(['contact', 'address'])->find($schoolId);
    }
    
    return view('listSchool.add_school_step2')->with([
      'countries' => $countries,
      'counties' => $counties,
      'schoolDetails'  => $schoolDetails,
    ]);
  }

  public function addSchoolStep2Save(Request $request){
    // dd($request);
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
      'county'             => 'required|integer|exists:counties,id',
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
        'full_address'     => 'Full address',
        'google_location'  => 'Google map link',
    ]);
    
    DB::beginTransaction();

    try {
        // 1. Save school_contact
        $schoolContact = new SchoolContact();
        $schoolContact->full_names = $validated['contact_title'][0];
        $schoolContact->email = $validated['contact_email'][0];
        $schoolContact->phone_no = $validated['contact_phone'][0];
        $schoolContact->save();

        // Take the full_names string (e.g., "John Mwangi" or "John")
        $names = explode(' ', trim($schoolContact->full_names));

        // Always grab the first and second parts only
        $firstName = $names[0] ?? '';
        $lastName  = $names[1] ?? '';

        // Add contact as a user
        $school_contact_user = new User();
        $school_contact_user->first_name = $firstName;
        $school_contact_user->last_name = $lastName;
        $school_contact_user->email = $schoolContact->email;
        $school_contact_user->phone = $schoolContact->phone_no;
        $school_contact_user->password =  Hash::make(env('SECURE_APP_PASSWORD'));
        $school_contact_user->save();

        // 2. Save school_address
        $schoolAddress = new SchoolAddress();
        $schoolAddress->address_text = $validated['full_address'] ?? null;
        $schoolAddress->google_maps_link = $validated['google_location'] ?? null;
        $schoolAddress->save();

        // 3. Save partial school (just what we can now)
        $school = new School();
        $school->name = $validated['school_name'];
        $school->description = $validated['about_school'];
        $school->slug = Str::slug($validated['about_school'] . '-' . Str::random(5));
        $school->county_id = $validated['county'];
        $school->country_id = $validated['country'];
        $school->school_contact_id = $schoolContact->id;
        $school->school_address_id = $schoolAddress->id;

        $school->save();

        DB::commit();

        // Save IDs to session for step tracking
        Session::put('school_creation.step2', [
            'school_id' => $school->id,
            'contact_id' => $schoolContact->id,
            'address_id' => $schoolAddress->id,
        ]);

        return redirect()->route('add.school.step3');

    } catch (\Exception $e) {
      // dd($e);
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

      'gender'                 => 'required|string|in:Mixed,Boys,Girls',

      'school_type_id'         => 'required|integer|exists:school_types,id',

      'contact_relationship_id'=> 'required|integer|exists:contact_positions,id',
      'other_relationship'     => 'nullable|string|max:255',

      'religion_id'            => 'required|integer|exists:religions,id',

      'facilities'             => 'required|array|min:1',
      'facilities.*'           => 'required|integer|exists:facilities,id',

      'other_facilities'       => 'nullable|string|max:255',

      'school_logo'            => 'nullable|file|mimes:image/jpeg,image/png,image/gif,image/jpg|max:2048', // 2MB max
    ]);

    $schoolId = Session::get('school_creation.step2.school_id');
    $currentSchoolInput = School::where('id', $schoolId)->first();
    // dd($currentSchoolInput->name);
    $contactId = Session::get('school_creation.step2.contact_id');

    if (!$schoolId) {
      // dd('Previous school data not found');
      return back()->withErrors(['error' => 'Previous school data not found. Please restart the form.']);
    }

    DB::beginTransaction();

    try {
      $school = School::findOrFail($schoolId);
      // dd($school);

      // Handle file upload
      $schoolLogoPath = "";

      // TODO:RESOLVE LOGO STORAGE ISSUE
      if ($request->hasFile('school_logo')) {
        $image = $request->files->get('school_logo'); // Symfony object
        $imageName = $currentSchoolInput->name . '_logo.' . $image->getClientOriginalExtension();

        $destination = storage_path('app/public/images/school_logo');
        $image->move($destination, $imageName);

        $schoolLogoPath = 'images/school_logo/' . $imageName; // relative path for DB
      }

      // Assuming one curriculum ID is picked (if not, you'll need a pivot table)
      // Also assuming first item from arrays is used for singular fields in the schools table
      $curriculumName = $request['curricula'][0];
      $curriculum = Curriculum::firstOrCreate(['name' => $curriculumName]);

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
        'contact_position_id' => $request['contact_relationship_id'][0],
      ]);

      DB::commit();

      // Save step 3 data in session for completeness
      $session3 = Session::put('school_creation.step3', [
          'ownership_type'          => $request['ownership_type'],
          'year_of_establishment'  => $request['year_of_establishment'],
          'school_level_id'        => $request['school_level_id'],
          'curriculum_id'          => $curriculum->id,
          'gender'                 => $request['gender'],
          'school_type_id'         => $request['school_type_id'],
          'contact_relationship_id'=> $request['contact_relationship_id'],
          'other_relationship'     => $request['other_relationship'],
          'religion_id'            => $request['religion_id'],
          'facilities'             => $request['facilities'],
          'other_facilities'       => $request['other_facilities'],
          'school_logo_path'       => $schoolLogoPath,
      ]);

      return redirect()->route('add.school.step4');

    } catch (\Exception $e) {
      // dd($e);
      DB::rollBack();
      return back()->withErrors(['error' => 'Failed to save school step 3: ' . $e->getMessage()]);
    }
  }


  public function addSchoolStep3UniformSave(Request $request){
    dd($request);
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
    return redirect()->route('add.school.step3',[md5(@$uniform->school_master_id)]); 
   }

  public function addSchoolStep4(){
    $extended_school_services = ExtendedSchoolService::all();
    $schoolId = Session::get('school_creation.step2.school_id');
    $school   = School::findOrFail($schoolId);

    // Prefer DB values, fallback to session
    $operationHours = $school->operationHours()->get()->toArray();
    if (empty($operationHours)) {
        $operationHours = Session::get('school_creation.extended_services.step4.operation_hours', []);
    }

    return view('listSchool.add_school_step4')->with([
        'extended_school_services' => $extended_school_services,
        'extended_services'        => Session::get('school_creation.extended_services.step4'),
        'school_population'        => Session::get('school_creation.school_population.step4'),
        'operation_hours'          => $operationHours,
    ]);
  }

   public function addSchoolStep4RatioSave(Request $request){
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

    // Store to session for next step
    Session::put('school_creation.school_population.step4', [
      'total_students'   => $validated['total_students'],
      'student_boys'     => $validated['student_boys'],
      'student_girls'    => $validated['student_girls'],
      'total_teachers'   => $validated['total_teachers'],
      'teacher_male'     => $validated['teacher_male'],
      'teacher_female'   => $validated['teacher_female'],
    ]);
    // dd(Session::get('school_creation.school_population.step4'));

    session()->flash('success','School population data saved successfully.');

    return redirect()->back()->with('success', 'School population saved successfully.')->with([
      'school_population' => Session::get('school_creation.school_population.step4'),
      'extended_services' => Session::get('school_creation.extended_services.step4'),
    ]);
  }

    public function addSchoolStep4RulesSave(Request $request){
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

      // 3. Save data to session for this step
      Session::put('school_creation.extended_services.step4', [
        'extended_school_services_id' => $extendedServiceIds,
        'operation_hours'             => $operationHours,
      ]);
      // dd(Session::get('school_creation.step4'));

      // Flash success and redirect
      session()->flash('success', 'School services updated successfully');

      return redirect()->route('add.school.step4')->with([
        'extended_services' => Session::get('school_creation.extended_services.step4'),
      ]);
    }

    public function addSchoolStep5($id=null){
      // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
      // if($data['schoolDetails'] == null){

      //   return redirect()->back()->with('error','Something went wrong');
      // }
      // $data['school_gallery'] = SchoolGallery::where('school_master_id',@$data['schoolDetails']->id)->get();

      return view('listSchool.add_school_step5');
    }

    public function addSchoolStep5Save(Request $request){
      // dd($request);
      // $schoolId = Session::get('school_creation.step2.school_id');
      // $school = School::findOrFail($schoolId);

      // if ($request->hasFile('school_image')) {
      //   foreach ($request->file('school_image') as $uploadedImage) {
      //     // Store the image
      //     $path = $uploadedImage->store('school_images', 'public');

      //     // Save to DB
      //     $school->images()->create([
      //         'image_path' => $path,
      //         'caption' => null, // Add logic here if you submit captions
      //     ]);
      //   }
      //   // dd('DONE!');
      // }
      // dd('Skipped Upload!');

      // Redirect or proceed to next step
      return redirect()->route('add.school.step6')->with('success', 'Images uploaded successfully.');
    }


    public function addSchoolStep6(){
      $courses = Course::all();
      $school_levels = SchoolLevel::all();
      $curricula = Curriculum::all();
      $selectedCourses = Session::get('school_creation.courses.step6.course_data', []);
      // dd($selectedCourseNames);

      return view('listSchool.add_school_step6')->with([
        'courses' => $courses,
        'school_levels' => $school_levels,
        'curricula' => $curricula,
        'selectedCourses' => $selectedCourses,
      ]);
    }

    public function addSchoolStep6SubjectSave(Request $request){
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
      
      // Optionally store in session for review steps
      Session::put('school_creation.extended_services.step6.courses', $courseNames);
      Session::put('school_creation.courses.step6.course_data', $courseDataList);
      // dd(Session::get('school_creation.extended_services.step6.courses'));

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

    public function addSchoolStep7(){
      $schoolId = Session::get('school_creation.step2.school_id');
      $examPerformance = Session::get('school_creation.exam_performance');
      $examPerformanceRecords = SchoolExamPerformance::where('school_id', $schoolId)->latest()->get();
      // dd(Session::get('school_creation.exam_performance'));

      return view('listSchool.add_school_step7')->with([
        'examPerformance' => $examPerformance,
        'examPerformanceRecords' => $examPerformanceRecords,
      ]);
    }

    public function addSchoolStep7Save(Request $request){
      // dd($request);
      try {
        $request->validate([
            'exam' => 'required|string|max:255',
            'ranking_position' => 'nullable|integer',
            'region' => 'nullable|string|max:255',
            'mean_score_point' => 'nullable|numeric',
            'mean_grade' => 'nullable|string|max:10',
            'no_of_candidate' => 'nullable|integer',
        ]);

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
        // dd($examPerformance);

        Session::put('school_creation.exam_performance', [
            'id' => $examPerformance->id,
            'exam' => $examPerformance->exam,
            'ranking_position' => $examPerformance->ranking_position,
            'region' => $examPerformance->region,
            'mean_score_points' => $examPerformance->mean_score_points,
            'mean_grade' => $examPerformance->mean_grade,
            'number_of_candidates' => $examPerformance->number_of_candidates,
        ]);
        // dd(Session::get('school_creation.exam_performance'));

        return redirect()->back()->with('success', 'Exam performance data saved successfully.');
      } catch (\Throwable $e) {
        dd($e);
          Log::error('Error saving school exam performance: '.$e->getMessage(), [
              'trace' => $e->getTraceAsString(),
              'request' => $request->all(),
          ]);

          return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
      }
    }

    public function addSchoolStep8(){
      $schoolId = Session::get('school_creation.step2.school_id');
      $school_branches = SchoolBranch::where('school_id', $schoolId)->get();
      $countries = Country::all();
      $counties = County::all();
      $school_levels = SchoolLevel::all();
      
      return view('listSchool.add_school_step8')->with([
        'school_branches' => $school_branches,
        'countries' => $countries,
        'counties' => $counties,
        'school_levels' => $school_levels,
      ]);
    }

    public function addSchoolStep8Save(Request $request){
      // dd($request);
      // Step 1: Validate the request
      $validated = $request->validate([
          'school_name' => 'required|string|max:255',
          'school_type' => 'required|array',
          'school_type.*' => 'exists:school_types,id',
          'country' => 'required|exists:countries,id',
          'town' => 'required|exists:counties,id',
          'full_address' => 'required|string|max:255',
          'google_location' => 'nullable|string',
          'google_lat' => 'nullable|numeric',
          'google_long' => 'nullable|numeric',
          'email' => 'required|email',
          'phone' => 'required|string|max:20',
      ]);

      $schoolId = Session::get('school_creation.step2.school_id');
      // dd($schoolId);

      // 2. Save school_address
      $schoolAddress = new SchoolAddress();
      $schoolAddress->address_text = $validated['full_address'] ?? null;
      $schoolAddress->google_maps_link = $validated['google_location'] ?? null;
      $schoolAddress->save();

      // Step 3: Create the branch
      $branch = new SchoolBranch();
      $branch->name = $validated['school_name'];
      $branch->school_id = $schoolId;
      $branch->school_type_id = $validated['school_type'][0]; // Assuming only one is selected
      $branch->county_id = $validated['town']; // Assuming this refers to counties
      $branch->school_address_id = $schoolAddress->id;
      $branch->school_image_id = 1;
      $branch->email = $validated['email'];
      $branch->phone_no = $validated['phone'];
      $branch->save();
      // dd($branch);

      // Step 3: Store major data points in Session
      Session::put('school_creation.school_branch', [
          'school_branch_id' => $branch->id,
          'school_name' => $branch->name,
          'school_type_id' => $branch->school_type_id,
          'school_image_id' => $branch->school_image_id,
          'county_id' => $branch->county_id,
          'email' => $branch->email,
          'phone_no' => $branch->phone_no,
      ]);

      // Step 4: Redirect or return response
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
    $school_levels = SchoolLevel::all();

    return view('listSchool.add_school_step9')->with([
      'school_levels' => $school_levels,
    ]);
  }

  public function addSchoolStep9FeesSave(Request $request){
    // dd($request);
    // Validate the input
    $validated = $request->validate([
      'grade_level' => 'required|exists:school_levels,id',
      'min_amount' => 'required|numeric|min:0',
      'max_amount' => 'required|numeric|gte:min_amount',
    ]);
    
    // Get the school_id from session
    $schoolId = Session::get('school_creation.step2.school_id');
    $school = School::find($schoolId);
    // dd($schoolId);

    // Create the school fee record
    $school_fee_record = SchoolFee::create([
        'school_id' => $schoolId,
        'level_id' => $validated['grade_level'],
        'min_amount' => $validated['min_amount'],
        'max_amount' => $validated['max_amount'],
        'currency' => 'KES', // You can dynamically pass this if needed
    ]);
    // dd($school_fee_record);

    // Store the moving parts in session for next steps
    Session::put('school_creation.step8.fee_data', [
        'grade_level' => $validated['grade_level'],
        'min_amount' => $validated['min_amount'],
        'max_amount' => $validated['max_amount'],
        'currency'    => 'KES', // Again, replace with $request->currency if needed
    ]);

    return redirect()->route('add.school.success')->with('success', 'School listing added successfully.')->with('school_name', $school?->name);
  }

  public function addSchoolSuccessPage()
  {
    return view('listSchool.add_school_success_page');
  }

    
  public function schoolFeesDelete($id=null){

    $schoolFees = SchoolFees::where('id',@$id)->first();
    if(@$schoolFees == null){

      return redirect()->back()->with('error','Something went wrong');
    }

    $schoolFees->delete();
    $school_fees = SchoolFees::where('school_master_id',@$schoolFees->school_master_id)->min('from_fees'); 
      SchoolMaster::where('id',@$schoolFees->school_master_id)->update(['starting_from_fees'=>@$school_fees]);
    return redirect()->route('add.school.step9',[md5(@$schoolFees->school_master_id)]); 
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
    $query = School::query()->with(['schoolLevel', 'type', 'curriculum', 'country', 'county', 'address', 'courses']);

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
    $courses = Course::all();
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
      'claimingUsers' // check claims
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
      'reviews' => $reviews
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
    // $storedFiles = [];
    // if ($request->hasFile('claim_file')) {
    //   foreach ($request->file('claim_file') as $file) {
    //     // Store in /storage/app/public/claims
    //     $path = $file->store('claims', 'public');
    //     $storedFiles[] = $path;
    //   }
    // }

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

    // Optionally, send email notifications later
    /*
    // To the user
    Mail::to($validated['email_address'])->send(new ClaimSubmittedMail($validated));

    // To admin
    Mail::to(config('mail.admin_address'))->send(new NewClaimNotificationMail($validated));
    */

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
}
