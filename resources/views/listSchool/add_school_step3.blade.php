@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
<style>
  .error{

     color:red !important;
     text-transform: none !important;
  }
</style>
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="add-school-container">
         <div class="container">
            <div class="row">
            {{--@include('includes.message')--}}
               <div class="col-lg-8">
                  <div class="add-schl-lft">
                     <div class="ad-schl-card adscl-crd1">
                        <h1>Add School</h1>
                        <p>Add your school for Free and start connecting with learners...</p>
                        <div class="adschl-steps-list">
                           <ul>
                              {{-- <li class="done"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                    <h6>School Register</h6>
                                 </div>                                 
                              </li> --}}
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                 <h6>Basic Information</h6>
                                 </div>
                                 
                              </li>
                              <li class="ongoing"><em></em>
                                 <div>
                                    <small>Step 2</small>
                                 <h6>School Details</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 3</small>
                                 <h6>Extra Info</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 4</small>
                                 <h6>School Gallery</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 6</small>
                                    <h6>Result</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 7</small>
                                    <h6>Branches</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 8</small>
                                    <h6>School Fees</h6>
                                 </div>                                 
                              </li>
                           </ul>
                        </div>
                     </div>
                    
                     <div class="ad-schl-card adscl-crd2">
                        <form action="{{ route('add.school.step3.save') }}" method="POST" enctype="multipart/form-data" id="schoolForm">
                           @csrf
                           <div class="row">
                              {{-- 🔹 School Logo --}}
                              <div class="col-12">
                                    <div class="dash_input">
                                       <label for="school_logo">School Logo (Optional)</label>
                                       <div class="row align-items-center">
                                          <div class="col-lg-6 col-sm-6">
                                                <div class="uplodimgfil2">
                                                   <input type="file" name="school_logo" id="school_logo" class="inputfile2 inputfile-1">
                                                   <label for="school_logo">
                                                      <h3>Click here to upload</h3>
                                                      <img src="{{ asset('images/upload1.png') }}" alt="">
                                                   </label>
                                                </div>
                                                @error('school_logo')
                                                   <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                          </div>
                                       </div>
                                    </div>
                              </div>

                              {{-- 🔹 School Ownership --}}
                              <div class="col-12">
                                    <label><b>School Ownership <span style="color: red;">*</span></b></label>
                                    <div class="check_gender adscl-type">
                                       <ul>
                                          <li>
                                                <input type="radio" name="ownership_type" value="Public">
                                                <label><p>Public</p></label>
                                          </li>
                                          <li>
                                                <input type="radio" name="ownership_type" value="Private">
                                                <label><p>Private</p></label>
                                          </li>
                                       </ul>
                                    </div>
                                    @error('ownership_type')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Year of Establishment --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>Year of Establishment <span style="color: red;">*</span></label>
                                       <input type="text" name="year_of_establishment" id="year_of_establishment" placeholder="Enter here"
                                          value="{{ old('year_of_establishment') }}"
                                          oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                    </div>
                                    @error('year_of_establishment')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 School Levels --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>School Levels <span style="color: red;">*</span></label>
                                       <select multiple name="school_level_id[]" id="school_level" class="filter-multi-select">
                                          @foreach($school_levels as $level)
                                                <option value="{{ $level->id }}" @selected(collect(old('school_level_id'))->contains($level->id))>
                                                   {{ $level->name }}
                                                </option>
                                          @endforeach
                                       </select>
                                    </div>
                                    @error('school_level_id')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Curricula --}}
                              <div class="col-12">
                                    <div class="dash_input">
                                       <label>Curriculum <span style="color: red;">*</span></label>
                                       <ul class="category-ul agree d-flex flex-wrap row-gap-2">
                                          @foreach($school_curricula as $curriculum)
                                                <li>
                                                   <div class="radiobx">
                                                      <label>{{ $curriculum->name }}
                                                            <input type="checkbox" name="curricula[]" value="{{ $curriculum->name }}"
                                                               @checked(is_array(old('curricula')) && in_array($curriculum->name, old('curricula'))) />
                                                            <span class="checkbox"></span>
                                                      </label>
                                                   </div>
                                                </li>
                                          @endforeach
                                       </ul>
                                    </div>
                                    @error('curricula')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Gender --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input mb-1">
                                       <label>Gender <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="check_gender adscl-type">
                                       <ul>
                                          <li><input type="radio" name="gender" value="Male" @checked(old('gender') == 'Male')> <label><p>Male</p></label></li>
                                          <li><input type="radio" name="gender" value="Female" @checked(old('gender') == 'Female')> <label><p>Female</p></label></li>
                                          <li><input type="radio" name="gender" value="Mixed" @checked(old('gender') == 'Mixed')> <label><p>Both</p></label></li>
                                       </ul>
                                    </div>
                                    @error('gender')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 School Type --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input mb-1">
                                       <label>Type <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="check_gender adscl-type adscl-tp2">
                                       <ul>
                                          <li><input type="radio" name="school_type_id" value="{{ $school_types_day->id }}" @checked(old('school_type_id') == $school_types_day->id)> <label><p>Day</p></label></li>
                                          <li><input type="radio" name="school_type_id" value="{{ $school_types_boarding->id }}" @checked(old('school_type_id') == $school_types_boarding->id)> <label><p>Boarding</p></label></li>
                                          <li><input type="radio" name="school_type_id" value="{{ $school_types_day_n_boarding->id }}" @checked(old('school_type_id') == $school_types_day_n_boarding->id)> <label><p>Day & Boarding</p></label></li>
                                       </ul>
                                    </div>
                                    @error('school_type_id')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Relationship --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>What is your Relationship with this School? <span style="color: red;">*</span></label>
                                       <select name="contact_relationship_id" id="contact_relationship_id">
                                          <option value="">Select</option>
                                          @foreach($school_contact_positions as $position)
                                                <option value="{{ $position->id }}" @selected(old('contact_relationship_id') == $position->id)>
                                                   {{ $position->name }}
                                                </option>
                                          @endforeach
                                       </select>
                                    </div>
                                    @error('contact_relationship_id')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Religion --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>Religion <span style="color: red;">*</span></label>
                                       <select name="religion_id" id="religion_id">
                                          <option value="">Select</option>
                                          @foreach($school_religion as $religion)
                                                <option value="{{ $religion->id }}" @selected(old('religion_id') == $religion->id)>
                                                   {{ $religion->name }}
                                                </option>
                                          @endforeach
                                       </select>
                                    </div>
                                    @error('religion_id')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>
                           </div>

                           {{-- 🔹 Facilities --}}
                           <h2 class="mt-4">Facilities / Amenities <span style="color: red;">*</span></h2>
                           <div class="row">
                              <div class="col-12">
                                    <div class="amenities-select">
                                       <div class="row">
                                          @foreach($facilities as $facility)
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                   <div class="radiobx amn-div">
                                                      <label>{{ $facility->name }}
                                                            <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                                               @checked(is_array(old('facilities')) && in_array($facility->id, old('facilities'))) />
                                                            <span class="checkbox"></span>
                                                      </label>
                                                   </div>
                                                </div>
                                          @endforeach
                                       </div>
                                    </div>
                                    @error('facilities')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>

                              {{-- 🔹 Other Facilities --}}
                              <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>Other Facilities / Amenities</label>
                                       <input type="text" name="other_facilities" placeholder="Enter here" value="{{ old('other_facilities') }}">
                                    </div>
                                    @error('other_facilities')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                              </div>
                           </div>

                           {{-- <div class="col-12">
                              <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                           </div> --}}
                        
                        {{-- <div class="ad-schl-card adscl-crd6">
                           <h2>Uniform</h2>
                           <form action="{{ route('add.school.step3.uniform.save') }}" method="post" enctype="multipart/form-data" id="uniformForm">
                              @csrf
                              
                              <div class="row">
                                 <div class="col-12">
                                    <div class="uni-type">
                                       <label for="uniform_type_male" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_male" value="Male" checked>
                                          <span class="uni-text"><img src="{{ asset('images/uni-male.png') }}" alt="">Male</span>                            
                                       </label>
                                       <label for="uniform_type_female" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_female" value="Female">
                                          <span class="uni-text"><img src="{{ asset('images/uni-female.png') }}" alt="">Female</span>                            
                                       </label>
                                       <label for="uniform_type_mixed" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_mixed" value="Mixed">
                                          <span class="uni-text"><img src="{{ asset('images/uni-unisex.png') }}" alt="">Unisex</span>                            
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="dash_input">
                                       <label>Uniform Title <small>(Optional)</small></label>
                                       <input type="text" name="uniform_title" id="uniform_title" placeholder="Enter here">
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="dash_input">
                                       <label>Uniform Image</label>
                                       <div class="uplodimgfil2">
                                          <input type="file" name="uniform_image" id="uniform_image" class="inputfile2 inputfile-1">
                                          <label for="uniform_image">                                          
                                             <h3>Click here to upload </h3>
                                             <img src="{{ asset('images/upload1.png') }}" alt="">
                                          </label>
                                       </div>
                                       <label for="" id="showFilename" style="display:none;"></label>
                                       <label id="uniformImage_error" for="" class="error" style="display:none;"></label>
                                    </div>                              
                                 </div>
                                 <div class="col-12">
                                          <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                 </div>
                                 <div class="col-12">
                                    <div class="uploaded-uniform">
                                       @if($school_uniform)
                                          @foreach($school_uniform as $data)
                                             <div class="upld-uniform-div">
                                                <em>
                                                   @if($data->image != null)
                                                      <img src="{{ URL::to('storage/app/public/images/uniform_image') }}/{{ $data->image }}" alt="">
                                                   @endif
                                                </em>
                                                <h6>
                                                   @if($data->gender == 'Male')
                                                   Male
                                                   @elseif($data->gender == 'Female')
                                                   Female
                                                   @elseif($data->gender == 'Mixed')
                                                   Unisex
                                                   @endif
                                                </h6>
                                                <p>{{ $data->name }}</p>
                                                <a href="{{ route('school.uniform.delete',$data->id) }}" class="uni-delet">
                                                   <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <path d="M9 3L3 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                      <path d="M3 3L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                   </svg>                                       
                                                </a>
                                             </div>
                                          @endforeach
                                       @endif
                                       <div class="upld-uniform-div">
                                          <em><img src="{{ url('public/images/uniform-girl.png') }}" alt=""></em>
                                          <h6>Female</h6>
                                          <p>Uniform title here</p>
                                          <a href="javascript:void(0);" class="uni-delet">
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 3L3 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M3 3L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                       
                                          </a>
                                       </div>
                                    </div>
                                 </div>
                              </div> 
                           </form>                      
                        </div> --}}
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                    <button type="submit" id="submitBtn" data-value="CO">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                       </svg>
                                    </button>
                                 <a href="{{ route('add.school.step2') }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 3 Of 9</p>
                           </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="add-schl-r8">
                     <div class="ad-schl-rtcrd">                        
                        <em><span class="cardimg-line-top"></span><img src="{{ asset('images/ad-schl-rt.png') }}" alt=""><span class="cardimg-line-bottom"></span></em>   
                        <span class="line-img-btm"></span>        
                        <h2>Listing your School will help others make informed choices on their educational journey</h2> 
                        <!-- <ul>
                           <li>In publishing and graphic design, Lorem ipsum is a placeholder sample caption</li>
                           <li>Lorem Ipsum is simply dummy text</li>
                           <li>In publishing and graphic design lorem ipsum is a placeholder</li>
                        </ul>             -->
                        <p>Our diverse directory ensures that we cater to a wide array of educational interests and goals while helping you connect with learners, parents/guardians along their education journey!</p>           
                     </div>
                     <h6>Please follow our <a href="#">Guidelines</a></h6>
                  </div>
               </div>
            </div>
         </div>
      </section>
 @endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')

@endsection 