<?php

namespace App\Http\Controllers;

use App\Models\County;
use App\Models\School;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SchoolController extends Controller
{
    public function addSchoolStep1($id=null){
      $schoolDetails = School::where(DB::raw('id'),@$id)->first();
      // if(Auth::user()){
      //   return view('listSchool.add_school_step1')->with([
      //     'school_details' => $schoolDetails,
      //   ]);
      // }else{
      //   Session::put(['type'=>'LS']);
      //   return redirect()->route('login');
      // }
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

    public function addSchoolStep2($id=null){
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
      // Store in session under a single key
      $stepData = [
          'school_name'      => $validated['school_name'],
          'about_school'     => $validated['about_school'],
          'contact_title'    => $validated['contact_title'],
          'contact_email'    => $validated['contact_email'],
          'contact_phone'    => $validated['contact_phone'],
          'country'          => $validated['country'],
          'town'             => $validated['town'],
          'full_address'     => $validated['full_address'],
          'google_location'  => $validated['google_location'] ?? null,
      ];

      // retrieving about data as follows
      // $step2 = Session::get('school_creation.step2');
      // $schoolName = $step2['school_name'] ?? '';

      Session::put('school_creation.step2', $stepData);
      
      return redirect()->route('school.create.step3'); // go to next step
    }

      public function addSchoolStep3($id=null){
        // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
        // $data['school_type'] = SchoolType::get();
        // $data['board'] = Board::where('id','!=',5)->get();
        // $data['language'] = Language::get();
        // $data['religion'] = Religion::get();
        // $data['facilities'] = Facilities::get();
        // $data['relationship'] = SchoolRelationship::get();
        // if($data['schoolDetails'] == null){

        //   return redirect()->back()->with('error','Something went wrong');
        // }
        // $data['school_facilities'] = SchoolToFacilities::where('school_master_id',@$data['schoolDetails']->id)->pluck('facilities_id')->toArray();
        // $data['school_to_type'] = SchoolToType::where('school_master_id',@$data['schoolDetails']->id)->pluck('school_type_id')->toArray();
        // $data['school_uniform'] = SchoolUniform::where('school_master_id',@$data['schoolDetails']->id)->get();
        // $data['school_to_board'] = SchoolToBoard::where('school_master_id',@$data['schoolDetails']->id)->pluck('board_id')->toArray();
        return view('listSchool.add_school_step3');
      }

      public function addSchoolStep3Save(Request $request){
        
        if($request->school_master_id){
            
            $schooDetails = SchoolMaster::where('id',$request->school_master_id)->first();    
            $upd = [];
            //$upd['school_name'] = $request->school_name;
            $upd['year_of_establishment'] = $request->year_of_establishment;
            $upd['public_private'] = $request->public_private;
            //$upd['school_type_id'] = $request->school_type_id;
            $upd['religion_id'] = $request->religion_id;
            $upd['gender'] = $request->gender;
            $upd['boarding_type'] = $request->boarding_type;

            if($request->other_relationship != null){
                $AvailableRalation = SchoolRelationship::where('relationship',trim($request->other_relationship))->first();
                if($AvailableRalation == null){
                    $other_relationship = trim($request->other_relationship);
                   $createRelation = SchoolRelationship::create(['relationship'=>$other_relationship]);
                  
                   $upd['relationship_id'] = @$createRelation->id;
                }else{

                   $upd['relationship_id'] = @$AvailableRalation->id;
                }
            }else{

               $upd['relationship_id'] = $request->relationship_id;
            }
            if($request->school_logo){

              $image = $request->school_logo;
              $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
              Storage::putFileAs('public/images/school_logo', $image, $filename);
              $upd['school_logo'] = $filename;
              @unlink(storage_path('app/public/images/school_logo/' . @$schooDetails->school_logo));
            
            }

            if(@$request->school_type){
                //dd(@$request->subject);

                $school_type = @$request->school_type;
    
                 $multi_schooltypes = array_filter($school_type);
                if(@$multi_schooltypes) {

                    $schooDetails->school_types()->sync(@$multi_schooltypes);

                }

             }

             if(@$request->board || @$request->other_board){
              //dd(@$request->subject);
              $boards = @$request->board;
            if(@$request->other_board){
              $board_r = @$request->other_board;
              $board_arr = explode(",", $board_r);
              $boardData = [];
              foreach($board_arr as $board){
                  $board = trim($board);
                  $exists = Board::where('board_name', $board)->first();
                  if(!@$exists){
                      $boardd = Board::create(["board_name"=>$board]);
                      array_push($boardData, $boardd->id);
                  } else {
                      array_push($boardData, $exists->id);
                  }
              }
             }
             //$multi_boards = [];
              if(@$boardData == null) {
                  $multi_boards =array_filter($boards); 
                  $schooDetails->school_boards()->sync($multi_boards);
   
              }
              else if($boards && @$boardData){
                  $multi_boards =array_filter($boards);
                  $com_board = array_merge($multi_boards,@$boardData);
                  $uni_board = array_unique($com_board);
                  $schooDetails->school_boards()->sync($uni_board);
              }
              else if(@$boardData){

                $schooDetails->school_boards()->sync($boardData);
              }
            }

            $update =  SchoolMaster::where('id',@$request->school_master_id)->update($upd);



            if(@$request->facilities)
            {
            $facilities = @$request->facilities;
            // return $skill;
            foreach ($facilities as $item) {
                $insFacilities = [];
                $insFacilities['school_master_id'] = $request->school_master_id;
                $insFacilities['facilities_id'] = @$item;
                if(@$item){
                    $checkAvailable =  SchoolToFacilities::where('school_master_id', @$request->school_master_id)->where('facilities_id', @$item)->first();
                    if ($checkAvailable == null) {
                        SchoolToFacilities::create($insFacilities);
                    }
                }
    
            }
            SchoolToFacilities::where('school_master_id', @$request->school_master_id)->whereNotIn('facilities_id', @$facilities)->delete();
            }
            if(@$request->other_facilities)
                {
                    $order_facilities = explode(",", @$request->other_facilities);
                    // return $skill;
                    foreach ($order_facilities as $item) {
                        $ins = [];
                        $ins['facilities_name'] = @$item;
                        if(@$item){
                            $item = trim($item);
                            $checkAvailable =  Facilities::where('facilities_name', @$item)->first();
                            if ($checkAvailable == null) {
                                $createFacility = Facilities::create($ins);
    
                                $insotherF = [];
                                $insotherF['school_master_id'] = @$request->school_master_id;
                                $insotherF['facilities_id'] = @$createFacility->id;
                                SchoolToFacilities::create($insotherF);
                            }else
                            {
                                $insotherF = [];
                                $insotherF['school_master_id'] = @$request->school_master_id;
                                $insotherF['facilities_id'] = @$checkAvailable->id;
                                SchoolToFacilities::create($insotherF);
                            }
                        }
    
                    }
                    // JobToSkill::where('job_id', @$job->id)->whereNotIn('skill_id', @$skill)->delete();
                }
            
            if(@$update){

                session()->flash('success','School basic information updated successfully');
                if(@$request->status == 'CO'){

                  return redirect()->route('add.school.step4',[md5(@$schooDetails->id)]);
                }else{

                  return redirect()->route('add.school.step3',[md5(@$schooDetails->id)]);
                }
                
            }else{

                return redirect()->back()->with('error','Something went wrong');
              }   
            }
         
      }


    public function addSchoolStep3UniformSave(Request $request){

        if($request->school_uniform_id){
             $uniforDetails = SchoolUniform::where('id',$request->school_uniform_id)->first();
             $upd = [];
             $upd['school_master_id'] = $request->school_master_id;
             $upd['uniform_type'] = $request->uniform_type;
             $upd['uniform_title'] = $request->uniform_title;
             if($request->uniform_image){

             $image = $request->uniform_image;
             $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
             Storage::putFileAs('public/images/uniform_image', $image, $filename);
             $upd['uniform_image'] = $filename;
             @unlink(storage_path('app/public/images/uniform_image/' . @$uniforDetails->uniform_image));
         
             }

             $update = SchoolUniform::where('id',$request->school_uniform_id)->update($upd);
             if(@$update){

                 session()->flash('success','School uniform updated successfully');
                 return redirect()->route('add.school.step3',[md5(@$request->school_master_id)]);
             }else{
 
                 return redirect()->back()->with('error','Something went wrong');
             }
        }

        $ins = [];
        $ins['school_master_id'] = $request->school_master_id;
        $ins['uniform_type'] = $request->uniform_type;
        $ins['uniform_title'] = $request->uniform_title;
        if($request->uniform_image){

         $image = $request->uniform_image;
         $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
         Storage::putFileAs('public/images/uniform_image', $image, $filename);
         $ins['uniform_image'] = $filename;
       
        }
        
       $create = SchoolUniform::create($ins);
       if(@$create){

         session()->flash('success','School uniform created successfully');
         return redirect()->route('add.school.step3',[md5(@$request->school_master_id)]);
       }else{

         return redirect()->back()->with('error','Something went wrong');
       }
   
}

    public function schoolUniformDelete($id=null){

    $uniform = SchoolUniform::where('id',@$id)->first();
    if(@$uniform == null){

     return redirect()->back()->with('error','Something went wrong');
    }

    $uniform->delete();
    return redirect()->route('add.school.step3',[md5(@$uniform->school_master_id)]); 
   }

   public function addSchoolStep4($id=null){
    // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
    // if($data['schoolDetails'] == null){

    //   return redirect()->back()->with('error','Something went wrong');
    // }
    //$data['school_gallery'] = SchoolGallery::where('school_master_id',@$data['schoolDetails']->id)->get();

    return view('listSchool.add_school_step4');
  }

   public function addSchoolStep4RatioSave(Request $request){
    
    $upd = [];
    $upd['teacher_student_ratio'] = $request->teacher_student_ratio;
    $upd['show_ratio'] = $request->show_ratio ? $request->show_ratio:'N';
    $upd['total_student'] = $request->total_student;
    $upd['student_boys'] = $request->student_boys;
    $upd['student_girls'] = $request->student_girls;
    $upd['total_teacher'] = $request->total_teacher;
    $upd['teacher_male'] = $request->teacher_male;
    $upd['teacher_female'] = $request->teacher_female;
    

   $update = SchoolMaster::where('id',@$request->school_master_id)->update($upd);
    if(@$update){

        session()->flash('success','Teacher student ratio updated successfully');
        return redirect()->route('add.school.step4',[md5(@$request->school_master_id)]);
    }else{

        return redirect()->back()->with('error','Something went wrong');
    }
  }

    public function addSchoolStep4RulesSave(Request $request){
        //dd($request);
        $upd = [];
        $upd['meal_offer'] = $request->meal_offer?$request->meal_offer:'N';
        $upd['special_need_catered'] = $request->special_need_catered?$request->special_need_catered:'N';
        $upd['school_transport_available'] = $request->school_transport_available?$request->school_transport_available:'N';
        $upd['day_learn_period_from'] = date('H:i',strtotime(@$request->day_learn_period_from));
        $upd['day_learn_period_until'] = date('H:i',strtotime(@$request->day_learn_period_until));
        $upd['evening_studies_from'] = date('H:i',strtotime(@$request->evening_studies_from));
        $upd['evening_studies_until'] = date('H:i',strtotime(@$request->evening_studies_until));

        $update = SchoolMaster::where('id',@$request->school_master_id)->update($upd);
        if(@$update){

            session()->flash('success','School rules updated successfully');
            return redirect()->route('add.school.step4',[md5(@$request->school_master_id)]);
        }else{

            return redirect()->back()->with('error','Something went wrong');
        }
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
        $schooDetails = SchoolMaster::where('id',$request->school_master_id)->first();
        $upd = []; 
        // if(@$request->youtube_link){
        //   $d = stripos(@$request->youtube_link,'watch');
        //   if(@$d){
        //       $d1 = substr(@$request->youtube_link,$d);
        //       $a = strpos($d1,'=');
        //       $sum= $d+$a+1;
        //       $x = substr(@$request->youtube_link,$sum);
              
        //       $upd['youtube_link'] = $x;
        //   }else{

        //       $pieces = explode("/", @$request->youtube_link);
        //       $url = end($pieces);
        //       $n = strpos($url,'=');
        //       $url2 = substr($url,$n);
              
          
        //       $upd['youtube_link'] = $url2;

        //   }
      
        // }

        // if($request->header_image){

        //   $image = $request->header_image;
        //   $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
        //   Storage::putFileAs('public/images/school_image', $image, $filename);
        //   $upd['header_image'] = $filename;
        //   @unlink(storage_path('app/public/images/school_image/' . @$schooDetails->header_image));
        
        // }

        //SchoolMaster::where('id',@$request->school_master_id)->update($upd);

         if(@$request->school_image != null){

              foreach($request->school_image as $image){
                $ins = [];
                $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs('public/images/school_image', $image, $filename);
                $ins['image'] = $filename;
                $ins['school_master_id'] = $request->school_master_id;

                  SchoolGallery::create($ins);
              }

              session()->flash('success','Gallery created successfully');
              return redirect()->route('add.school.step6',[md5(@$request->school_master_id)]);
         }else{
            return redirect()->route('add.school.step6',[md5(@$request->school_master_id)]);
         }
      }


      public function addSchoolStep6($id=null,$sub_id=null){

        // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
        // $data['class_level'] = ClassLevel::where('board_id','=',1)->get();
        // $data['board'] = Board::where('id','!=',5)->get();
        // $data['subjects'] = Subject::get();
        // if($data['schoolDetails'] == null){

        //   return redirect()->back()->with('error','Something went wrong');
        // }
        // $data['school_subject'] = SchoolSubject::where('school_master_id',@$data['schoolDetails']->id)->get();
        //  $data['subjec_detail'] = SchoolSubject::where('id',@$sub_id)->first();
        //    if($data['subjec_detail']){

        //  $data['class_level'] = ClassLevel::where('board_id',@$data['subjec_detail']->curriculum)->get();
        //   }
        //   $data['school_to_subject_id'] = SchoolToSubject::where('school_subject_id',@$data['subjec_detail']->id)->pluck('subject_id')->toArray();
        return view('listSchool.add_school_step6');
      }

      public function addSchoolStep6SubjectSave(Request $request){

        $ins = [];
       if($request->other_class_level){

           $available_class_level = ClassLevel::where('board_id',$request->board_id)->where('class_level',trim($request->other_class_level))->first();
           if($available_class_level == null){

                $insClasslevel = [];
                $insClasslevel['board_id'] = $request->board_id;
                $insClasslevel['class_level'] = $request->other_class_level;

               $createClassLev =  ClassLevel::create($insClasslevel);

               $ins['school_master_id'] = $request->school_master_id;
               $ins['curriculum'] = $request->board_id;
                $ins['class_level'] = @$createClassLev->id;

           }else{

               $ins['school_master_id'] = $request->school_master_id;
               $ins['curriculum'] = $request->board_id;
                $ins['class_level'] = @$available_class_level->id;
           }

       }else{

           $ins['school_master_id'] = $request->school_master_id;
          $ins['curriculum'] = $request->board_id;
           $ins['class_level'] = $request->class_level;
       }

       if($request->subject_id){

           SchoolSubject::where('id',$request->subject_id)->update($ins);
           $school_subject = SchoolSubject::where('id',$request->subject_id)->first();
           $create = $school_subject;
       }else{

           $create = SchoolSubject::create($ins);
       }
          
       if(@$request->subject){
           //dd(@$request->subject);
           $subjects = @$request->subject;
       if(@$request->other_subject){
           $subject_r = @$request->other_subject;
           $subject_arr = explode(",", $subject_r);
           $sub = [];
           foreach($subject_arr as $subj){
               $subj = trim($subj);
               $exists = Subject::where('subject', $subj)->first();
               if(!@$exists){
                   $subject = Subject::create(["subject"=>$subj]);
                   array_push($sub, $subject->id);
               } else {
                   array_push($sub, $exists->id);
               }
           }
       }
       $multi_subjects =array_filter($subjects);
           if(@$sub == null) {

               $create->school_subjects()->sync($multi_subjects);

           }else{
               $com_subject = array_merge($multi_subjects,@$sub);
               $uni_sub = array_unique($com_subject);
               $create->school_subjects()->sync($uni_sub);
           }
         }

         if(@$create){

           session()->flash('success','subject created successfully');
           return redirect()->route('add.school.step6',[md5(@$request->school_master_id)]);
          }
          else{

           return redirect()->back()->with('error','Something went wrong');
         }

     }

     public function schoolSubjectDelete($id=null){

           $check_subject = SchoolSubject::where('id',@$id)->first();
           if($check_subject == null){

               return redirect()->back()->with('error','Something went be wrong');
           }

           SchoolToSubject::where('school_subject_id',@$check_subject->id)->delete();
           SchoolSubject::where('id',@$id)->delete();
           return redirect()->back()->with('success','School subject deleted successfully');
     }

     public function addSchoolStep7($id=null,$result_id=null){
        // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
        // $data['country'] = Country::get();
        // $data['board'] = Board::where('id','!=','5')->get();
        // if($data['schoolDetails'] == null){

        //   return redirect()->back()->with('error','Something went wrong');
        // }
        // $data['school_result'] = SchoolResult::where('school_master_id',@$data['schoolDetails']->id)->get();
        // $data['schoolResult'] = SchoolResult::where('id',@$result_id)->where('school_master_id',@$data['schoolDetails']->id)->first();
        return view('listSchool.add_school_step7');
    }

    public function addSchoolStep7Save(Request $request){

           $ins = [];
           $ins['school_master_id'] = $request->school_master_id;
           $ins['year'] = $request->year;
           $ins['board_id'] = $request->board_id;
           $ins['exam'] = $request->exam;
           $ins['ranking_position'] = $request->ranking_position;
           $ins['region'] = $request->region;
           $ins['mean_score_point'] = $request->mean_score_point;
           $ins['mean_grade'] = $request->mean_grade;
           
           if($request->school_result_id){
              SchoolResult::where('id',$request->school_result_id)->update($ins);
             $result = SchoolResult::where('id',$request->school_result_id)->first();
             $create = $result;
           }
           else{

            $create = SchoolResult::create($ins);
           }

          if($request->grade && $request->no_of_candidate){
            SchoolResultDetail::where('school_result_id',@$create->id)->delete();
            foreach($request->grade as $key1=>$grade){

                $insreDetail['school_result_id'] = @$create->id;
                $insreDetail['grade'] = @$grade;

                foreach($request->no_of_candidate as $key2=>$candidate){
                      if(@$key1 == $key2){
                       $insreDetail['no_of_candidates'] = @$candidate;
                      }
                }
                //$check_grade = SchoolResultDetail::where('grade',trim($grade))->first();
                if($grade != null){
                   SchoolResultDetail::create($insreDetail);
                }

               
            }
       }
       if($create){
        session()->flash('success','School result created successfully');
        return redirect()->route('add.school.step7',[md5(@$request->school_master_id)]);
       }else{

          return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function addSchoolStep8($id=null,$branch_id=null){
        // $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->where('parent_id','=',0)->first();
        // $data['country'] = Country::get();
        // //$data['cities'] = City::orderBy('city','asc')->get();
        // $data['school_type'] = SchoolType::get();
        // if($data['schoolDetails'] == null){

        //   return redirect()->back()->with('error','Something went wrong');
        // }
        // $data['school_branches'] =  SchoolMaster::where('parent_id',@$data['schoolDetails']->id)->get();
        // $data['schoolBranchDetails'] = SchoolMaster::where('id',@$branch_id)->where('parent_id',@$data['schoolDetails']->id)->first();
        // $data['schoolBranchImage'] = SchoolGallery::where('school_master_id',@$data['schoolBranchDetails']->id)->get();
        // $data['cities'] = City::where('country_id',@$data['schoolBranchDetails']->country)->orderBy('city','asc')->get();
        // $data['school_to_type'] = SchoolToType::where('school_master_id',@$data['schoolBranchDetails']->id)->pluck('school_type_id')->toArray();
        return view('listSchool.add_school_step8');
    }

    public function addSchoolStep8Save(Request $request){

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

     
  public function schoolImageDelete($id=null){

    $school_image = SchoolGallery::where('id',@$id)->first();
    if($school_image){

        @unlink(storage_path('app/public/images/school_image/' . @$school_image->image));
        $school_image->delete();

        return redirect()->back();
    }else{

        return redirect()->back()->with('error','Something went wrong');
    }

}

    public function addSchoolStep9($id=null,$status=null){

        $data['schoolDetails'] = SchoolMaster::where(DB::raw('md5(id)'),@$id)->first();
        if($data['schoolDetails'] == null){

          return redirect()->back()->with('error','Something went wrong');
        }
        if(@$status == 'CO'){

          return redirect()->back()->with('success','Thank you for submitting your School listing on Muhula, it is going through our approval process. You will be notified shortly via email once it has been approved.');
      }
        $data['school_fees'] = SchoolFees::where('school_master_id',@$data['schoolDetails']->id)->get();
        return view('modules.school.add_school_step9')->with($data);
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
}
