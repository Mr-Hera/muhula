<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\Course;
use App\Models\School;
use App\Models\Country;
use App\Models\Facility;
use App\Models\Religion;
use App\Models\Curriculum;
use App\Models\SchoolType;
use App\Models\SchoolLevel;
use Illuminate\Support\Str;
use App\Models\SchoolBranch;
use Illuminate\Http\Request;
use App\Models\SchoolAddress;
use App\Models\SchoolContact;
use App\Models\SchoolUniform;
use App\Models\ContactPosition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtendedSchoolService;
use App\Models\SchoolExamPerformance;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SchoolController extends Controller
{
  public function addSchoolStep1($id=null){
    $schoolDetails = School::where(DB::raw('id'),@$id)->first();
    
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
    
    return view('listSchool.add_school_step2')->with([
      'countries' => $countries,
      'counties' => $counties,
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
    ]);
    
    DB::beginTransaction();

    try {
        // 1. Save school_contact
        $schoolContact = new SchoolContact();
        $schoolContact->full_names = $validated['contact_title'][0];
        $schoolContact->email = $validated['contact_email'][0];
        $schoolContact->phone_no = $validated['contact_phone'][0];
        $schoolContact->save();

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
      dd($e);
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
    dd($request);
    try {
      $validated = Validator::make($request->all(), [
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
      
    } catch (ValidationException $e) {
      dd($e);
    }

    $schoolId = Session::get('school_creation.step2.school_id');
    $contactId = Session::get('school_creation.step2.contact_id');

    if (!$schoolId) {
      dd('Previous school data not found');
      return back()->withErrors(['error' => 'Previous school data not found. Please restart the form.']);
    }

    DB::beginTransaction();

    try {
      $school = School::findOrFail($schoolId);
      // dd($school);

      // Handle file upload
      $schoolLogoPath = "";

      // TODO:RESOLVE LOGO STORAGE ISSUE
      // if ($request->hasFile('school_logo')) {
      //   $image = $request->file('school_logo');
      //   $imageName = $image->getClientOriginalName();
      //   $schoolLogoPath = $image->storeAs('images/school_logo', $imageName, 'public');
      // }

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
      dd($e);
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
    // dd(Session::get('school_creation.extended_services.step4')['operation_hours'][0]['starts_at']);

    return view('listSchool.add_school_step4')->with([
      'extended_school_services' => $extended_school_services,
      'extended_services' => Session::get('school_creation.extended_services.step4'),
      'school_population' => Session::get('school_creation.school_population.step4'),
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
          $school->operationHours()->create($data);
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
      $school_branches = SchoolBranch::with('school')->get();
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
      dd($request);
    $this->validate($request, [
        'school_name'  =>['required'],
        'country'   =>['required'], 
        //'constituency'   =>['required'],         
      ]);

        $main_school = SchoolMaster::where('id',@$request->school_master_id)->where('parent_id','=',0)->first();
        //$check_school_branch = SchoolBranch::where('school_master_id',@$request->school_master_id)->count();
        $no_of_school_branch = SchoolMaster::where('parent_id',@$main_school->id)->count();
        $available_school = @$main_school->no_of_school - ($no_of_school_branch+1);
        //dd($available_school);
        if(@$available_school <= 0 && @$request->school_branch_id == null){

            return redirect()->back()->with('error','You not able to add affiliates any more');
        }  
        if($request->school_branch_id){
          $schoolBranch = SchoolMaster::where('id',@$request->school_branch_id)->first();
        $upd = [];
        $upd['user_id'] = Auth::user()->id;
        $upd['parent_id'] = $request->school_master_id;
        $upd['school_name'] = $request->school_name;
        $upd['about_school'] = @$main_school->about_school;
        $upd['about_school_facility'] = @$main_school->about_school_facility;
        $upd['contact_email'] = $request->email;
        $upd['contact_phone'] = $request->phone;
        $upd['country'] = $request->country;
        //$upd['constituency'] = $request->constituency;
        //$upd['town'] = $request->town;
        $upd['full_address'] = $request->full_address;
        $upd['google_location'] = $request->google_location;
        $upd['google_lat'] = $request->google_lat;
        $upd['google_long'] = $request->google_long;
        $upd['year_of_establishment'] = @$main_school->year_of_establishment;
        $upd['public_private'] =  @$main_school->public_private;
        $slug = Str::slug($request->school_name,"-");
        $upd['slug'] = @$slug."-".@$schoolBranch->id;
        $upd['gender'] = @$main_school->gender;
        $upd['board_id'] = @$main_school->board_id;
        $upd['boarding_type'] =  @$main_school->boarding_type;
        $upd['header_image'] = @$main_school->header_image;
        $upd['youtube_link'] = @$main_school->youtube_link;
        $upd['status'] = 'AA';
        if($request->other_town != null){

          $check_city = City::where('city',trim($request->other_town))->first();
          if(!$check_city){

              $insCity = [];
              $insCity['city'] = $request->other_town;
              $insCity['country_id'] = $request->country;
              $createCity = City::create($insCity);

              $upd['town'] = @$createCity->id;
          }else{

            $upd['town'] = @$check_city->id;
          }
      }else{

        $upd['town'] = $request->town;
      }

        if($request->school_master_name != null){

          if(@$main_school->school_logo){
            $upd['school_logo'] = @$main_school->school_logo;   
          }
          if(@$main_school->religion_id != null){
            $upd['religion_id'] = @$main_school->religion_id;   
          }
        }

        $update =  SchoolMaster::where('id',@$request->school_branch_id)->update($upd);

        $schooDetails = SchoolMaster::where('id',@$request->school_branch_id)->first();

      //  $school_type = SchoolToType::where('school_master_id',@$main_school->id)->pluck('school_type_id')->toArray();
      //  if(@$school_type){
      //      //dd(@$request->subject);

      //       $multi_schooltypes = array_filter($school_type);
      //      if(@$multi_schooltypes) {

      //        $schooDetails->school_types()->sync(@$multi_schooltypes);

      //      }

      //   }

      if(@$request->school_type){
        //dd(@$request->subject);

        $school_type = @$request->school_type;

          $multi_schooltypes = array_filter($school_type);
        if(@$multi_schooltypes) {

            $schooDetails->school_types()->sync(@$multi_schooltypes);

        }

        }

        $facilities = SchoolToFacilities::where('school_master_id',@$main_school->id)->pluck('facilities_id')->toArray();
    
        if(@$facilities)
        {
        $facilities = @$facilities;
        // return $skill;
        //dd(@$facilities);
        foreach ($facilities as $item) {
            $insFacilities = [];
            $insFacilities['school_master_id'] = @$create->id;
            $insFacilities['facilities_id'] = @$item;
            if(@$item){
                $checkAvailable =  SchoolToFacilities::where('school_master_id',@$create->id)->where('facilities_id', @$item)->first();
                if ($checkAvailable == null) {
                    SchoolToFacilities::create($insFacilities);
                }
            }

        }
        SchoolToFacilities::where('school_master_id',@$create->id)->whereNotIn('facilities_id',@$facilities)->delete();
        }

        $school_subject = SchoolSubject::where('school_master_id',@$main_school->id)->get();

        if(@$school_subject){

              foreach($school_subject as $subject){
                  $school_to_sub = SchoolToSubject::where('school_subject_id',@$subject->id)->pluck('subject_id')->toArray();
                  $insSub['school_master_id'] = @$create->id;
                  $insSub['curriculum'] =  @$subject->curriculum;
                  $insSub['class_level'] = @$subject->class_level;

                  $create_sub = SchoolSubject::create($insSub);

            
                  $multi_subject = array_filter($school_to_sub);
                  if(@$multi_subject) {
    
                    $create_sub->school_subjects()->sync(@$multi_subject);
    
                  }

              }
              
        }

        if(@$request->school_image != null){

            foreach($request->school_image as $image){
              $ins = [];
              $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
              Storage::putFileAs('public/images/school_image', $image, $filename);
              $ins['image'] = $filename;
              $ins['school_master_id'] = $request->school_branch_id;

              SchoolGallery::create($ins);
            }
        }

        if(@$update){ 
            session()->flash('success','School branch updated successfully');
            return redirect()->route('add.school.step8',[md5(@$request->school_master_id)]);
          }else{

            return redirect()->back()->with('error','Something went wrong');
            }   
        }
        
        $ins = [];
        //$ins['school_master_id'] = $request->school_master_id;
        $ins['user_id'] = Auth::user()->id;
        $ins['parent_id'] = $request->school_master_id;
        $ins['school_name'] = $request->school_name;
        $ins['about_school'] = @$main_school->about_school;
        $ins['about_school_facility'] = @$main_school->about_school_facility;
        $ins['contact_email'] = $request->email;
        $ins['contact_phone'] = $request->phone;
        $ins['country'] = $request->country;
        //$ins['constituency'] = $request->constituency;
        //$ins['town'] = $request->town;
        $ins['full_address'] = $request->full_address;
        $ins['google_location'] = $request->google_location;
        $ins['google_lat'] = $request->google_lat;
        $ins['google_long'] = $request->google_long;
        $ins['year_of_establishment'] = @$main_school->year_of_establishment;
        $ins['public_private'] =  @$main_school->public_private;
        //$upd['school_type_id'] = $request->school_type_id;
        //$upd['language_instruction_id'] = $request->language_instruction_id;
        $ins['gender'] = @$main_school->gender;
        //$ins['board_id'] = @$main_school->board_id;
        $ins['boarding_type'] =  @$main_school->boarding_type;
        $ins['header_image'] = @$main_school->header_image;
        $ins['youtube_link'] = @$main_school->youtube_link;
        $ins['status'] = 'AA';
        if($request->other_town != null){

          $check_city = City::where('city',trim($request->other_town))->first();
          if(!$check_city){

              $insCity = [];
              $insCity['city'] = $request->other_town;
              $insCity['country_id'] = $request->country;
              $createCity = City::create($insCity);

              $ins['town'] = @$createCity->id;
          }else{

            $ins['town'] = @$check_city->id;
          }
          }else{

              $ins['town'] = $request->town;
          }

        if($request->school_master_name != null){

          if(@$main_school->school_logo){
            $ins['school_logo'] = @$main_school->school_logo;   
          }
          if(@$main_school->religion_id != null){
            $ins['religion_id'] = @$main_school->religion_id;   
          }
        }
        
        $create = SchoolMaster::create($ins);
    
      $school_board = SchoolToBoard::where('school_master_id',@$main_school->id)->pluck('board_id')->toArray();
      if(@$school_board){
          //dd(@$request->subject);

            $multi_schoolboards = array_filter($school_board);
          if(@$multi_schoolboards) {

            $create->school_boards()->sync(@$multi_schoolboards);

          }

        }

      if(@$request->school_type){
        //dd(@$request->subject);

        $school_type = @$request->school_type;

          $multi_schooltypes = array_filter($school_type);
        if(@$multi_schooltypes) {

            $create->school_types()->sync(@$multi_schooltypes);

        }

      }

        $facilities = SchoolToFacilities::where('school_master_id',@$main_school->id)->pluck('facilities_id')->toArray();
    
        if(@$facilities)
        {
        $facilities = @$facilities;
        // return $skill;
        //dd(@$facilities);
        foreach ($facilities as $item) {
            $insFacilities = [];
            $insFacilities['school_master_id'] = @$create->id;
            $insFacilities['facilities_id'] = @$item;
            if(@$item){
                $checkAvailable =  SchoolToFacilities::where('school_master_id',@$create->id)->where('facilities_id', @$item)->first();
                if ($checkAvailable == null) {
                    SchoolToFacilities::create($insFacilities);
                }
            }

        }
        SchoolToFacilities::where('school_master_id',@$create->id)->whereNotIn('facilities_id',@$facilities)->delete();
        }

        $school_subject = SchoolSubject::where('school_master_id',@$main_school->id)->get();

        if(@$school_subject){

              foreach($school_subject as $subject){
                $school_to_sub = SchoolToSubject::where('school_subject_id',@$subject->id)->pluck('subject_id')->toArray();
                $insSub['school_master_id'] = @$create->id;
                $insSub['curriculum'] =  @$subject->curriculum;
                  $insSub['class_level'] = @$subject->class_level;

                $create_sub = SchoolSubject::create($insSub);

            
                $multi_subject = array_filter($school_to_sub);
                if(@$multi_subject) {
  
                  $create_sub->school_subjects()->sync(@$multi_subject);
  
                }

              }
            
        }

        if(@$request->school_image != null){

        foreach($request->school_image as $image){
          $ins = [];
          $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
          Storage::putFileAs('public/images/school_image', $image, $filename);
          $ins['image'] = $filename;
          $ins['school_master_id'] = @$create->id;

          SchoolGallery::create($ins);
        }
        }
        if($create){
          $updateSlug = [];
              $slug = Str::slug($request->school_name,"-");
              $updateSlug['slug'] = @$slug."-".@$create->id;
              SchoolMaster::where('id',@$create->id)->update($updateSlug);
              return redirect()->route('add.school.step8',[md5(@$request->school_master_id)]);
        }else{

            return redirect()->back()->with('error','Something went wrong');
        }
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
    return view('listSchool.add_school_step9');
  }

  public function addSchoolStep9FeesSave(Request $request){
    
      $check_school_fees = SchoolFees::where('grade',trim(@$request->grade))->where('school_master_id',$request->school_master_id)->first();
      if(@$check_school_fees){

          return redirect()->back()->with('error','This fees combination already added');
      }
    $ins = [];
    $ins['school_master_id'] = $request->school_master_id;
    $ins['grade'] = $request->grade;
    $ins['from_fees'] = $request->from_fees;
    $ins['to_fees'] = $request->to_fees;

    $create =  SchoolFees::create($ins);

    if(@$create){
      $school_fees = SchoolFees::where('school_master_id',@$request->school_master_id)->min('from_fees'); 
      SchoolMaster::where('id',@$request->school_master_id)->update(['starting_from_fees'=>@$school_fees]);
      //session()->flash('success','Teacher fees created successfully');
      return redirect()->route('add.school.step9',[md5(@$request->school_master_id)]);
    }
    else{

      return redirect()->back()->with('error','Something went wrong');
    }
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

  public function schoolSearch(Request $request){
    $countries = Country::all();
    $counties = County::all();
    $school_levels = SchoolLevel::all();
    $courses = Course::all();
    $school_types_day = SchoolType::where('name', 'Day')->first();
    $school_types_boarding = SchoolType::where('name', 'Boarding')->first();
    $school_types_day_n_boarding = SchoolType::where('name', 'Day & Boarding')->first();
    $schools = School::where('is_active', true)->latest()->get();
    
    return view('search_school.school_list')->with([
      'countries' => $countries,
      'counties' => $counties,
      'school_levels' => $school_levels,
      'courses' => $courses,
      'school_types_day' => $school_types_day,
      'school_types_boarding' => $school_types_boarding,
      'school_types_day_n_boarding' => $school_types_day_n_boarding,
      'schools' => $schools,
    ]);
  }
}
