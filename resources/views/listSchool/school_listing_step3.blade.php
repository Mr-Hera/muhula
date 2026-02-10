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
                                    <li class="done"><em></em>
                                        <div>
                                            <small>Step 1</small>
                                        <h6>Basic Information</h6>
                                        </div>
                                        
                                    </li>
                                    <li class="done"><em></em>
                                        <div>
                                            <small>Step 2</small>
                                        <h6>School Details</h6>
                                        </div>
                                        
                                    </li>
                                    <li class="ongoing"><em></em>
                                        <div>
                                            <small>Step 3</small>
                                        <h6>Extra Info</h6>
                                        </div>
                                        
                                    </li>
                                </ul>
                            </div>
                        </div>
                    
                        
                       
                        <div class="ad-schl-card adscl-crd7">
                            <h2>School Services Offered: <span style="color: red;">*</span></h2>
                            <form action="{{ route('school.listing.services.processing') }}" method="post" enctype="multipart/form-data" id="rulesForm">
                                @csrf
                              
                                <div class="row">
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
                                                        // Load saved value (from DB/session)
                                                        $savedFrom = old('day_learn_period_from', $operation_hours[0]['starts_at'] ?? null);
                                                    @endphp
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
                                                    @foreach (range(1,17) as $number) 
                                                    @php
                                                        $time = str_pad($number, 2, '0', STR_PAD_LEFT) . ':00';
                                                        $savedUntil = old('day_learn_period_until', $operation_hours[0]['ends_at'] ?? null);
                                                    @endphp
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
                                    <div class="col-12">
                                        <h3 class="ratio-hd mt-3p">Evening Studies <span style="color: red;">*</span></h3>
                                        <div class="row">
                                        <div class="col-sm-6 col-12">
                                            <div class="dash_input">
                                                <label>From</label>
                                                <select name="evening_studies_from" id="evening_studies_from">
                                                <option value="">Select</option>
                                                    @foreach (range(17,24) as $number) 
                                                    @if($number < 10)
                                                        @php
                                                            $time1 = '0'.$number.':00';
                                                        @endphp
                                                        <option value="{{ $time1 }}" {{ old('evening_studies_from') == $time ? 'selected' : '' }} >{{ $time1 }}</option>
                                                    @else
                                                        @php
                                                            $time2 = $number.':00';
                                                        @endphp
                                                        <option value="{{$time2}}" {{ old('evening_studies_from') == $time ? 'selected' : '' }} >{{$time2}}</option>
                                                    @endif
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
                                                    @if($number < 10)
                                                        @php
                                                            $time1 = '0'.$number.':00';
                                                        @endphp
                                                        <option value="{{ $time1 }}" {{ old('evening_studies_until') == $time ? 'selected' : '' }} >{{ $time1 }}</option>
                                                    @else
                                                        @php
                                                            $time2 = $number.':00';
                                                        @endphp
                                                        <option value="{{$time2}}" {{ old('evening_studies_until') == $time ? 'selected' : '' }} >{{$time2}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                @error('evening_studies_until')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                    </div>
                                </div>
                            </form>
                            @if($operation_hours->count())
                                <div class="row mt-3">
                                    @foreach($operation_hours as $hour)
                                        <div class="col-md-4 col-sm-6 col-12">
                                            <div class="card shadow-sm mb-3">
                                                <div class="card-body p-3">
                                                    <h5 class="mb-2 text-success">
                                                        {{ $hour->period_of_day }}
                                                    </h5>

                                                    <p class="mb-1">
                                                        <strong>From:</strong>
                                                        {{ \Carbon\Carbon::parse($hour->starts_at)->format('H:i') }}
                                                    </p>

                                                    <p class="mb-0">
                                                        <strong>Until:</strong>
                                                        {{ \Carbon\Carbon::parse($hour->ends_at)->format('H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif                       
                        </div>

                        {{-- FEES --}}
                        <div class="ad-schl-card adscl-crd8">
                            <h2>Fees: <span style="color: red;">*</span></h2>
                            <form action="{{ route('school.listing.fees.processing') }}" method="post" enctype="multipart/form-data" id="feesForm">
                                @csrf
                                <div class="row align-items-stretch">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Grade Level</label>
                                            <select name="grade_level" id="">
                                                <option value="" selected disabled>Select</option>
                                                @foreach ($school_levels as $level)
                                                    @if ($level->name != "General")
                                                        <option value="{{ $level->id }}" {{ old('grade_level') == $level->id ? 'selected' : '' }}>{{ $level->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('grade_level')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="fees-tofrm d-flex justify-content-between align-items-end">
                                        <div class="dash_input">
                                            <label>Minimum</label>
                                            <input type="text" name="min_amount" id="from_fees" placeholder="Enter here" value="{{ old('min_amount') }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')"  maxlength="10" />
                                            @error('min_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="dash_input">
                                            <label>Maximum</label>
                                            <input type="text" name="max_amount" id="to_fees" placeholder="Enter here" value="{{ old('max_amount') }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="10" />
                                            @error('max_amount')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <button class="fees-frm2-btn" type="submit">+ Add</button>
                                        
                                        </div>
                                        <label id="to_fees-error" class="error" for="to_fees" style="display:none;">From fees must be less than to fees</label>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-12">
                                        <div class="row">
                                        <div class="col-12">
                                            <em class="fee-ad-ln"></em>
                                        </div>
                                        @if($school_fees->count())
                                            @foreach($school_fees as $data)
                                                <div class="col-lg-6 col-sm-6">
                                                    <div class="added-fees position-relative">
                                                    <h5>{{ $data->level->name }}</h5>
                                                    <p>Fees KES {{ number_format($data->min_amount) }} - KES {{ number_format($data->max_amount) }}</p>
                                                    <a href="{{ route('school.fees.delete', $data->id) }}" class="position-absolute">
                                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.4" d="M13.914 6.72065C13.914 6.76881 13.5365 11.5435 13.3209 13.553C13.1859 14.7862 12.3909 15.5341 11.1984 15.5554C10.2822 15.5759 9.38525 15.583 8.50278 15.583C7.56589 15.583 6.64966 15.5759 5.7603 15.5554C4.60779 15.5278 3.81212 14.7649 3.68398 13.553C3.46216 11.5364 3.09154 6.76881 3.08465 6.72065C3.07776 6.57545 3.1246 6.43733 3.21967 6.32541C3.31336 6.222 3.44838 6.15967 3.59029 6.15967H13.4153C13.5565 6.15967 13.6846 6.222 13.7859 6.32541C13.8803 6.43733 13.9278 6.57545 13.914 6.72065Z" fill="black"/>
                                                            <path d="M14.875 4.23345C14.875 3.94233 14.6456 3.71426 14.37 3.71426H12.3047C11.8845 3.71426 11.5194 3.41535 11.4257 2.99391L11.31 2.47755C11.1481 1.85353 10.5894 1.4165 9.96252 1.4165H7.03817C6.40439 1.4165 5.85121 1.85353 5.68312 2.51155L5.57497 2.99462C5.48059 3.41535 5.11548 3.71426 4.69594 3.71426H2.63065C2.3544 3.71426 2.125 3.94233 2.125 4.23345V4.5026C2.125 4.78664 2.3544 5.02179 2.63065 5.02179H14.37C14.6456 5.02179 14.875 4.78664 14.875 4.5026V4.23345Z" fill="black"/>
                                                        </svg>
                                                    </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="ad-schl-card adscl-crd7">
                            <h2>Teacher-Student ratio: <span style="color: red;">*</span></h2>
                            <form action="{{ route('school.listing.step4.ratio.processing') }}" method="post" enctype="multipart/form-data" id="ratioForm">
                              @csrf
                              
                              <div class="row align-items-end">
                                 <div class="col-12">
                                    <h3 class="ratio-hd">Students <span style="color: red;">*</span></h3>
                                    <div class="row">
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Total</label>
                                             <input type="number" name="total_students" id="total_student" placeholder="Enter here" min="0">
                                             <label id="total_student-error" class="error" for="total_student" style="display:none;">Please enter valid number</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Boys</label>
                                             <input type="number" name="student_boys" id="student_boys" placeholder="Enter here" min="0">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Girls</label>
                                             <input type="number" name="student_girls" id="student_girls" placeholder="Enter here" min="0">
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
                                             <input type="number" name="total_teachers" id="total_teacher" placeholder="Enter here" min="0">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Male</label>
                                             <input type="number" name="teacher_male" id="teacher_male" placeholder="Enter here" min="0">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Female</label>
                                             <input type="number" name="teacher_female" id="teacher_female" placeholder="Enter here" min="0">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                            </form>
                            @if($school_population && (
                                $school_population['total_students'] !== null || 
                                $school_population['total_teachers'] !== null
                            ))
                                <div class="row mt-3">
                                    <!-- Students Card -->
                                    <div class="col-md-6 col-sm-12">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body p-3">
                                                <h5 class="mb-2 text-success">Students</h5>
                                                @if($school_population['total_students'] !== null)
                                                    <p class="mb-1">
                                                        <strong>Total:</strong> {{ $school_population['total_students'] }}
                                                    </p>
                                                @endif
                                                @if($school_population['student_boys'] !== null)
                                                    <p class="mb-1">
                                                        <strong>Boys:</strong> {{ $school_population['student_boys'] }}
                                                    </p>
                                                @endif
                                                @if($school_population['student_girls'] !== null)
                                                    <p class="mb-0">
                                                        <strong>Girls:</strong> {{ $school_population['student_girls'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Teachers Card -->
                                    <div class="col-md-6 col-sm-12">
                                        <div class="card shadow-sm mb-3">
                                            <div class="card-body p-3">
                                                <h5 class="mb-2 text-success">Teachers</h5>
                                                @if($school_population['total_teachers'] !== null)
                                                    <p class="mb-1">
                                                        <strong>Total:</strong> {{ $school_population['total_teachers'] }}
                                                    </p>
                                                @endif
                                                @if($school_population['teacher_male'] !== null)
                                                    <p class="mb-1">
                                                        <strong>Male:</strong> {{ $school_population['teacher_male'] }}
                                                    </p>
                                                @endif
                                                @if($school_population['teacher_female'] !== null)
                                                    <p class="mb-0">
                                                        <strong>Female:</strong> {{ $school_population['teacher_female'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- BRANCHES --}}
                        <form action="{{ route('school.listing.branch.save') }}" method="POST" enctype="multipart/form-data" id="branchForm">
                            @csrf

                            <div class="ad-schl-card adscl-crd12">
                                <h2>School Branch:</h2>
                                <label>
                                    If no branches are available
                                    <span style="color: red;"><b>"skip section"</b></span>
                                </label>
                                <br><br>

                                <div class="row">

                                    {{-- Branch Name --}}
                                    <div class="col-12">
                                        <div class="dash_input">
                                            <label>Branch Name <span style="color: red;">*</span></label>
                                            <input type="text"
                                                name="name"
                                                placeholder="Enter here"
                                                value="{{ old('name') }}">
                                            @error('name')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- School Level / Type --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>School Level <span style="color: red;">*</span></label>
                                            <select name="school_type_id">
                                                <option value="">Select</option>
                                                @foreach($school_levels as $level)
                                                    @if ($level->name !== 'General')
                                                        <option value="{{ $level->id }}"
                                                            {{ old('school_type_id') == $level->id ? 'selected' : '' }}>
                                                            {{ $level->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('school_type_id')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Country --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Country <span style="color: red;">*</span></label>
                                            <select name="country_id">
                                                <option value="" disabled selected hidden>Select</option>
                                                @foreach($countries as $country)
                                                    @if ($country->name === 'Kenya')
                                                        <option value="{{ $country->id }}"
                                                            {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Town / County --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>
                                                Town
                                                <span class="d-inlne-block ml-1 tooltip-main position-relative">
                                                    <i class="fa fa-info-circle"></i>
                                                    <div class="tooltip-body position-absolute">
                                                        If town is missing scroll to bottom & select other to add missing town.
                                                    </div>
                                                </span>
                                                <span style="color: red;">*</span>
                                            </label>

                                            <select name="county_id" id="town">
                                                <option value="">Select</option>
                                                @foreach($counties as $county)
                                                    <option value="{{ $county->id }}"
                                                        {{ old('county_id') == $county->id ? 'selected' : '' }}>
                                                        {{ $county->name }}
                                                    </option>
                                                @endforeach
                                                <option value="0" {{ old('county_id') == '0' ? 'selected' : '' }}>Other</option>
                                            </select>

                                            @error('county_id')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Other Town --}}
                                    <div class="col-lg-6 col-md-6" style="display:none;" id="otherTown">
                                        <div class="dash_input">
                                            <label>Other Town</label>
                                            <input type="text"
                                                name="other_town"
                                                placeholder="Enter here"
                                                value="{{ old('other_town') }}">
                                        </div>
                                    </div>

                                    {{-- Full Address --}}
                                    <div class="col-12">
                                        <div class="dash_input">
                                            <label>Full Address <span style="color: red;">*</span></label>
                                            <input type="text"
                                                name="full_address"
                                                placeholder="Enter here"
                                                value="{{ old('full_address') }}">
                                            @error('full_address')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Google Map --}}
                                    <div class="col-12">
                                        <div class="dash_input position-relative g-map">
                                            <label>Google map location</label>
                                            <input type="text"
                                                name="google_location"
                                                placeholder="Enter / paste link here"
                                                value="{{ old('google_location') }}">
                                            <img src="{{ asset('images/google-map.png') }}" class="position-absolute">
                                            <input type="hidden" name="google_lat" value="{{ old('google_lat') }}">
                                            <input type="hidden" name="google_long" value="{{ old('google_long') }}">
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Email <span style="color: red;">*</span></label>
                                            <input type="email"
                                                name="email"
                                                placeholder="Enter here"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Phone <span style="color: red;">*</span></label>
                                            <input type="text"
                                                name="phone_no"
                                                placeholder="Enter here"
                                                value="{{ old('phone_no') }}">
                                            @error('phone_no')
                                                <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Images --}}
                                    <div class="col-12">
                                        <div class="step5-imgupld">
                                            <div class="uplodimgfil upld-schl-images">
                                                <input type="file"
                                                    name="school_image[]"
                                                    class="inputfile inputfile-1"
                                                    multiple
                                                    accept="image/*">
                                                <label>
                                                    <img src="{{ asset('images/upload.png') }}" alt="">
                                                    <h3>Upload Branch Images</h3>
                                                </label>
                                            </div>

                                            @error('school_image')
                                                <label class="error">{{ $message }}</label>
                                            @enderror

                                            <div class="upldd-scl-imgs" id="imagePreviewContainer"></div>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-12">
                                        <button class="submit-ratio mt-1" type="submit">
                                            <span>+</span> &nbsp;Add
                                        </button>
                                    </div>

                                </div>
                            </div>

                            {{-- ADDED BRANCHES --}}
                            @if($school_branches->isNotEmpty())
                                <div class="ad-schl-card adscl-crd13 mt-4">
                                    <h2>Added Branches</h2>

                                    @foreach($school_branches as $branch)
                                        <div class="added-subs-box position-relative">

                                            {{-- Button container --}}
                                            {{-- <div class="branch-actions d-flex justify-content-end gap-2 mb-2"> --}}
                                                {{-- Edit trigger --}}
                                                {{-- <a href="javascript:void(0)"
                                                class="branch-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBranch{{ $branch->id }}"
                                                title="Edit Branch">
                                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                                        <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                                        <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                                    </svg>
                                                </a> --}}

                                                {{-- Delete trigger --}}
                                                {{-- <a href="javascript:void(0)"
                                                class="branch-btn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteBranch{{ $branch->id }}"
                                                title="Delete Branch">
                                                    🗑️
                                                </a> --}}
                                            {{-- </div> --}}

                                            <ul>
                                                <li>
                                                    <h6>Branch Name</h6>
                                                    <p>: {{ $branch->name }}</p>
                                                </li>

                                                <li>
                                                    <h6>School</h6>
                                                    <p>: {{ $school->name }}</p>
                                                </li>

                                                <li>
                                                    <h6>County</h6>
                                                    <p>: {{ optional($branch->county)->name }}</p>
                                                </li>

                                                {{-- @if($branch->email)
                                                    <li>
                                                        <h6>Email</h6>
                                                        <p>: {{ $branch->email }}</p>
                                                    </li>
                                                @endif

                                                @if($branch->phone_no)
                                                    <li>
                                                        <h6>Phone</h6>
                                                        <p>: {{ $branch->phone_no }}</p>
                                                    </li>
                                                @endif --}}
                                            </ul>
                                        </div>

                                        {{-- EDIT BRANCH MODAL --}}
                                        <div class="modal fade" id="editBranch{{ $branch->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <form method="POST" action="{{ route('school.branch.update', $branch->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit School Branch</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">

                                                            <div class="ad-schl-card adscl-crd12">
                                                                <div class="row">

                                                                    {{-- Branch Name --}}
                                                                    <div class="col-12">
                                                                        <div class="dash_input">
                                                                            <label>Branch Name <span style="color:red;">*</span></label>
                                                                            <input type="text"
                                                                                name="name"
                                                                                value="{{ old('name', $branch->name) }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- School Level / Type --}}
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="dash_input">
                                                                            <label>School Level <span style="color:red;">*</span></label>
                                                                            <select name="school_type_id">
                                                                                <option value="">Select</option>
                                                                                @foreach($school_levels as $level)
                                                                                    @if($level->name !== 'General')
                                                                                        <option value="{{ $level->id }}"
                                                                                            {{ old('school_type_id', $branch->school_type_id) == $level->id ? 'selected' : '' }}>
                                                                                            {{ $level->name }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Country --}}
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="dash_input">
                                                                            <label>Country <span style="color:red;">*</span></label>
                                                                            <select name="country_id">
                                                                                @foreach($countries as $country)
                                                                                    @if($country->name === 'Kenya')
                                                                                        <option value="{{ $country->id }}"
                                                                                            {{ old('country_id', optional($branch->county)->country_id) == $country->id ? 'selected' : '' }}>
                                                                                            {{ $country->name }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Town / County --}}
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="dash_input">
                                                                            <label>
                                                                                Town
                                                                                <span class="d-inlne-block ml-1 tooltip-main position-relative">
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                    <div class="tooltip-body position-absolute">
                                                                                        If town is missing scroll to bottom & select other to add missing town.
                                                                                    </div>
                                                                                </span>
                                                                                <span style="color:red;">*</span>
                                                                            </label>

                                                                            <select name="county_id">
                                                                                <option value="">Select</option>
                                                                                @foreach($counties as $county)
                                                                                    <option value="{{ $county->id }}"
                                                                                        {{ old('county_id', $branch->county_id) == $county->id ? 'selected' : '' }}>
                                                                                        {{ $county->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                                <option value="0">Other</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    {{-- Full Address --}}
                                                                    <div class="col-12">
                                                                        <div class="dash_input">
                                                                            <label>Full Address <span style="color:red;">*</span></label>
                                                                            <input type="text"
                                                                                name="full_address"
                                                                                value="{{ old('full_address', optional($branch->address)->address_text) }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Google Map --}}
                                                                    <div class="col-12">
                                                                        <div class="dash_input position-relative g-map">
                                                                            <label>Google map location</label>
                                                                            <input type="text"
                                                                                name="google_location"
                                                                                value="{{ old('google_location', optional($branch->address)->google_location) }}">
                                                                            <img src="{{ asset('images/google-map.png') }}" class="position-absolute">

                                                                            <input type="hidden" name="google_lat"
                                                                                value="{{ old('google_lat', optional($branch->address)->lat) }}">
                                                                            <input type="hidden" name="google_long"
                                                                                value="{{ old('google_long', optional($branch->address)->lng) }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Email --}}
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="dash_input">
                                                                            <label>Email <span style="color:red;">*</span></label>
                                                                            <input type="email"
                                                                                name="email"
                                                                                value="{{ old('email', $branch->email) }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Phone --}}
                                                                    <div class="col-lg-6 col-md-6">
                                                                        <div class="dash_input">
                                                                            <label>Phone <span style="color:red;">*</span></label>
                                                                            <input type="text"
                                                                                name="phone_no"
                                                                                value="{{ old('phone_no', $branch->phone_no) }}">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Images --}}
                                                                    <div class="col-12">
                                                                        <div class="step5-imgupld">
                                                                            <div class="uplodimgfil upld-schl-images">
                                                                                <input type="file"
                                                                                    name="school_image[]"
                                                                                    class="inputfile inputfile-1"
                                                                                    multiple
                                                                                    accept="image/*">
                                                                                <label>
                                                                                    <img src="{{ asset('images/upload.png') }}" alt="">
                                                                                    <h3>Upload Branch Images</h3>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>
                                                            <button type="submit"
                                                                    class="btn btn-success">
                                                                Save changes
                                                            </button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- END EDIT BRANCH MODAL --}}

                                        {{-- DELETE BRANCH MODAL --}}
                                        <div class="modal fade" id="deleteBranch{{ $branch->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <form method="POST"
                                                    action="{{ route('school.branch.delete', $branch->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-danger">Delete Branch</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>
                                                                Are you sure you want to delete the branch
                                                                <strong>{{ $branch->name }}</strong>?
                                                            </p>
                                                            <p class="text-muted mb-0">
                                                                This action cannot be undone.
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">
                                                                Cancel
                                                            </button>

                                                            <button type="submit"
                                                                    class="btn btn-danger">
                                                                Yes, Delete
                                                            </button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        {{-- END DELETE BRANCH MODAL --}}

                                    @endforeach
                                </div><br>
                            @endif
                        </form>

                        {{-- RESULTS --}}
                        <form action="{{ route('school.listing.results.save') }}" method="post" id="resultForm">
                            @csrf
                            
                            <div class="ad-schl-card adscl-crd12">
                                <div class="row">
                                    <h2>Results <span style="color: red;">*</span></h2>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Exam <span style="color: red;">*</span></label>
                                            <select name="exam" id="">
                                            <option value="" disabled {{ old('exam') ? '' : 'selected' }}>Select</option>
                                            <option value="Half Yearly" {{ old('exam') == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                            <option value="Annual" {{ old('exam') == 'Annual' ? 'selected' : '' }}>Annual</option>
                                            <option value="Board Exam" {{ old('exam') == 'Board Exam' ? 'selected' : '' }}>Board Exam</option>
                                            </select>
                                            @error('exam')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Ranking position <span style="color: red;">*</span></small></label>
                                            <input type="number" name="ranking_position" placeholder="Enter here" min="0" value="{{ old('ranking_position') }}" />
                                            @error('ranking_position')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Region <span style="color: red;">*</span></label>
                                            <select name="region" id="">
                                            <option value="" disabled {{ old('region') ? '' : 'selected' }}>Select</option>
                                            <option value="International" {{ old('region') == 'International' ? 'selected' : '' }}>International</option>
                                            <option value="National" {{ old('region') == 'National' ? 'selected' : '' }}>National</option>
                                            <option value="Country" {{ old('region') == 'Country' ? 'selected' : '' }}>Country</option>
                                            <option value="N/A" {{ old('region') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                            </select>
                                            @error('region')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input">
                                            <label>Mean score points <span style="color: red;">*</span></label>
                                            <input type="text" name="mean_score_point" placeholder="Enter here" value="{{ old('mean_score_point') }}" />
                                            @error('mean_score_point')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input position-relative g-map">
                                            <label>Mean Grade <span style="color: red;">*</span></label>
                                            <input type="text" name="mean_grade" placeholder="Enter Here" value="{{ old('mean_grade') }}" />
                                            @error('mean_grade')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="dash_input position-relative g-map">
                                            <label>Number of candidates <span style="color: red;">*</span></label>
                                            <input type="text" name="no_of_candidate" placeholder="Enter Here" value="{{ old('no_of_candidate') }}" />
                                            @error('no_of_candidate')
                                            <label class="error">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button class="submit-ratio mt-1" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>

                            @if($examPerformanceRecords->count() > 0)
                                <div class="ad-schl-card adscl-crd13">

                                    <div class="row">

                                        <div class="col-12">
                                            <div class="step-5-added-loc">
                                                <h2>Added Results</h2>

                                                @foreach($examPerformanceRecords as $data)
                                                <div class="added-subs-box position-relative">
                                                <a href="{{ route('add.school.step7') }}" class="edit-subs">
                                                    {{-- SVG ICON --}}
                                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                                        <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                                        <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                                    </svg>
                                                </a>
                                                <ul class="new_rsult_d">
                                                    <li><h6>Exam</h6><p>: {{ $data['exam'] }}</p></li>
                                                    <li><h6>Ranking Position</h6><p>: {{ $data['ranking_position'] }}</p></li>
                                                    
                                                    <li><h6>Mean Score Points</h6><p>: {{ $data['mean_score_points'] }}</p></li>
                                                    <li><h6>Mean Grade</h6><p>: {{ $data['mean_grade'] }}</p></li>
                                                    <li><h6>Number of Candidates</h6><p>: {{ $data['number_of_candidates'] }}</p></li>
                                                </ul>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            @endif
                            <br>
                        </form>


                     <div class="ad-schl-card adscl-crd4">
                        <div class="ad-schl-sub-go mt-0">
                           <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                              <button id="submitBtn" data-url="{{ route('school.listing.success') }}">Save and Complete! 
                              </button>
                              {{-- <a href="{{ route('add.school.step3') }}">
                                 <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                                 Back   
                              </a> --}}
                           </div>
                           <p>Step 3 Of 3</p>
                        </div>
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

{{-- handle uploaded school branch images --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.querySelector('input[name="school_image[]"]');
    const previewContainer = document.getElementById('imagePreviewContainer');

    input.addEventListener('change', function () {
        previewContainer.innerHTML = ''; // Clear previous images

        const files = Array.from(this.files);

        files.forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';       // thumbnail width
                img.style.height = '100px';      // thumbnail height
                img.style.objectFit = 'cover';   // crop nicely
                img.style.marginRight = '10px';  // spacing
                img.style.marginBottom = '10px';
                img.style.borderRadius = '5px';
                img.style.border = '1px solid #ccc';
                previewContainer.appendChild(img);
            }
            reader.readAsDataURL(file);
        });
    });
});
</script>

<script>
   $(document).ready(function(){


      $.validator.addMethod("total_student_valid", function(value, element) {
       
         let total_student = parseInt($('#total_student').val());
         let student_boys = parseInt($('#student_boys').val());
         let student_girls = parseInt($('#student_girls').val());
         let sum_of_student = student_boys+student_girls
           console.log(student_boys);
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

                  //required: true,
                  digits: true,
                  maxlength: 10,
                   
                   total_student_valid: true,
                  
               },
               student_boys: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               student_girls: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               total_teacher: {

                 // required: true,
                  digits: true,
                  maxlength: 10,
                  total_teacher_valid: true,
               },
               teacher_male: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               teacher_female: {

                  //required: true,
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

{{-- school branch images preview --}}
<script>
document.getElementById('school_image').addEventListener('change', function (event) {
    const previewContainer = document.getElementById('imagePreviewContainer');
    previewContainer.innerHTML = ''; // clear old previews

    const files = event.target.files;

    if (!files || files.length === 0) return;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            const wrapper = document.createElement('em');
            wrapper.classList.add('schl-img-nw');

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Preview';

            wrapper.appendChild(img);
            previewContainer.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    });
});
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
                  mintime: function(element){
                        if($("#day_learn_period_from").val() != ""){
                          return true;
                       }
                  },
               },
               evening_studies_from: {

                  //required: true,
               },
               evening_studies_until: {

                  //required: true,
                  mintime1: function(element){
                        if($("#evening_studies_from").val() != ""){
                          return true;
                       }
                  },
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

        $('#otherpetdrop1').click(function(){

              if($('#otherpetdrop1').is(":checked")){

                  $('#otherPet1').css('display','block');
                  $('#other_board').rules('add','required');
              }else{

                  $('#otherPet1').css('display','none');
                  $('#other_board').rules('remove','required');
                  $('#other_board').val('');
                  
              }
        })
   })
</script>
<script>
    $(document).ready(function() {
      let minusBtn = document.getElementById("minus-btn");
      let count = document.getElementById("count");
      let plusBtn = document.getElementById("plus-btn");
      @if($schoolDetails?->teacher_student_ratio != null)
      let countNum = '{{ $schoolDetails->teacher_student_ratio }}';
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

       $('#relationship_id').change(function(){

           let value = $(this).val();
           if(value == '0'){
               
              $('#otherRelationship').css('display','block');
              $('#other_relationship').rules('add','required');
               
           }else{

              $('#otherRelationship').css('display','none');
              $('#other_relationship').rules('remove','required');
              $('#other_relationship').val('');
           }
       })

       $('#submitBtn').click(function(e){
             e.preventDefault();
            let nextUrl = $(this).data('url');
            window.location.href = nextUrl;
       })
   })
</script>

<script>
   $(document).ready(function(){

      $.validator.addMethod("priceMin", function(value, element) {

          let from_price = parseInt($('#from_fees').val());
          let to_price =  parseInt($('#to_fees').val());

          if(from_price > to_price){

              return false;
          }else{

            return true;
          }
         
      }, "From fees must be less than to fees");

        $('#feesForm').validate({

            rules: {

               grade: {

                   required: true,
               },
               from_fees: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               to_fees: {

                  required: true,
                  digits: true,
                  maxlength: 10,
                  priceMin: true, 
               }
            },
            submitHandler: function(form){

                 form.submit();
            }
        })
   })
</script>
@endsection 