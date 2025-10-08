@extends('layouts.app')
@section('title','Edit School Info')
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
<section class="after_login_body">
         <div class="container-fluid top-container">
            <div class="row">
            @include('includes.sidebar')
               <div class="dashboard_right_panel">
                  <div class="dashboard_right_heading">
                     <h3>Edit School Info</h3>
                     <p>Here you can update school information.</p>
                  </div>
                  <div class="dashboard_box">
                    @include('includes.message')
                     <div class="search_school_box m-0">
                        <div class="ser_img">
                           <span class="res-tab m-0">
                             @if(@$schoolDetails->public_private == 'PB')
                              Public
                              @elseif(@$schoolDetails->public_private == 'PR')
                              Private
                              @endif
                           </span>
                           @if(@$schoolDetails->getSchoolMainImage->image != null)
                           <a href="{{ route('school.details',@$schoolDetails->slug) }}"><img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$schoolDetails->getSchoolMainImage->image }}" alt=""></a>
                           @endif 
                        </div>
                        <div class="serach_sc_details">
                           <div class="search_heading_box">
                                <div class="search_heading">
                                    <a href="{{ route('school.details',$school->slug) }}">
                                        <h3>
                                            @if(strlen($school->name)>50)
                                                {{ substr($school->name,0,50) }}
                                            @else
                                                {{ $school->name }}
                                            @endif
                                        </h3>
                                    </a>
                                    <ul>
                                        @if(@$schoolDetails->avg_review)
                                            @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                                            @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                                                <li>
                                                    <img src="{{ url('public/images/fstar.png') }}" alt="">
                                                </li>
                                            @endfor
                                            @if(strpos($schoolDetails->avg_review,'.'))
                                                <li><img src="{{asset('public/images/star-half.png')}}"></li>
                                                @php $sst++; @endphp
                                            @endif
                                            @while ($sst<=5)
                                                <li><img src="{{ url('public/images/lstar.png') }}" alt=""></li>
                                                @php $sst++; @endphp
                                            @endwhile
                                        @else
                                            @for($sst = 1; $sst <= 5; $sst++)
                                                <li><img src="{{ url('public/images/lstar.png') }}" alt=""></li>                              
                                            @endfor
                                        @endif
                                    </ul>
                              </div>

                              <div class="search_price">
                                <h3>
                                    Fees: <span>KES{{ @$schoolDetails->starting_from_fees }}</span>
                                </h3>
                                <p>
                                    <img src="{{ url('public/images/map-pin.png') }}" alt="">{{ @$schoolDetails->getCountry->name }} {{ @$schoolDetails->town?','.@$schoolDetails->getTown->city:'' }}
                                </p>
                            </div>
                        </div>

                        <p class="sc_des"> 
                            @if(strlen(@$schoolDetails->about_school)>500)
                           {{ substr(@$schoolDetails->about_school,0,500) }}
                           @else
                           {{ @$schoolDetails->about_school }}
                            @endif
                        </p>

                           <div class="box_info">
                              <div class="type_list">
                                 <div class="tpe_p">
                                    <span>Type: </span>
                                    <p>
                                    @if(@$schoolDetails->school_types)
                                    @foreach(@$schoolDetails->school_types as $key=>$schtype)
                                    {{ @$key > 0?',':'' }} {{ @$schtype->school_type }}
                                    @endforeach
                                    @endif  
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Board: </span>
                                    <p>
                                    @if(@$schoolDetails->school_boards)
                                    @foreach(@$schoolDetails->school_boards as $key=>$schoolboard)
                                    {{ @$key > 0?',':'' }} {{ @$schoolboard->board_name }}
                                    @endforeach
                                    @endif
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Gender: </span>
                                    <p>
                                    @if(@$schoolDetails->gender == 'M')
                                    Male
                                    @elseif(@$schoolDetails->gender == 'F')
                                    Female
                                    @elseif(@$schoolDetails->gender == 'B')
                                    Both
                                    @endif  
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Shifting: </span>
                                    <p>
                                       @if(@$schoolDetails->boarding_type == 'D')
                                       Day
                                       @elseif(@$schoolDetails->boarding_type == 'B')
                                       Boading
                                       @elseif(@$schoolDetails->boarding_type == 'DB')
                                       Day & Boading
                                       @endif  
                                    </p>
                                 </div>
                              </div>
                              <a href="{{ route('school.details',$school->slug) }}" class="view_btns">View School <img src="{{ url('public/images/chevron-rights.png') }}" alt=""> </a>
                           </div>

                        </div>
                     </div>

                  </div>

                  <div class="dashboard_box mt-4">
                     <form action="{{ route('user.school.info.update') }}" method="post" id="schoolInfoForm">
                       @csrf
                       <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}"> 
                       <div class="row">

                        {{--<div class="col-12">
                                 <div class="dash_input">
                                    <label for="">School Logo</label>
                                    <div class="row align-items-center">
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uplodimgfil2">
                                             <input type="file" name="school_logo" id="school_logo" class="inputfile2 inputfile-1" data-multiple-caption="{count} files selected">
                                             <label for="school_logo">                                          
                                                <h3>Click here to upload </h3>
                                                <img src="{{ url('public/images/upload1.png') }}" alt="">
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uploaded-img position-relative">
                                              @if(@$schoolDetails->school_logo != null)
                                              <img src="{{ URL::to('storage/app/public/images/school_logo') }}/{{ @$schoolDetails->school_logo }}" alt="">
                                              @endif
                                          </div>
                                       </div>
                                    </div>                                
                                 </div>
                              </div>--}}

                           <div class="col-lg-6 col-md-6">
                               <div class="dash_input mb-2">
                                 <label>School Name</label>
                                 <input type="text" name="school_name" placeholder="Enter here"  value="{{ $school->name }}">
                               </div>
                           </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="dash_input">
                                <label>School Type</label>
                                <select multiple name="school_type[]" id="school_type" class="filter-multi-select">
                                    @foreach($school_types as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                                <label id="school_type[]-error" class="error" for="school_type[]" style="display:none;">This field is required.</label>
                                </div>
                                
                            </div>
                            <div class="col-12">
                                <div class="dash_input">
                                    <label>Curriculum</label>
                                    <ul class="category-ul agree d-flex justify-content-start align-items-center">
                                        @if(!empty($curricular))
                                            @foreach($curricular as $key => $data)
                                                <li>
                                                    <div class="radiobx">
                                                        <label>
                                                            {{ $data->name }}
                                                            <input 
                                                                type="checkbox" 
                                                                value="{{ $data->id }}" 
                                                                data-board_name="{{ $data->name }}" 
                                                                name="board[]"  
                                                                id="agree{{ $key + 1 }}"
                                                                class="quote-label board"
                                                                @if(in_array($data->id, $selected_school_curricula ?? [])) checked @endif
                                                            >
                                                            <span class="checkbox"></span>
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                        <li>
                                            <div class="radiobx">
                                                <label>Others
                                                    <input 
                                                        type="checkbox" 
                                                        name="board_id" 
                                                        id="otherpetdrop1" 
                                                        class="board" 
                                                        data-board_name="Others">
                                                    <span class="checkbox"></span>
                                                </label>
                                            </div>
                                        </li>                                   
                                    </ul>
                                    <label id="board[]-error" class="error" for="board[]" style="display:none;">This field is required.</label>
                                </div>
                            </div>
                              <div class="col-lg-6 col-md-6" id="otherPet1" style="display:none;">
                                 <div class="dash_input">
                                    <label>Other Board</label>
                                    <input type="text" name="other_board" id="other_board" value="" placeholder="Enter here">
                                 </div>
                              </div>
                             
                              <div class="clearfix"></div>
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
                       </div>
                     <div class="row">
                        <div class="dash_input">
                           <label>About School</label>
                           <textarea placeholder="Write your reply" name="about_school">{{ $school->description }}</textarea>
                        </div>
                     </div>

                        <div class="row more-contact-info">
                           <div class="col-sm-12 cols">
                              <div class="dash_inner_heading mt-1 add-more-btn add-more-btn2">
                              <a href="javascript:;" class="addMore"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add More</a>
                                 <h3>Contact Information</h3>
                              </div>
                           </div>
                           @if($contact_info->isNotEmpty())
                                @foreach($contact_info as $key => $contact)
                                <div class="row position-relative mr-15">
                                    <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                                        <div class="dash_input mb-1">
                                            <label>Contact Full Names</label>
                                            <input type="text" name="contact_title[]" id="contact_title1" placeholder="Enter here..." 
                                                value="{{ old('contact_title.0', optional($school_contact)->full_names) }}"
                                            >
                                            @error('contact_title.0')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                                        <div class="dash_input mb-1">
                                            <label>Email</label>
                                            <input type="text" name="contact_email[]" id="contact_email1" 
                                                    placeholder="Enter here..." 
                                                    value="{{ old('contact_email.0', optional($school_contact)->email) }}">
                                            @error('contact_email.0')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-xl-4  col-sm-6 col-md-6 col-12 cols">
                                        <div class="dash_input">
                                            <label>Phone</label>
                                            <input type="text" name="contact_phone[]" id="contact_phone1" 
                                                placeholder="Enter here..." 
                                                value="{{ old('contact_phone.0', optional($school_contact)->phone_no) }}">
                                            @error('contact_phone.0')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <a href="{{ route('delete.contact',$school_contact->id) }}" class="del-row row-delpos position-absolute"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </div>
                                @endforeach
                            @else
                                <div class="col-sm-12 cols">
                                    <div class="row">
                                        <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                                            <div class="dash_input mb-1">
                                                <label>Contact Title</label>
                                                <input type="text" name="contact_title[]" id="contact_title1" placeholder="Enter here">

                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                                            <div class="dash_input mb-1">
                                                <label>Email</label>
                                                <input type="text" name="contact_email[]" id="contact_email1" placeholder="Enter here">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-xl-4  col-sm-6 col-md-6 col-12 cols">
                                            <div class="dash_input">
                                                <label>Phone Number</label>
                                                <input type="text" name="contact_phone[]" id="contact_phone1" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>



                     <div class="save_sec">
                        <button class="save_btns mt-3" type="submit">Save </button>
                     </div>

                     </form>
                  </div>

                        <div class="ad-schl-card adscl-crd10 mt-4">
                            <form action="{{ route('user.update.school.facility') }}" method="post" id="facilityForm">
                              <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}">
                                <h2>Facilities / Amenities</h2>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="amenities-select">
                                            <div class="row">
                                                @foreach($facilities as $facility)
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                        <div class="radiobx amn-div">
                                                            <label>
                                                                {{ $facility->name }}
                                                                <input type="checkbox" 
                                                                    name="facilities[]" 
                                                                    value="{{ $facility->id }}"
                                                                    @if(in_array($facility->id, $school_facilities)) checked @endif>
                                                                <span class="checkbox"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <label id="facilities[]-error" class="error" for="facilities[]" style="display:none;">
                                                This field is required.
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Other Facilities / Amenities</label>
                                            <input type="text" name="other_facilities" placeholder="Enter here">
                                        </div>
                                    </div>
                                </div>

                                <div class="save_sec">
                                    <button class="save_btns mt-3" type="submit">Save</button>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="ad-schl-card adscl-crd6">
                           <h2>Uniform</h2>
                           <form action="{{ route('user.update.school.uniform') }}" method="post" enctype="multipart/form-data" id="uniformForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="school_uniform_id" id="">                         
                           <div class="row">
                           
                                 <div class="col-12">
                                    <div class="uni-type">
                                       <label for="" class="uni-label">
                                          <input type="radio" name="uniform_type" value="M" checked>
                                          <span class="uni-text"><img src="{{ url('public/images/uni-male.png') }}" alt="">Male</span>                            
                                       </label>
                                       <label for="" class="uni-label">
                                          <input type="radio" name="uniform_type" value="F">
                                          <span class="uni-text"><img src="{{ url('public/images/uni-female.png') }}" alt="">Female</span>                            
                                       </label>
                                       <label for="" class="uni-label">
                                          <input type="radio" name="uniform_type" value="U">
                                          <span class="uni-text"><img src="{{ url('public/images/uni-unisex.png') }}" alt="">Unisex</span>                            
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
                                             <img src="{{ url('public/images/upload1.png') }}" alt="">
                                          </label>
                                       </div>
                                       <label for="" id="showFilename" style="display:none;"></label>
                                       <label id="uniformImage_error" for="" class="error" style="display:none;"></label>
                                    </div>                              
                                 </div>
                                   <div class="col-12">
                                    <button class="submit-ratio" type="submit">Save</button>
                                 </div>
                                 <div class="col-12">
                                    <div class="uploaded-uniform">
                                        @if(@$school_uniform)
                                        @foreach($school_uniform as $data)
                                       <div class="upld-uniform-div">
                                          <em>
                                             @if(@$data->uniform_image != null)
                                             <img src="{{ URL::to('storage/app/public/images/uniform_image') }}/{{ @$data->uniform_image }}" alt="">
                                             @endif
                                           </em>
                                          <h6>
                                             @if(@$data->uniform_type == 'M')
                                             Male
                                             @elseif(@$data->uniform_type == 'F')
                                             Female
                                             @elseif(@$data->uniform_type == 'U')
                                             Unisex
                                             @endif
                                          </h6>
                                          <p>{{ @$data->uniform_title }}</p>
                                          <a href="{{ route('user.school.uniform.delete',@$data->id) }}" class="uni-delet">
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 3L3 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M3 3L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                       
                                          </a>
                                       </div>
                                       @endforeach
                                       @endif
                                    </div>
                                 </div>
                           </div> 
                           </form>                      
                        </div> --}}

                        <div class="ad-schl-card adscl-crd7">
                            <h2>School Rules <span style="color: red;">*</span></h2>
                            <form action="{{ route('user.update.school.rules') }}" method="post" enctype="multipart/form-data" id="rulesForm">
                                @csrf
                                <input type="hidden" name="school_master_id" value="{{ $school->id }}">

                                <div class="row">
                                    {{-- School Services --}}
                                    <div class="col-12">
                                        <div class="dash_input">
                                        <ul class="rules-list">
                                            @foreach ($extended_school_services as $service)
                                                <li style="text-transform: none !important;">
                                                    {{ $service->name }}
                                                    <label class="switch">
                                                    <input
                                                        type="checkbox"
                                                        name="extended_school_services_id[]"
                                                        value="{{ $service->id }}"
                                                        {{ in_array($service->id, old('extended_school_services_id', $extended_services['extended_school_services_id'] ?? [])) ? 'checked' : '' }}
                                                    />
                                                    <span class="slider round"></span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @error('extended_school_services_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    </div>

                                    {{-- Day Learning Period --}}
                                    <div class="col-12">
                                        <h3 class="ratio-hd">Day learning period <span style="color: red;">*</span></h3>
                                        <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="dash_input">
                                                <label>From</label>
                                                <select name="day_learn_period_from" id="day_learn_period_from">
                                                    <option value="">Select</option>
                                                    @foreach (range(1,17) as $number)
                                                    @php
                                                        $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00';
                                                        $savedFrom = old('day_learn_period_from', $operation_hours[0]['starts_at'] ?? ($schoolDetails->day_learn_period_from ?? null));
                                                    @endphp
                                                    <option value="{{ $time }}" {{ $savedFrom == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                                @error('day_learn_period_from')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-6">
                                            <div class="dash_input">
                                                <label>Until</label>
                                                <select name="day_learn_period_until" id="day_learn_period_until">
                                                    <option value="">Select</option>
                                                    @foreach (range(1,17) as $number)
                                                    @php
                                                        $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00';
                                                        $savedUntil = old('day_learn_period_until', $operation_hours[0]['ends_at'] ?? ($schoolDetails->day_learn_period_until ?? null));
                                                    @endphp
                                                    <option value="{{ $time }}" {{ $savedUntil == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                                @error('day_learn_period_until')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    {{-- Evening Studies --}}
                                    <div class="col-12">
                                        <h3 class="ratio-hd mt-3p">Evening Studies <span style="color: red;">*</span></h3>
                                        <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="dash_input">
                                                <label>From</label>
                                                <select name="evening_studies_from" id="evening_studies_from">
                                                    <option value="">Select</option>
                                                    @foreach (range(17,24) as $number)
                                                    @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                    <option value="{{ $time }}" {{ old('evening_studies_from', $schoolDetails->evening_studies_from ?? null) == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                                @error('evening_studies_from')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-6">
                                            <div class="dash_input">
                                                <label>Until</label>
                                                <select name="evening_studies_until" id="evening_studies_until">
                                                    <option value="">Select</option>
                                                    @foreach (range(17,24) as $number)
                                                    @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                    <option value="{{ $time }}" {{ old('evening_studies_until', $schoolDetails->evening_studies_until ?? null) == $time ? 'selected' : '' }}>{{ $time }}</option>
                                                    @endforeach
                                                </select>
                                                @error('evening_studies_until')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-12">
                                        <button class="submit-ratio" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            </div>

                        <div class="ad-schl-card adscl-crd7">
                           <h2>Teacher-Student ratio</h2>
                           <form action="{{ route('user.update.school.ratio') }}" method="post" enctype="multipart/form-data" id="ratioForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="teacher_student_ratio" id="teacher_student_ratio" value="{{ @$schoolDetails->teacher_student_ratio?@$schoolDetails->teacher_student_ratio:'0' }}"> 
                           <div class="row align-items-end">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="dash_input">
                                       <label>Teacher-Student ratio</label>
                                       <div class="ratio-counter w-100">
                                          <span id="minus-btn">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                          
                                          </span>
                                          <h6 id="count"></h6>
                                          <span id="plus-btn">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 5V19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                          
                                          </span>
                                       </div>
                                       <label for="" id="ratio_error" class="error" style="display:none;"></label>
                                    </div>
                                 </div>
                                   

                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="add-grade agree mb-4">
                                       <div class="radiobx">
                                             <label for="">Show Frontend
                                                <input type="checkbox" id="aboutSchoolcheck" name="show_ratio" value="Y" @if(@$schoolDetails->show_ratio == 'Y') checked @endif>
                                                <span class="checkbox"></span>
                                             </label>
                                          </div>
                                    </div>
                                 </div>


                                 <div class="col-12">
                                    <h3 class="ratio-hd">Students</h3>
                                    <div class="row">
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Total</label>
                                             <input type="text" name="total_student" id="total_student" placeholder="Enter here" value="{{ @$schoolDetails->total_student }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Boys</label>
                                             <input type="text" name="student_boys" id="student_boys" placeholder="Enter here" value="{{ @$schoolDetails->student_boys }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Girls</label>
                                             <input type="text" name="student_girls" id="student_girls" placeholder="Enter here" value="{{ @$schoolDetails->student_girls }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <h3 class="ratio-hd mt-3p">Teachers</h3>
                                    <div class="row">
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Total</label>
                                             <input type="text" name="total_teacher" id="total_teacher" placeholder="Enter here" value="{{ @$schoolDetails->total_teacher }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Male</label>
                                             <input type="text" name="teacher_male" id="teacher_male" placeholder="Enter here" value="{{ @$schoolDetails->teacher_male }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Female</label>
                                             <input type="text" name="teacher_female" id="teacher_female" placeholder="Enter here" value="{{ @$schoolDetails->teacher_female }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                       </div>
                                    </div>
                                 </div>
                             </div>
                           </form>                        
                        </div>

                        <div class="ad-schl-card adscl-crd9">
                           <h2>Add Subject</h2>
                           <form action="{{ route('user.update.school.subject') }}" method="post" enctype="multipart/form-data" id="subjectForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="subject_id" id="" value="{{ @$subjec_detail->id }}"> 
                           <div class="row">
                              <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>Curriculum </label>
                                    <select name="board_id" id="board_id" class="board_id">
                                       @foreach($board as $data)
                                       <option value="{{ @$data->id }}" @if(@$subjec_detail->curriculum == @$data->id) selected @endif>{{ @$data->board_name }}</option>
                                       @endforeach
                                       <option value="5" @if(@$subjec_detail->curriculum == '5') selected @endif>Others</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="row align-items-center">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="new_class_level">
                                       <div class="dash_input">
                                          <label>Class Level </label>
                                          <select name="class_level" id="class_level">
                                             @foreach($class_level as $data)
                                             <option value="{{ @$data->id }}" @if(@$subjec_detail->class_level == @$data->id) selected @endif>{{ @$data->class_level }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="otherPet" @if(@$schoolDetails->curriculum == 5) style="display:block;" @else style="display: none;" @endif>
                                       <div class="dash_input">
                                          <label>Class Level </label>
                                          <input type="text" name="other_class_level" id="other_class_level" placeholder="Enter here">
                                       </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                       <ul class="add-grade agree d-flex justify-content-start align-items-center">
                                          <li>
                                             <div class="radiobx" id="add_new">
                                                <label for="">Add New
                                                   <input type="checkbox" name="" id="otherpetdrop">
                                                   <span class="checkbox"></span>
                                                </label>
                                             </div>
                                          </li>                              
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label>Subjects</label>
                                    <ul class="category-ul subs-list agree d-flex justify-content-start align-items-center flex-wrap">
                                       @if(@$subjects)
                                       @foreach($subjects as $data)
                                       <li class="mb-1">
                                          <div class="radiobx">
                                             <label for="">{{ @$data->subject }}
                                                  <input type="checkbox" name="subject[]" value="{{ @$data->id }}" @if(in_array(@$data->id,@$school_to_subject_id)) checked @endif>
                                                  <span class="checkbox"></span>
                                              </label>
                                          </div>
                                       </li>
                                       @endforeach
                                       @endif                                  
                                    </ul>
                                    <label id="subject[]-error" class="error" for="subject[]" style="display:none;">This field is required.</label>
                                 </div>
                                 
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Other subjects </label>
                                    <input type="text" name="other_subject" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-12">
                                 <button class="submit-ratio mt-1" type="submit">+ &nbsp;Add</button>
                              </div>
                              <div class="col-12">
                                 <div class="added-subs-div">
                                   @if(@$school_subject->isNotEmpty())
                                    <h2>Added Subject</h2>
                                    @foreach($school_subject as $data)
                                    <div class="added-subs-box position-relative">
                                       <a href="{{ route('user.edit.school',[@$schoolDetails->id,@$data->id]) }}" class="edit-subs" style="right: 42px">
                                          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                             <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                             <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                          </svg>                                             
                                       </a>
                                       <a href="{{ route('user.school.subject.delete',[@$data->id]) }}" class="edit-subs">
                                       <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path opacity="0.4" d="M13.9121 6.72089C13.9121 6.76906 13.5346 11.5438 13.3189 13.5532C13.1839 14.7864 12.3889 15.5344 11.1965 15.5556C10.2802 15.5762 9.3833 15.5833 8.50083 15.5833C7.56393 15.5833 6.64771 15.5762 5.75835 15.5556C4.60583 15.528 3.81016 14.7652 3.68203 13.5532C3.46021 11.5367 3.08958 6.76906 3.0827 6.72089C3.07581 6.57569 3.12265 6.43757 3.21772 6.32566C3.31141 6.22224 3.44643 6.15991 3.58834 6.15991H13.4133C13.5545 6.15991 13.6827 6.22224 13.7839 6.32566C13.8783 6.43757 13.9258 6.57569 13.9121 6.72089Z" fill="black"/>
                                       <path d="M14.875 4.23357C14.875 3.94245 14.6456 3.71438 14.37 3.71438H12.3047C11.8845 3.71438 11.5194 3.41547 11.4257 2.99403L11.31 2.47767C11.1481 1.85365 10.5894 1.41663 9.96252 1.41663H7.03817C6.40439 1.41663 5.85121 1.85365 5.68312 2.51167L5.57497 2.99474C5.48059 3.41547 5.11548 3.71438 4.69594 3.71438H2.63065C2.3544 3.71438 2.125 3.94245 2.125 4.23357V4.50273C2.125 4.78676 2.3544 5.02192 2.63065 5.02192H14.37C14.6456 5.02192 14.875 4.78676 14.875 4.50273V4.23357Z" fill="black"/>
                                       </svg>                                           
                                       </a>
                                       <ul>
                                          <li>
                                             <h6>Curriculum&nbsp;</h6>
                                             <p>:&nbsp;{{ @$data->getBoard->board_name }}</p>
                                          </li>
                                          <li>
                                             <h6>Class level&nbsp;</h6>
                                             <p>:&nbsp; {{ @$data->getClassLevel->class_level }}</p>
                                          </li>
                                          <li>
                                             <h6>Subjects&nbsp;</h6>
                                             <p>:&nbsp;
                                                @if(@$data->school_subjects)
                                                @foreach(@$data->school_subjects as $key=>$subject)
                                                {{ @$key > 0?',':'' }} {{ @$subject->subject }}
                                                @endforeach
                                                @endif
                                               </p>
                                          </li>
                                       </ul>
                                    </div>
                                    @endforeach
                                    @endif
                                 </div>
                              </div>
                           </div>
                           </form>
                        </div>


                        <form action="{{ route('user.update.school.result') }}" method="post" id="resultForm">
                        @csrf
                        <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                        <input type="hidden" name="school_result_id" id="" value="{{ @$schoolResult->id }}">
                        <input type="hidden" name="complete_step" id="complete_step" value="">
                        <div class="ad-schl-card adscl-crd12">
                        <h2>Add Result</h2>
                           <div class="row">
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Year</label>
                                    <select name="year" id="">
                                       <option value="0" selected disabled>Select</option>
                                        @foreach(range(date('Y'),date('Y')-20) as $data)
                                        <option value="{{ @$data }}" @if(@$schoolResult->year == @$data) selected @endif>{{ @$data }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Curriculum</label>
                                    <select name="board_id" id="board_id">
                                       <option value="" selected disabled>Select</option>
                                        @foreach($board as $data)
                                        <option value="{{ @$data->id }}" @if(@$schoolResult->board_id == @$data->id) selected @endif>{{ @$data->board_name }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Exam</label>
                                    <select name="exam" id="">
                                       <option value="0" selected disabled>Select</option>
                                       <option value="HY" @if(@$schoolResult->exam == 'HY') selected @endif>Half Yearly</option>
                                       <option value="AN" @if(@$schoolResult->exam == 'AN') selected @endif>Annual</option>
                                       <option value="BE" @if(@$schoolResult->exam == 'BE') selected @endif>Board Exam</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Ranking position</small></label>
                                    <input type="text" name="ranking_position" placeholder="Enter here" value="{{ @$schoolResult->ranking_position }}">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Region</label>
                                    <select name="region" id="">
                                       <option value="0" selected disabled>Select</option>
                                       <option value="National" @if(@$schoolResult->region == 'National') selected @endif>National</option>
                                       <option value="Country" @if(@$schoolResult->region == 'Country') selected @endif>Country</option>
                                       <option value="N/A" @if(@$schoolResult->region == 'N/A') selected @endif>N/A</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Mean score points</label>
                                    <input type="text" name="mean_score_point" placeholder="Enter here" value="{{ @$schoolResult->mean_score_point }}" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"  maxlength="5">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input position-relative g-map">
                                    <label>Mean Grade</label>
                                    <input type="text" name="mean_grade" placeholder="Enter Here" value="{{ @$schoolResult->mean_grade }}">
                                 </div>
                              </div>
                              <div class="col-12">
                                    <h3 class="ratio-hd mt-3 mb-2"><b> Results</b></h3>
                                    <div class="row">
                                       <div class="col-lg-5 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Grade</label>
                                             <select id="grade">
                                                <option value="0" selected disabled>Select</option>
                                                <option value="Grade A">Grade A</option>
                                                <option value="Grade B">Grade B</option>
                                                <option value="Grade C">Grade C</option>
                                                <option value="Grade D">Grade D</option>
                                                <option value="Grade E">Grade E</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-5 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Number of candidates</label>
                                             <input type="text" id="no_of_candidate" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="5">
                                          </div>
                                       </div>
                                       <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                                          <button class="submit-ratio mt-4 addResul">+ Add</button>
                                       </div>

                                       <div class="col-12">
                                          <div class="row">
                                             <div class="col-12">
                                                <em class="fee-ad-ln"></em>
                                             </div>
                                             <div class="row" id="result_show">
                                             @if(@$schoolResult->getResultDetail)
                                             @foreach($schoolResult->getResultDetail as $redetail)
                                             <div class="col-lg-5 col-sm-6">
                                             <input type="hidden" name="grade[]"  value="{{ @$redetail->grade }}" placeholder="Enter here">
                                              <input type="hidden" name="no_of_candidate[]" value="{{ @$redetail->no_of_candidates }}" placeholder="Enter here">
                                                <div class="added-fees position-relative">
                                                   <h5>{{ @$redetail->grade }}</h5>
                                                   <p>Number of candidates: <b> {{ @$redetail->no_of_candidates }} </b> </p>
                                                   <a href="javascript:;" class="position-absolute removeResult">
                                                      <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path opacity="0.4" d="M13.914 6.72065C13.914 6.76881 13.5365 11.5435 13.3209 13.553C13.1859 14.7862 12.3909 15.5341 11.1984 15.5554C10.2822 15.5759 9.38525 15.583 8.50278 15.583C7.56589 15.583 6.64966 15.5759 5.7603 15.5554C4.60779 15.5278 3.81212 14.7649 3.68398 13.553C3.46216 11.5364 3.09154 6.76881 3.08465 6.72065C3.07776 6.57545 3.1246 6.43733 3.21967 6.32541C3.31336 6.222 3.44838 6.15967 3.59029 6.15967H13.4153C13.5565 6.15967 13.6846 6.222 13.7859 6.32541C13.8803 6.43733 13.9278 6.57545 13.914 6.72065Z" fill="black"></path>
                                                         <path d="M14.875 4.23345C14.875 3.94233 14.6456 3.71426 14.37 3.71426H12.3047C11.8845 3.71426 11.5194 3.41535 11.4257 2.99391L11.31 2.47755C11.1481 1.85353 10.5894 1.4165 9.96252 1.4165H7.03817C6.40439 1.4165 5.85121 1.85353 5.68312 2.51155L5.57497 2.99462C5.48059 3.41535 5.11548 3.71426 4.69594 3.71426H2.63065C2.3544 3.71426 2.125 3.94233 2.125 4.23345V4.5026C2.125 4.78664 2.3544 5.02179 2.63065 5.02179H14.37C14.6456 5.02179 14.875 4.78664 14.875 4.5026V4.23345Z" fill="black"></path>
                                                      </svg>
                                                   </a>
                                                </div>
                                             </div>
                                             @endforeach
                                             @endif
                                             </div>
                                            
                                             {{--<div class="col-lg-5 col-sm-6">
                                                <div class="added-fees position-relative">
                                                   <h5>Grade B</h5>
                                                   <p>Number of candidates: <b> 12 </b> </p>
                                                   <a href="#" class="position-absolute">
                                                      <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <path opacity="0.4" d="M13.914 6.72065C13.914 6.76881 13.5365 11.5435 13.3209 13.553C13.1859 14.7862 12.3909 15.5341 11.1984 15.5554C10.2822 15.5759 9.38525 15.583 8.50278 15.583C7.56589 15.583 6.64966 15.5759 5.7603 15.5554C4.60779 15.5278 3.81212 14.7649 3.68398 13.553C3.46216 11.5364 3.09154 6.76881 3.08465 6.72065C3.07776 6.57545 3.1246 6.43733 3.21967 6.32541C3.31336 6.222 3.44838 6.15967 3.59029 6.15967H13.4153C13.5565 6.15967 13.6846 6.222 13.7859 6.32541C13.8803 6.43733 13.9278 6.57545 13.914 6.72065Z" fill="black"></path>
                                                         <path d="M14.875 4.23345C14.875 3.94233 14.6456 3.71426 14.37 3.71426H12.3047C11.8845 3.71426 11.5194 3.41535 11.4257 2.99391L11.31 2.47755C11.1481 1.85353 10.5894 1.4165 9.96252 1.4165H7.03817C6.40439 1.4165 5.85121 1.85353 5.68312 2.51155L5.57497 2.99462C5.48059 3.41535 5.11548 3.71426 4.69594 3.71426H2.63065C2.3544 3.71426 2.125 3.94233 2.125 4.23345V4.5026C2.125 4.78664 2.3544 5.02179 2.63065 5.02179H14.37C14.6456 5.02179 14.875 4.78664 14.875 4.5026V4.23345Z" fill="black"></path>
                                                      </svg>
                                                   </a>
                                                </div>
                                             </div>--}}
                                             <div class="col-12">
                                                <em class="fee-ad-ln mt-3"></em>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              <div class="col-12">
                                 <button class="submit-ratio mt-1" type="submit">Save</button>
                              </div>
                           </div>
                           @if(@$school_result->isNotEmpty())
                           <div class="col-12 mt-4">
                                 <div class="step-5-added-loc">
                                    <h2>Added Results</h2>
                                    @foreach($school_result as $data)
                                    <div class="added-subs-box position-relative">
                                       <a href="{{ route('user.edit.school.result',[@$schoolDetails->id,@$data->id]) }}" class="edit-subs">
                                          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"></path>
                                             <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"></path>
                                             <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"></path>
                                          </svg>                                             
                                       </a>
                                       <ul class="new_rsult_d">
                                          <li>
                                             <h6>Year</h6>
                                             <p> :{{ @$data->year }}</p>
                                          </li>
                                          <li>
                                             <h6>Curriculum</h6>
                                             <p> : {{ @$data->getBoard->board_name }}</p>
                                          </li>
                                          <li>
                                             <h6>Exam</h6>
                                             <p> :
                                                @if(@$data->exam == 'HY')
                                                Half Yearly
                                                @elseif(@$data->exam == 'AN')
                                                Annual
                                                @elseif(@$data->exam == 'BE')
                                                Board Exam
                                                @endif
                                             </p>
                                          </li>
                                          <li>
                                             <h6>Ranking Position</h6>
                                             <p> :{{ @$data->ranking_position }}</p>
                                          </li>
                                          @if(@$data->region != null)
                                          <li>
                                             <h6>Region</h6>
                                             <p> :{{ @$data->region }}</p>
                                          </li>
                                          @endif
                                          <li>
                                             <h6>Mean Score Points</h6>
                                             <p> : {{ @$data->mean_score_point }}</p>
                                          </li>
                                          <li>
                                             <h6>Mean Grade</h6>
                                             <p> : {{ @$data->mean_grade }}</p>
                                          </li>                                          
                                       </ul>
                                       <div class="grades-lis">
                                          @if(@$data->getResultDetail)
                                          @foreach($data->getResultDetail as $redetail)
                                          <div class="no_s">
                                             <h5>{{ @$redetail->grade }}</h5>
                                             <p>Number of candidates: <b> {{ @$redetail->no_of_candidates }} </b> </p>
                                          </div>
                                          @endforeach
                                          @endif
                                       </div>
                                    </div>
                                     @endforeach
                                 </div>
                              </div>
                              @endif


                        </div>
                     
                     </form>


                  <div class="dashboard_box mt-4">
                   
                     <form action="{{ route('user.update.school.image') }}" method="post" id="imageUpdate" enctype="multipart/form-data" style="display:none;">
                        @csrf
                        <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                        <input type="hidden" name="image_id" id="image_id" value="">
                        <div class="row">
                           <div class="col-lg-6 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>School Photo</label>
                                 <div class="uplodimgfil2">
                                       <input type="file" name="school_image" id="school_image" class="inputfile2 inputfile-1" data-multiple-caption="{count} files selected">
                                       <label for="school_image">                                          
                                          <h3>Click here to upload </h3>
                                          <img src="{{ url('public/images/upload1.png') }}" alt="">
                                       </label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-3 col-xl-4 col-sm-3  col-md-6 col-12 cols">
                           <div class="save_sec">
                         <button class="save_btns" type="submit">Save</button>
                         </div>
                         </div>

                    </div>
                     </form>
                     

                    <div class="col-lg-4 col-xl-3 col-sm-6  col-md-3 col-12 cols cols_img">
                    <div class="sch_show_img uploadImages">
                     
                    </div>
                    </div>

                     <div class="row">
                           <div class="col-sm-12 cols">
                              <div class="dash_inner_heading ">
                                 <h3>School Photos</h3>
                              </div>
                           </div>

                           <div class="new_schhol_img">
                              <div class="row">
                                 @if(@$schoolPhoto)
                                 @foreach($schoolPhoto as $data)
                                 <div class="col-lg-4 col-xl-3 col-sm-6  col-md-3 col-12 cols cols_img">
                                    
                                    <div class="schol_show_box">
                                       <div class="sch_show_img">
                                          @if(@$data->image != null)
                                          <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$data->image }}" alt="">
                                          @endif
                                       </div>
                                       <div class="img_show_actions">
                                          <a href="javascript:;" class="imageEdit" data-image_id="{{ @$data->id }}" data-image_url="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$data->image }}"> <img src="{{ url('public/images/edit.png') }}" alt="">   Edit</a>
                                           @if(@$data->status == 'I')
                                          <a href="{{ route('user.school.image.status.update',@$data->id) }}" onclick="return confirm('Do you want to unblock this image?')"> <img src="{{ url('public/images/check2.png') }}" alt=""> Unblock</a>
                                          @endif
                                          @if(@$data->status == 'A')
                                          <a href="{{ route('user.school.image.status.update',@$data->id) }}" onclick="return confirm('Do you want to block this image?')"> <img src="{{ url('public/images/lock.png') }}" alt=""> Block</a>
                                          @endif
                                       </div>
                                    </div>

                                 </div>
                                 @endforeach
                                 @endif

                                 {{--<div class="col-lg-4 col-xl-3  col-sm-6  col-md-3 col-12 cols cols_img">
                                    
                                    <div class="schol_show_box">
                                       <div class="sch_show_img">
                                          <img src="images/sch2.png" alt="">
                                       </div>
                                       <div class="img_show_actions">
                                          <a href="#"> <img src="images/edit.png" alt="">   Edit</a>
                                          <a href="#"> <img src="images/lock.png" alt=""> Block</a>
                                       </div>
                                    </div>

                                 </div>

                                 <div class="col-lg-4 col-xl-3  col-sm-6  col-md-3 col-12 cols cols_img">
                                    
                                    <div class="schol_show_box">
                                       <div class="sch_show_img">
                                          <img src="images/sch3.png" alt="">
                                       </div>
                                       <div class="img_show_actions">
                                          <a href="#"> <img src="images/edit.png" alt="">   Edit</a>
                                          <a href="#"> <img src="images/lock.png" alt=""> Block</a>
                                       </div>
                                    </div>

                                 </div>--}}
                              </div>
                           </div>

                           

                     </div>

                  </div>


                  <div class="dashboard_box mt-4">
                     <div class="new_list_dash">
                        <div class="new_list_dash_heading">
                           <h3>News List</h3>
                           <a href="{{ route('user.create.news',@$schoolDetails->id) }}"><img src="{{ url('public/images/plus-circle.png') }}" alt=""> Add News</a>
                        </div>
                         @if(@$newsData->isNotEmpty())
                         @foreach($newsData as $data)
                        <div class="dash_news_list_box">
                           <div class="dash_news_info">
                              <a href="{{ route('news.details',@$data->slug) }}">
                                 <span>
                                    @if(@$data->image != null)
                                    <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ @$data->image }}" alt="">
                                    @endif
                                 </span>
                                 <div>
                                    <h3>{{ @$data->news_title }}</h3>
                                    <p> <img src="{{ url('public/images/gclock.png') }}"> Posted on : {{ date('jS M, Y',strtotime(@$data->created_at)) }}</p>
                                 </div>
                              </a>
                           </div>
                           <div class="dash_news_action">
                              <a href="{{ route('user.create.news',[@$schoolDetails->id,@$data->id]) }}">  
                                 <img src="{{ url('public/images/bedit.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bedit2.png') }}" alt="" class="hoverb">
                              </a>
                              <a href="{{ route('user.news.delete',@$data->id) }}" onclick="return confirm('Do you want to delete this news?')">  
                                 <img src="{{ url('public/images/bdelete.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bdelete1.png') }}" alt="" class="hoverb">
                              </a>
                           </div>
                        </div>
                        @endforeach
                       @else
                        <h3><center>No Data Found</center></h3>
                       @endif

                        {{--<div class="dash_news_list_box">
                           <div class="dash_news_info">
                              <a href="#">
                                 <span>
                                    <img src="{{ url('public/images/newsd1.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h3>DMS-Department of in Management The quality a role of the elementary teacher in education</h3>
                                    <p> <img src="{{ url('public/images/gclock.png') }}"> Posted on : 10th Jan, 2024</p>
                                 </div>
                              </a>
                           </div>
                           <div class="dash_news_action">
                              <a href="#">  
                                 <img src="{{ url('public/images/bedit.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bedit2.png') }}" alt="" class="hoverb">
                              </a>
                              <a href="#">  
                                 <img src="{{ url('public/images/bdelete.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bdelete1.png') }}" alt="" class="hoverb">
                              </a>
                           </div>
                        </div>

                        <div class="dash_news_list_box">
                           <div class="dash_news_info">
                              <a href="#">
                                 <span>
                                    <img src="{{ url('public/images/newsd2.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h3>Lorem ipsum dolor sit amet, Integer quis orci adipiscing elit. Integer quis orci pulvinar aliquam lacinia pulvinar</h3>
                                    <p> <img src="{{ url('public/images/gclock.png') }}"> Posted on : 10th Jan, 2024</p>
                                 </div>
                              </a>
                           </div>
                           <div class="dash_news_action">
                              <a href="#">  
                              <img src="{{ url('public/images/bedit.png') }}" alt="" class="hovern">
                              <img src="{{ url('public/images/bedit2.png') }}" alt="" class="hoverb">
                              </a>
                              <a href="#">  
                              <img src="{{ url('public/images/bdelete.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bdelete1.png') }}" alt="" class="hoverb">
                              </a>
                           </div>
                        </div>

                        <div class="dash_news_list_box">
                           <div class="dash_news_info">
                              <a href="#">
                                 <span>
                                    <img src="{{ url('public/images/newsd3.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h3>DMS-Department of in Management The quality elementary teacher in education</h3>
                                    <p> <img src="{{ url('public/images/gclock.png') }}"> Posted on : 10th Jan, 2024</p>
                                 </div>
                              </a>
                           </div>
                           <div class="dash_news_action">
                              <a href="#">  
                              <img src="{{ url('public/images/bedit.png') }}" alt="" class="hovern">
                              <img src="{{ url('public/images/bedit2.png') }}" alt="" class="hoverb">
                              </a>
                              <a href="#">  
                              <img src="{{ url('public/images/bdelete.png') }}" alt="" class="hovern">
                                 <img src="{{ url('public/images/bdelete1.png') }}" alt="" class="hoverb">
                              </a>
                           </div>
                        </div>--}}

                     </div>
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

<script>
   $(document).ready(function(){

      $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("phone_Regex", function(value, element) {
        return this.optional(element) || /^[0-9a\+]+$/.test(value);
    }, "Please enter only numbers");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters");

        $('#schoolInfoForm').validate({

             rules: {
               school_name: {

                  required: true,
                  name_Regex: true,
                 },  
                 'school_type[]': {

                  required: true,
                },
                'board[]': {

                  required: true,
                },
                gender: {

                  required: true,
                },
                boarding_type: {

                  required: true,
                },
               about_school: {

                   required: true,
               },
               'contact_title[]': {
                  name_Regex: true,
                  maxlength:30,
                },
                'contact_email[]': {

                  validate_email: true,
                },
                'contact_phone[]':{

                    minlength:10,
                    maxlength:13,
                },

             },
             ignore:[],
             submitHandler: function(form){

                 form.submit();
             },
        })
   })
</script>

<script>
   $(document).ready(function(){

       $('#facilityForm').validate({

           rules: {

                  'facilities[]': {

                  required: true,
                },
           },
           ignore: [],
           submitHandler: function(form){

              form.submit();
           }
       })
   })
</script>

<script>
   $(document).ready(function(){

      $.validator.addMethod("mintime", function(value, element) {
       
       let time1 = $('#day_learn_period_from').val();
       let time2 = $('#day_learn_period_until').val();
       //console.log(time2);
       if(time1 < time2){

           return true;
       }else{

           return false;
       }


    }, "Plese select valid time");

    $.validator.addMethod("mintime1", function(value, element) {
       
       let time1 = $('#evening_studies_from').val();
       let time2 = $('#evening_studies_until').val();
       //console.log(time2);
       if(time1 < time2){

           return true;
       }else{

           return false;
       }


    }, "Plese select valid time");

        $("#rulesForm").validate({

             rules: {

               day_learn_period_from: {

                    required: true,
               },
               day_learn_period_until: {

                  required: true,
                  mintime: true,
               },
               evening_studies_from: {

                  //required: true,
               },
               evening_studies_until: {

                  //required: true,
                  mintime1: true,
               }
             },
             submitHandler: function(form){

                 form.submit();
             }
        })
   })
</script>

<script>
   $(document).ready(function(){

      $.validator.addMethod("total_student_valid", function(value, element) {
       
         let total_student = parseInt($('#total_student').val());
         let student_boys = parseInt($('#student_boys').val());
         let student_girls = parseInt($('#student_girls').val());
         let sum_of_student = student_boys+student_girls
         console.log(sum_of_student);
         if(total_student == sum_of_student){
               return true;
          }
           else if(isNaN(student_boys) || isNaN(student_girls)){

                 return true;
             }
             else{

              return false;
               
             }


    });

    $.validator.addMethod("total_teacher_valid", function(value, element) {
       
       let total_teacher = parseInt($('#total_teacher').val());
       let teacher_male = parseInt($('#teacher_male').val());
       let teacher_female = parseInt($('#teacher_female').val());
       let sum_of_teacher = teacher_male+teacher_female
        if(total_teacher == sum_of_teacher){

           return true;
       }
        else if(isNaN(teacher_male) || isNaN(teacher_female)){ 
           return true;
       }
       else{

           return false;
       }


    });

        $('#ratioForm').validate({

             rules: {
               total_student: {

                  required: true,
                  digits: true,
                  maxlength: 10,
                  total_student_valid: true,
               },
               student_boys: {

                  required: true,
                  digits: true,
                  maxlength: 10,
               },
               student_girls: {

                  required: true,
                  digits: true,
                  maxlength: 10,
               },
               total_teacher: {

                  required: true,
                  digits: true,
                  maxlength: 10,
                  total_teacher_valid: true,
               },
               teacher_male: {

                  required: true,
                  digits: true,
                  maxlength: 10,
               },
               teacher_female: {

                  required: true,
                  digits: true,
                  maxlength: 10,
               },
             },
             messages:{

               total_student: {

                  total_student_valid: "Plese enter valid number",
               },
               total_teacher: {

                  total_teacher_valid: "Plese enter valid number",
               },
             },
             submitHandler: function(form){
                 let ratio = parseInt($('#teacher_student_ratio').val());
                 if(ratio <= 0){
                     $('#ratio_error').css('display','block');
                     $('#ratio_error').text("Plese select grater than 0");
                     return false;
                 }else{

                  form.submit();
                 }
                 
             },
        })
   })
</script>

<script>
     $("#school_image").change(function () {
            $('.uploadImages').html('');
            let files = this.files;
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif','image/jpg'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#school_image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uploadImages').append('<img src="'+e.target.result+'" alt="">');
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>
<script>
    $(document).ready(function(){

          $('.imageEdit').click(function(){
               $('.uploadImages').html(''); 
               let image = $(this).data('image_url');
               let image_id = $(this).data('image_id');
               $('#image_id').val(image_id);
               $('.uploadImages').append('<img src="'+image+'" alt="">');
               $('#imageUpdate').css('display','block');
          })
    })
</script>
<script>
   $(document).ready(function(){

      $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters and numbers");

        $('#uniformForm').validate({

             rules: {

               uniform_image: {

                    required: true,
               },
               uniform_title: {

                  //required: true,
                  name_Regex: true,
               }
             },
             submitHandler: function(form){
                let filename = $('#uniform_image').val();
                console.log(filename);
                if(filename == ''){

                    $('#uniformImage_error').html('Please upload a uniform image');
                    $('#uniformImage_error').css('display','block');
                    return false;
                }else{

                  form.submit();
                }
             }
        })
   })
</script>
<script>
   $(document).ready(function(){

        $('#otherpetdrop1').click(function(){

              if($('#otherpetdrop1').is(":checked")){

                  $('#otherPet1').css('display','block');
                  $('#other_board').rules('add','required');
                  $("input[name='board[]']").rules('remove','required');
              }else{

                  $('#otherPet1').css('display','none');
                  $('#other_board').rules('remove','required');
                  $("input[name='board[]']").rules('add','required');
                  $('#other_board').val('');
                  
              }
        })
   })
</script>
<script>
   $(document).ready(function(){

        $('#uniform_image').change(function(){
           $('#showFilename').html('');
             let filename = this.files[0].name;
             $('#showFilename').css('display','block');
             $('#showFilename').html(filename);
        })


         $('#otherpetdrop').click(function(){

            if($('#otherpetdrop').is(':checked')){

                 $('#new_class_level').css('display','none');
                 $('#otherPet').css('display','block');
                 $('#other_class_level').rules('add','required');
            }else{

               $('#new_class_level').css('display','block');
                 $('#otherPet').css('display','none');
                 $('#other_class_level').rules('remove','required');
            }
        })
      

   })
</script>
<script>
    $(document).ready(function() {
      let minusBtn = document.getElementById("minus-btn");
      let count = document.getElementById("count");
      let plusBtn = document.getElementById("plus-btn");
      @if(@$schoolDetails->teacher_student_ratio != null)
      let countNum = '{{ @$schoolDetails->teacher_student_ratio }}';
      countNum = parseInt(countNum);
      @else
      let countNum = 0;
      @endif
      count.innerHTML = countNum;
      
      minusBtn.addEventListener("click", () => {
        if (countNum > 0) {
          countNum -= 1;
          count.innerHTML = countNum;
          console.log(countNum);
          $('#teacher_student_ratio').val(countNum);
        }
      });
      
      plusBtn.addEventListener("click", () => {
        countNum += 1;
        count.innerHTML = countNum;
        console.log(countNum);
        $('#teacher_student_ratio').val(countNum);
      });
    })
</script>
<script>
   $(document).ready(function(){

        $('#subjectForm').validate({

             rules: {

               board_id: {

                   required: true,
               },
               class_level: {

                  required: function(){

                      let other_level = $('#other_class_level').val();
                      if(other_level == '')
                      return true;
                     else
                     return false;
                  }
               },
               'subject[]': {

                  required: true,
               }

             },
             ignore: [],
             submitHandler: function(form){

                 form.submit();
             }
             
        })
   })
</script>
<script>
   $('.board_id').change(function(){
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'board_id'    : $(this).val()
                }
            };
            $.ajax(
            {
                url: '{{ route('get.class.level') }}',
                dataType: 'json',
                data: reqData,
                type: 'post',
                success: function(response)
                {
                  $('#class_level').html('');
                    console.log(response)
                    html='<option value="">Select</option>';
                         response.result.classLevel.forEach(function(item, index){
                             html+='<option value="'+item.id+'">'+item.class_level+'</option>';
                         });
                         $('#class_level').html(html);

                },
                error:function(error)
                {
                    console.log(error.responseText);
                }
            });
        });
</script>
<script>
   $(document).ready(function(){
      let count = 2;
        $('.addMore').click(function(){
             let html = `<div class="row position-relative mr-15">
                           <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>Contact Title</label>
                                 <input type="text" name="contact_title[]" id="contact_title_${count}" placeholder="Enter here">

                              </div>
                           </div>

                           <div class="col-lg-4 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>Email</label>
                                 <input type="text" name="contact_email[]" id="contact_email_${count}" placeholder="Enter here">
                              </div>
                           </div>

                           <div class="col-lg-4 col-xl-4  col-sm-6 col-md-6 col-12 cols">
                              <div class="dash_input">
                                 <label>Phone Number</label>
                                 <input type="text" name="contact_phone[]" id="contact_phone_${count}" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                              </div>
                           </div>
                           <a href="javascript:;" class="del-row row-delpos position-absolute"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>`;
             
                     $('.more-contact-info').append(html); 
                     count++;     

        })
   })
</script>
<script>
   $("body").on('click','.del-row',function(){

         $(this).parent().hide();
   })
</script>
@endsection