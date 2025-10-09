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
                             {{ $school->ownership }}
                           </span>
                           @if($school->logo == null)
                                <a href="{{ route('school.details',$school->slug) }}">
                                    <img src="{{asset('public/default_images/default.jpg')}}" alt="" />
                                </a>
                            @else
                                <a href="{{ route('school.details',$school->slug) }}">
                                    <img 
                                        src="{{ asset('storage/'. $school->logo) }}" 
                                        alt="{{ $school->name }}" 
                                    />
                                </a>
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
                                        @if($school->reviews_avg_rating)
                                            @php
                                                $avg = round($school->reviews_avg_rating, 1); // e.g. 3.7
                                                $fullStars = floor($avg); // 3
                                                $halfStar = ($avg - $fullStars) >= 0.5; // true if >= .5
                                            @endphp

                                            {{-- Full stars --}}
                                            @for($i = 1; $i <= $fullStars; $i++)
                                                <li><img src="{{ asset('images/fstar.png') }}" alt="★"></li>
                                            @endfor

                                            {{-- Half star --}}
                                            @if($halfStar)
                                                <li><img src="{{ asset('images/star-half.png') }}" alt="☆"></li>
                                            @php $fullStars++; @endphp
                                            @endif

                                            {{-- Empty stars --}}
                                            @for($i = $fullStars + 1; $i <= 5; $i++)
                                                <li><img src="{{ asset('images/lstar.png') }}" alt="✩"></li>
                                            @endfor
                                        @else
                                            @for($i = 1; $i <= 5; $i++)
                                                <li><img src="{{ asset('images/lstar.png') }}" alt="✩"></li>
                                            @endfor
                                        @endif
                                    </ul>
                              </div>

                              <div class="search_price">
                                <h3>
                                    Fees: 
                                    @if($min_fee && $max_fee)
                                        <span>{{ $currency }} {{ $min_fee }} - {{ $max_fee }}</span>
                                    @else
                                        <span>N/A</span>
                                    @endif
                                </h3>
                                <p>
                                    <img src="{{ asset('images/map-pin.png') }}" alt="">{{ $school->country->name }}, {{ $school->county->name }}
                                </p>
                            </div>
                        </div>

                        <p class="sc_des"> 
                            @if(strlen($school->description)>500)
                           {{ substr($school->description,0,500) }}
                           @else
                           {{ $school->description }}
                            @endif
                        </p>

                           <div class="box_info">
                              <div class="type_list">
                                 <div class="tpe_p">
                                    <span>Type: </span>
                                    <p>
                                        {{ optional($school->schoolLevel)->name }} 
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Curriculum: </span>
                                    <p>
                                        {{ $school->curriculum?->name ?? 'Not specified' }}
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Gender: </span>
                                    <p>
                                        {{ $school->gender_admission }} 
                                    </p>
                                 </div>
                                 <div class="tpe_p">
                                    <span>Shifting: </span>
                                    <p>
                                       {{ $school->type->name ?? 'N/A' }}
                                    </p>
                                 </div>
                              </div>
                              <a href="{{ route('school.details',$school->slug) }}" class="view_btns">View School <img src="{{ asset('images/chevron-rights.png') }}" alt=""> </a>
                           </div>

                        </div>
                     </div>

                  </div>

                    <div class="dashboard_box mt-4">
                        <form action="{{ route('user.school.info.update') }}" method="post" id="schoolInfoForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}"> 
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input mb-2">
                                        <label>School Name:</label>
                                        <input type="text" name="school_name" placeholder="Enter here"  value="{{ $school->name }}">
                                    </div>
                                </div>
                                    <div class="col-12">
                                        <div class="dash_input">
                                            <label>Curriculum:</label>
                                            <ul class="category-ul agree d-flex justify-content-start align-items-center">
                                                @if(!empty($curricula))
                                                    @foreach($curricula as $key => $data)
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
                                            @error('board')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6" id="otherPet1" style="display:none;">
                                        <div class="dash_input">
                                        <label>Other:</label>
                                        <input type="text" name="other_board" id="other_board" value="" placeholder="Enter here">
                                        </div>
                                    </div>
                                    
                                    <div class="clearfix"></div>

                                    {{-- 🔹 Gender --}}
                                    <div class="col-lg-6 col-md-6">
                                    <div class="dash_input mb-1">
                                        <label>Gender: </label>
                                    </div>
                                    <div class="check_gender adscl-type">
                                        <ul>
                                        <li>
                                            <input 
                                            type="radio" 
                                            name="gender_admission" 
                                            value="Male" 
                                            @checked(old('gender_admission', $school->gender_admission) == 'Male')
                                            > 
                                            <label><p>Male</p></label>
                                        </li>

                                        <li>
                                            <input 
                                            type="radio" 
                                            name="gender_admission" 
                                            value="Female" 
                                            @checked(old('gender_admission', $school->gender_admission) == 'Female')
                                            > 
                                            <label><p>Female</p></label>
                                        </li>

                                        <li>
                                            <input 
                                            type="radio" 
                                            name="gender_admission" 
                                            value="Mixed" 
                                            @checked(old('gender_admission', $school->gender_admission) == 'Mixed')
                                            > 
                                            <label><p>Both</p></label>
                                        </li>
                                        </ul>
                                    </div>

                                    @error('gender_admission')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    </div>
                                    {{-- 🔹 School Type --}}
                                    <div class="col-lg-6 col-md-6">
                                    <div class="dash_input mb-1">
                                        <label>Type:</label>
                                    </div>
                                    <div class="check_gender adscl-type adscl-tp2">
                                        <ul>
                                        <li>
                                            <input 
                                            type="radio" 
                                            name="school_type_id" 
                                            value="{{ $school_types_day->id }}" 
                                            @checked(old('school_type_id', $school->school_type_id) == $school_types_day->id)
                                            > 
                                            <label><p>Day</p></label>
                                        </li>

                                        <li>
                                            <input 
                                            type="radio" 
                                            name="school_type_id" 
                                            value="{{ $school_types_boarding->id }}" 
                                            @checked(old('school_type_id', $school->school_type_id) == $school_types_boarding->id)
                                            > 
                                            <label><p>Boarding</p></label>
                                        </li>

                                        <li>
                                            <input 
                                            type="radio" 
                                            name="school_type_id" 
                                            value="{{ $school_types_day_n_boarding->id }}" 
                                            @checked(old('school_type_id', $school->school_type_id) == $school_types_day_n_boarding->id)
                                            > 
                                            <label><p>Day & Boarding</p></label>
                                        </li>
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
                                @csrf
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
                                                        <input 
                                                        type="checkbox" 
                                                        name="facilities[]" 
                                                        value="{{ $facility->id }}"
                                                        @checked(
                                                            in_array($facility->id, old('facilities', $school_facilities))
                                                        )
                                                        >
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
                                        <input 
                                            type="text" 
                                            name="other_facilities" 
                                            placeholder="Enter here"
                                            value="{{ old('other_facilities', $school->other_facilities ?? '') }}"
                                        >
                                        </div>
                                    </div>
                                </div>

                                <div class="save_sec">
                                    <button class="save_btns mt-3" type="submit">Save</button>
                                </div>
                            </form>
                        </div>

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
                                                                {{-- Check if previously selected or in old input --}}
                                                                {{ in_array($service->id, old('extended_school_services_id', $selected_extended_services ?? [])) ? 'checked' : '' }}
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
                                                        @php
                                                            $savedFrom = old('day_learn_period_from', $operation_hours[0]['starts_at'] ?? ($schoolDetails->day_learn_period_from ?? null));
                                                        @endphp
                                                        @foreach (range(1,17) as $number)
                                                            @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                            <option value="{{ $time }}" {{ $savedFrom == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
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
                                                        @php
                                                            $savedUntil = old('day_learn_period_until', $operation_hours[0]['ends_at'] ?? ($schoolDetails->day_learn_period_until ?? null));
                                                        @endphp
                                                        @foreach (range(1,17) as $number)
                                                            @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                            <option value="{{ $time }}" {{ $savedUntil == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
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
                                                        @php
                                                            $savedEveningFrom = old('evening_studies_from', $schoolDetails->evening_studies_from ?? null);
                                                        @endphp
                                                        @foreach (range(17,24) as $number)
                                                            @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                            <option value="{{ $time }}" {{ $savedEveningFrom == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
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
                                                        @php
                                                            $savedEveningUntil = old('evening_studies_until', $schoolDetails->evening_studies_until ?? null);
                                                        @endphp
                                                        @foreach (range(17,24) as $number)
                                                            @php $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                                            <option value="{{ $time }}" {{ $savedEveningUntil == $time ? 'selected' : '' }}>
                                                                {{ $time }}
                                                            </option>
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
                            <h2>Teacher-Student ratio <span style="color: red;">*</span></h2>
                            <form action="{{ route('add.school.step4.ratio.update') }}" method="post" enctype="multipart/form-data" id="ratioForm">
                                @csrf
                                <input type="hidden" name="school_master_id" value="{{ $school->id }}">

                                <div class="row align-items-end">
                                    <div class="col-12">
                                        <h3 class="ratio-hd">Students <span style="color: red;">*</span></h3>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="dash_input">
                                                    <label>Total</label>
                                                    <input 
                                                        type="number" 
                                                        name="total_students" 
                                                        id="total_student" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('total_students', $school_population['total_students'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <div class="dash_input">
                                                    <label>Boys</label>
                                                    <input 
                                                        type="number" 
                                                        name="student_boys" 
                                                        id="student_boys" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('student_boys', $school_population['student_boys'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <div class="dash_input">
                                                    <label>Girls</label>
                                                    <input 
                                                        type="number" 
                                                        name="student_girls" 
                                                        id="student_girls" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('student_girls', $school_population['student_girls'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <h3 class="ratio-hd mt-3p">Teachers <span style="color: red;">*</span></h3>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                                <div class="dash_input">
                                                    <label>Total</label>
                                                    <input 
                                                        type="number" 
                                                        name="total_teachers" 
                                                        id="total_teacher" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('total_teachers', $school_population['total_teachers'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <div class="dash_input">
                                                    <label>Male</label>
                                                    <input 
                                                        type="number" 
                                                        name="teacher_male" 
                                                        id="teacher_male" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('teacher_male', $school_population['teacher_male'] ?? '') }}"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                                <div class="dash_input">
                                                    <label>Female</label>
                                                    <input 
                                                        type="number" 
                                                        name="teacher_female" 
                                                        id="teacher_female" 
                                                        placeholder="Enter here" 
                                                        min="0"
                                                        value="{{ old('teacher_female', $school_population['teacher_female'] ?? '') }}"
                                                    >
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
                           <h2>Add Course</h2>
                           <form action="{{ route('user.update.school.subject') }}" method="post" enctype="multipart/form-data" id="subjectForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}">

                            <div class="row">
                                <div class="col-12">
                                 <div class="dash_input">
                                    <label>Courses</label>
                                    <ul class="category-ul subs-list agree d-flex justify-content-start align-items-center flex-wrap">
                                        @foreach($courses as $data)
                                            <li class="mb-1">
                                                <div class="radiobx">
                                                    <label for="">
                                                        {{ $data->name }}
                                                        <input
                                                            type="checkbox"
                                                            name="subject[]"
                                                            value="{{ $data->id }}"
                                                            {{ in_array($data->id, $already_selected_courses_id) ? 'checked' : '' }}
                                                        >
                                                        <span class="checkbox"></span>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <label id="subject[]-error" class="error" for="subject[]" style="display:none;">This field is required.</label>
                                 </div>
                                 
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Other Courses </label>
                                    <input type="text" name="other_subject" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-12">
                                 <button class="submit-ratio mt-1" type="submit">+ &nbsp;Save</button>
                              </div>
                              <div class="col-12">
                                 {{-- <div class="added-subs-div">
                                   @if($school_subject->isNotEmpty())
                                    <h2>Added Course(s)</h2>
                                    @foreach($school_subject as $data)
                                    <div class="added-subs-box position-relative">
                                       <a href="{{ route('user.edit.school',[$school->id,$data->id]) }}" class="edit-subs" style="right: 42px">
                                          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                             <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                             <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                          </svg>                                             
                                       </a>
                                       <a href="{{ route('user.school.subject.delete',[$data->id]) }}" class="edit-subs">
                                       <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path opacity="0.4" d="M13.9121 6.72089C13.9121 6.76906 13.5346 11.5438 13.3189 13.5532C13.1839 14.7864 12.3889 15.5344 11.1965 15.5556C10.2802 15.5762 9.3833 15.5833 8.50083 15.5833C7.56393 15.5833 6.64771 15.5762 5.75835 15.5556C4.60583 15.528 3.81016 14.7652 3.68203 13.5532C3.46021 11.5367 3.08958 6.76906 3.0827 6.72089C3.07581 6.57569 3.12265 6.43757 3.21772 6.32566C3.31141 6.22224 3.44643 6.15991 3.58834 6.15991H13.4133C13.5545 6.15991 13.6827 6.22224 13.7839 6.32566C13.8783 6.43757 13.9258 6.57569 13.9121 6.72089Z" fill="black"/>
                                       <path d="M14.875 4.23357C14.875 3.94245 14.6456 3.71438 14.37 3.71438H12.3047C11.8845 3.71438 11.5194 3.41547 11.4257 2.99403L11.31 2.47767C11.1481 1.85365 10.5894 1.41663 9.96252 1.41663H7.03817C6.40439 1.41663 5.85121 1.85365 5.68312 2.51167L5.57497 2.99474C5.48059 3.41547 5.11548 3.71438 4.69594 3.71438H2.63065C2.3544 3.71438 2.125 3.94245 2.125 4.23357V4.50273C2.125 4.78676 2.3544 5.02192 2.63065 5.02192H14.37C14.6456 5.02192 14.875 4.78676 14.875 4.50273V4.23357Z" fill="black"/>
                                       </svg>                                           
                                       </a>
                                       <ul>
                                          <li>
                                             <h6>Subjects&nbsp;</h6>
                                             <p>:&nbsp;
                                                @if($data->school_subjects)
                                                @foreach($data->school_subjects as $key=>$subject)
                                                {{ $key > 0?',':'' }} {{ $subject->subject }}
                                                @endforeach
                                                @endif
                                               </p>
                                          </li>
                                       </ul>
                                    </div>
                                    @endforeach
                                    @endif
                                 </div> --}}
                              </div>
                           </div>
                           </form>
                        </div>


                        <form action="{{ route('user.update.school.result') }}" method="post" id="resultForm">
                        @csrf
                        <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}">
                        {{-- <input type="hidden" name="school_result_id" id="" value="{{ $schoolResult->id }}"> --}}

                        <input type="hidden" name="complete_step" id="complete_step" value="">
                        <div class="ad-schl-card adscl-crd12">
                        <h2>Add Result</h2>
                           <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                        <label>Exam <span style="color: red;">*</span></label>
                                        <select name="exam">
                                            <option value="" disabled {{ old('exam', @$schoolResult->exam ?? '') == '' ? 'selected' : '' }}>Select</option>
                                            <option value="Half Yearly" {{ old('exam', @$schoolResult->exam) == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                            <option value="Annual" {{ old('exam', @$schoolResult->exam) == 'Annual' ? 'selected' : '' }}>Annual</option>
                                            <option value="Board Exam" {{ old('exam', @$schoolResult->exam) == 'Board Exam' ? 'selected' : '' }}>Board Exam</option>
                                        </select>
                                        @error('exam')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                        <label>Ranking position <span style="color: red;">*</span></label>
                                        <input type="number" name="ranking_position" placeholder="Enter here" min="0"
                                                value="{{ old('ranking_position', @$schoolResult->ranking_position) }}">
                                        @error('ranking_position')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                        <label>Region <span style="color: red;">*</span></label>
                                        <select name="region">
                                            <option value="" disabled {{ old('region', @$schoolResult->region ?? '') == '' ? 'selected' : '' }}>Select</option>
                                            <option value="International" {{ old('region', @$schoolResult->region) == 'International' ? 'selected' : '' }}>International</option>
                                            <option value="National" {{ old('region', @$schoolResult->region) == 'National' ? 'selected' : '' }}>National</option>
                                            <option value="Country" {{ old('region', @$schoolResult->region) == 'Country' ? 'selected' : '' }}>Country</option>
                                            <option value="N/A" {{ old('region', @$schoolResult->region) == 'N/A' ? 'selected' : '' }}>N/A</option>
                                        </select>
                                        @error('region')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                        <label>Mean score points <span style="color: red;">*</span></label>
                                        <input type="text" name="mean_score_point" placeholder="Enter here"
                                                value="{{ old('mean_score_point', @$schoolResult->mean_score_points) }}"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g,'')" maxlength="5">
                                        @error('mean_score_point')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input position-relative g-map">
                                        <label>Mean Grade <span style="color: red;">*</span></label>
                                        <input type="text" name="mean_grade" placeholder="Enter Here"
                                                value="{{ old('mean_grade', $schoolResult->mean_grade) }}">
                                        @error('mean_grade')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="dash_input position-relative g-map">
                                        <label>Number of candidates <span style="color: red;">*</span></label>
                                        <input type="text" name="no_of_candidate" placeholder="Enter Here"
                                                value="{{ old('no_of_candidate', $schoolResult->number_of_candidates) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="5">
                                        @error('no_of_candidate')
                                            <label class="error">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="submit-ratio mt-1" type="submit">Save</button>
                                </div>
                            </div>
                           @if(!empty($schoolResult) && !empty($schoolResult->exam))
                            <div class="col-12 mt-4">
                                <div class="step-5-added-loc">
                                    <h2>Added Results</h2>
                                    @foreach($schoolResults as $data)
                                    <div class="added-subs-box position-relative">
                                       <a href="{{ route('user.edit.school.result', $school->id) }}" class="edit-subs">
                                          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"></path>
                                             <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"></path>
                                             <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"></path>
                                          </svg>                                             
                                       </a>
                                       <ul class="new_rsult_d">
                                          <li>
                                             <h6>Exam</h6>
                                             <p> :
                                                {{ $data['exam'] }}
                                             </p>
                                          </li>
                                          <li>
                                             <h6>Ranking Position</h6>
                                             <p> :{{ $data['ranking_position'] }}</p>
                                          </li>
                                          <li>
                                             <h6>Mean Score</h6>
                                             <p> : {{ $data['mean_score_points'] }}</p>
                                          </li>
                                          <li>
                                             <h6>Mean Grade</h6>
                                             <p> : {{ $data['mean_grade'] }}</p>
                                          </li>                                          
                                       </ul>
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
                        <input type="hidden" name="school_master_id" id="" value="{{ $school->id }}">
                        <input type="hidden" name="image_id" id="image_id" value="">

                        <div class="row">
                           <div class="col-lg-6 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>School Photo</label>
                                 <div class="uplodimgfil2">
                                       <input type="file" name="school_image" id="school_image" class="inputfile2 inputfile-1" data-multiple-caption="{count} files selected">
                                       <label for="school_image">                                          
                                          <h3>Click here to upload </h3>
                                          <img src="{{ asset('images/upload1.png') }}" alt="">
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
                                    @if($schoolPhotos)
                                        @foreach($schoolPhotos as $data)
                                        <div class="col-lg-4 col-xl-3 col-sm-6  col-md-3 col-12 cols cols_img">
                                            
                                            <div class="schol_show_box">
                                            <div class="sch_show_img">
                                                @if($data->image_path != null)
                                                    <img src="{{ asset('storage/' . $data->image_path) }}" alt="">
                                                @endif
                                            </div>
                                            <div class="img_show_actions">
                                                <a href="javascript:;" class="imageEdit" data-image_id="{{ $data->id }}" data-image_url="{{ asset('storage/' . $data->image_path) }}"> <img src="{{ asset('images/edit.png') }}" alt="">   Edit</a>
                                                @if($data->status == 'I')
                                                <a href="{{ route('user.school.image.status.update',$data->id) }}" onclick="return confirm('Do you want to unblock this image?')"> <img src="{{ asset('images/check2.png') }}" alt=""> Unblock</a>
                                                @endif
                                                @if($data->status == 'A')
                                                <a href="{{ route('user.school.image.status.update',$data->id) }}" onclick="return confirm('Do you want to block this image?')"> <img src="{{ asset('images/lock.png') }}" alt=""> Block</a>
                                                @endif
                                            </div>
                                            </div>

                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                           

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
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.imageEdit');
    const imageUpdateForm = document.getElementById('imageUpdate');
    const imageIdInput = document.getElementById('image_id');
    // const previewBox = imageUpdateForm.querySelector('.uplodimgfil2 label img');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.dataset.image_id;
            const imageUrl = this.dataset.image_url;

            // 1️⃣ Show the hidden form
            imageUpdateForm.style.display = 'block';

            // 2️⃣ Inject the image id into the hidden input
            imageIdInput.value = imageId;

            // 3️⃣ Update the preview image inside the upload form
            // if (previewBox) {
            //     previewBox.src = imageUrl;
            // }

            // 4️⃣ Scroll to the form for better UX (optional)
            imageUpdateForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
});
</script>

@endsection