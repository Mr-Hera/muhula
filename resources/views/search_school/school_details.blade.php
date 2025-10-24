@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
<style>
  .error{

     color:red !important;
  }
  .popup_popup {
    display: none !important;
}
.schoolUniform {
    cursor: pointer;
}
</style>
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
@if(@$schoolDetails->youtube_link != null)
<section class="school-banner position-relative w-100 overflow-hidden">
   @if( @$schoolDetails->header_image != null)
   <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$schoolDetails->header_image }}" alt="" class="blurred-image">
   <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$schoolDetails->header_image }}" alt="" class="img-clear">
   @else
   <img src="{{ asset('storage/default_images/default.jpg') }}" alt="" class="blurred-image">
   <img src="{{ asset('storage/default_images/default.jpg') }}" alt="" class="img-clear">
   @endif
   <a href="javascript:;" id="play-video" class="video-play-button">
   <span></span>
   </a>
   @php
   $current_date = date('Y-m-d');
   $expire_date = date('Y-m-d',strtotime(@Auth::user()->subscription_expire_date));
   @endphp
   @if(@$schoolDetails->getClaim->user_id == @Auth::user()->id && @$schoolDetails->getClaim->status == 'AP' && @$current_date <= @$expire_date)
   <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#myModalHeader" class="open-modal-btn">Add Background Header Image/Video</a>
   @endif
</section>
@endif
@if(@$schoolDetails->youtube_link == null)
<div class="position-relative">
<a href="javascript:;" class="school-banner position-relative w-100 overflow-hidden img-trigger">
   @php
      // Compute expected storage path (relative to 'public' disk)
      $logoPath = $school_record->logo 
         ? 'public/' . ltrim($school_record->logo, '/') 
         : 'public/default_images/default.jpg';

      // Determine which path to display
      $finalPath = Storage::exists($logoPath) 
         ? $logoPath 
         : 'public/default_images/default.jpg';

      $logoUrl = Storage::url($finalPath);
   @endphp

   <img src="{{ $logoUrl }}" alt="{{ $school_record->name ?? 'Default Logo' }}" class="blurred-image">
   <img src="{{ $logoUrl }}" alt="{{ $school_record->name ?? 'Default Logo' }}" class="img-clear">
</a>
@php
$current_date = date('Y-m-d');
$expire_date = date('Y-m-d',strtotime(@Auth::user()->subscription_expire_date));
@endphp
@if(@$schoolDetails->getClaim->user_id == @Auth::user()->id && @$schoolDetails->getClaim->status == 'AP' && @$current_date <= @$expire_date)
<a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#myModalHeader" class="open-modal-btn">Add Background Header Image/Video</a>
@endif
</div>
@endif
<section class="search_countown">
         <div class="container">
            <div class="row">
               <div class="result_div">
                     <form action="{{ route('school.search') }}" class="sorts-srch d-flex" method="post">
                        @csrf
                        <div class="search_in">
                           <label>Search by Location</label>
                           <input type="text" name="location" placeholder="Enter here">
                        </div>
                        <div class="search_in">
                           <label>Search by Keywords</label>
                           <input type="text" name="keyword" placeholder="Enter here">
                        </div>
                        <button type="submit" class="loc-key-srch"><img src="{{ asset('images/search.png') }}" alt=""> </button>
                     </form>
               </div>
            </div>
         </div>
      </section>
<section class="inner_banner schoo_de_bread">
         <div class="in-bn-txt">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">{{ $school_record->country->name }}</a></li>
                    @if($school_record->county->name != null)
                     <li class="breadcrumb-item"><a href="javascript:;">{{ $school_record->county->name }}</a></li>
                    @endif                    
                    <li class="breadcrumb-item active" aria-current="page">{{ $school_record->name }}</li>
                  </ol>
                </nav>
            </div>         
         </div>
      </section>

      <section class="school_details_sec">
         <div class="school_top_infos">
            <div class="container">
            @include('includes.message')
               <div class="row">
                  <div class="school_inos">
                     <div class="school_img_name">
                        <div class="school_de_img">
                           <span class="res-tab m-0">
                              @if($school_record->ownership == 'Public')
                                 Public
                              @elseif($school_record->ownership == 'Private')
                                 Private
                              @endif
                          </span>
                           @php
                              $logoPath = $school_record->logo 
                                 ? 'public/' . $school_record->logo 
                                 : 'public/default_images/default.jpg';
                           @endphp

                           @if(Storage::exists($logoPath))
                              <img src="{{ Storage::url($logoPath) }}" alt="{{ $school_record->name }}">
                           @else
                              <img src="{{ Storage::url('public/default_images/default.jpg') }}" alt="Default Logo">
                           @endif
                        </div>
                        <div class="school_names">
                           <h3>{{ $school_record->name }}
                           {{-- @Auth
                              @php
                                 $check = App\Models\Favourite::where('user_id',@Auth::user()->id)->where('school_id',@$schoolDetails->id)->first();
                              @endphp
                              <a href="javascript:;" class="add-fav @if(@$check) active @endif" data-id="{{@$schoolDetails->id}}">
                                 <span class="fav-tooltip">@if(@$check) Added To Favourite @else Add To Favourite @endif</span>
                                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.8401 4.61012C20.3294 4.09912 19.7229 3.69376 19.0555 3.4172C18.388 3.14064 17.6726 2.99829 16.9501 2.99829C16.2276 2.99829 15.5122 3.14064 14.8448 3.4172C14.1773 3.69376 13.5709 4.09912 13.0601 4.61012L12.0001 5.67012L10.9401 4.61012C9.90843 3.57842 8.50915 2.99883 7.05012 2.99883C5.59109 2.99883 4.19181 3.57842 3.16012 4.61012C2.12843 5.64181 1.54883 7.04108 1.54883 8.50012C1.54883 9.95915 2.12843 11.3584 3.16012 12.3901L4.22012 13.4501L12.0001 21.2301L19.7801 13.4501L20.8401 12.3901C21.3511 11.8794 21.7565 11.2729 22.033 10.6055C22.3096 9.93801 22.4519 9.2226 22.4519 8.50012C22.4519 7.77763 22.3096 7.06222 22.033 6.39476C21.7565 5.7273 21.3511 5.12087 20.8401 4.61012Z" stroke="#B9B9B9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </a>
                           @endauth --}}
                           </h3>
                           <div class="nature_s">
                              {{-- @if($school_record->type)
                                 @foreach($school_record->type as $type)
                                    <h6>{{ $type->name }}</h6>
                                 @endforeach
                              @endif --}}
                              @if($school_record->type)
                                    <h6>{{ $school_record->type->name }}</h6>
                                 @else
                                    <h6>Not Defined</h6>
                                 @endif
                           </div>
                           {{-- <ul class="stars_sc">
                                 @if($schoolDetails->avg_review)
                                    @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                                    @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                                       <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                                    @endfor
                                    @if(strpos($schoolDetails->avg_review,'.'))
                                       <li><img src="{{asset('images/star-half.png')}}"></li>
                                       @php $sst++; @endphp
                                    @endif
                                    @while ($sst<=5)
                                       <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                                       @php $sst++; @endphp
                                    @endwhile
                                 @else
                                    @for($sst = 1; $sst <= 5; $sst++)
                                       <li><img src="{{ asset('public/images/lstar.png') }}" alt=""></li>                              
                                    @endfor
                                 @endif
                              <li> <p>({{ $schoolDetails->tot_review }} reviews)</p> </li>
                           </ul> --}}
                           <div class="sc_thub_ab">
                              <p>Address: {{ optional($school_record->address)->address_text ?? 'Address not available' }}</p>
                           </div>
                           {{-- @if($contact_info->isNotEmpty())
                              @foreach($contact_info as $contact)
                              <div class="sc_thub_ab">
                                 <p class="border-none text-capital">
                                    {{ optional(optional($school_record->contact)->position)->name }}&nbsp;-
                                 </p>
                                 @if(optional($school_record->contact)->contact_email)
                                    <p>{{ $school_record->contact->contact_email }}</p>
                                    <span>,</span>
                                 @endif
                                 @if(optional($school_record->contact)->contact_phone)
                                    <p>{{ $school_record->contact->contact_phone }}</p>
                                 @endif
                              </div>
                              @endforeach
                           @else
                              <div class="sc_thub_ab">
                                 @if(optional($school_record->contact)->contact_email)
                                    <p>{{ $school_record->contact->contact_email }}</p>
                                 @endif
                                 @if(optional($school_record->contact)->contact_phone)
                                    <span class="no-marmin">|</span>
                                    <p>{{ $school_record->contact->contact_phone }}</p>
                                 @endif
                              </div>
                           @endif --}}
                           <div class="sc_thub_ab">
                              @if(optional($school_record->contact)->contact_email)
                                 <p>{{ $school_record->contact->contact_email }}</p>
                              @endif
                              @if(optional($school_record->contact)->contact_phone)
                                 <span class="no-marmin">|</span>
                                 <p>{{ $school_record->contact->contact_phone }}</p>
                              @endif
                           </div>

                           <div class="sc_thub_ab">
                              @if($school_record->year_of_establishment != null)
                                 <p class="text-capital">Year of establishment: {{ $school_record->year_of_establishment }} </p>
                                 <span class="no-marmin">|</span>
                              @endif
                              <p>
                                 Education System: 
                                 {{-- @if($school_record->school_boards)
                                    @foreach($school_record->school_boards as $key=>$schoolboard)
                                    {{ @$key > 0?',':'' }} {{ $schoolboard->board_name }}
                                    @endforeach
                                 @endif --}}
                                 {{ optional($school_record->curriculum)->name ?? 'Not Defined' }}
                              </p>
                              <span class="no-marmin">|</span>
                              <p>
                                 @php
                                    $typeName = $school_record->type->name ?? '';
                                 @endphp

                                 @if($typeName === 'Day')
                                    Day
                                 @elseif($typeName === 'Boarding')
                                    Boarding
                                 @elseif($typeName === 'Day & Boarding')
                                    Day & Boarding
                                 @else
                                    {{ $typeName }} {{-- Fallback if it's a full name like "Day School" --}}
                                 @endif
                              </p>
                              @if($school_record->religion)
                                 <span class="no-marmin">|</span>
                                 <p>Religion: {{ $school_record->religion->name }}</p>
                              @endif
                           </div>

                           <div class="school_de_dms">
                              @auth
                                 {{-- @if(Auth::user()->id != $schoolDetails->user_id && $schoolDetails->Claim_status == 'Y')
                                    <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#myMessageModal">Send Message</a>
                                 @elseif(Auth::user()->id != $schoolDetails->user_id && ($schoolDetails->Claim_status == 'N' || $schoolDetails->Claim_status == 'AW'))
                                    <a href="javascript:void(0)" class="schoolNotClaim">Send Message</a>
                                 @else
                                    <a href="javascript:void(0)" class="userNotSendMessage">Send Message</a>
                                 @endif --}}
                                 <a href="{{ route('user.message.list') }}" class="userNotSendMessage">Send Message</a>
                              @endauth
                              @guest
                                 <a href="{{ route('user.message.list') }}" class="noMessage">Send Message</a>
                              @endguest

                              <button  class=" post_tab">Post a Review</button>
                              @auth
                                 <a href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#myUploadPhotoModal">Upload Photo</a>
                              @endauth
                           </div>
                        </div>
                     </div>
                     <div class="claim_sc_body">                        
                        <div class="clam_sc">
                           @auth
                              @if(!$currentUserClaim)
                                    {{-- User has not claimed this school yet --}}
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal">
                                       <img src="{{ asset('images/clam.png') }}" alt=""> Claim the school
                                    </a>
                              @elseif($currentUserClaim->pivot->claim_status === 'pending')
                                    {{-- User has claimed, but status is still pending --}}
                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#myModal">
                                       <img src="{{ asset('images/clam.png') }}" alt=""> Claim the school
                                    </a>
                              @endif
                           @endauth

                           @guest
                              {{-- Guests can’t claim — show login prompt --}}
                              <a href="javascript:void(0)" class="notLogin">
                                    <img src="{{ asset('images/clam.png') }}" alt=""> Claim the school
                              </a>
                           @endguest
                        </div>
                        <div class="share_a">
                              <p> <img src="{{ asset('images/share2.png') }}" alt=""> Share</p>
                              <div class="sharethis-inline-share-buttons"></div>
                              <ul>
                                 <li> <a href="#"> <img src="{{ asset('images/share1.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ asset('images/share3.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ asset('images/share4.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ asset('images/share5.png') }}" alt=""> </a> </li>
                              </ul>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="school_nav sticky">
            <div class="container">
               <div class="row">
                  <div class="what_list_iner js-menu headermenu rm_stickyy">
                     <ul>
                        <li class="menu__element "><a href="javascript:;" class="menu__link what1">
                           <img src="{{ asset('images/me1.png') }}" alt=""> About School</a>
                        </li>
                        <li class="menu__element"><a href="javascript:;" class="menu__link why1">
                           <img src="{{ asset('images/me2.png') }}" alt=""> Facilities/Amenities</a>
                        </li>
                        <li class="menu__element"><a href="javascript:;" class="menu__link how1">
                           <img src="{{ asset('images/me3.png') }}" alt=""> Gallery</a>
                        </li>
                        <li class="menu__element "><a href="javascript:;" class="menu__link what2">
                           <img src="{{ asset('images/me4.png') }}" alt=""> Courses</a>
                        </li>
                        @auth
                           <li class="menu__element"><a href="javascript:;" class="menu__link why2">
                              <img src="{{ asset('images/me4.png') }}" alt=""> Fees</a>
                           </li>
                        @endauth
                        <li class="menu__element"><a href="javascript:;" class="menu__link how2">
                           <img src="{{ asset('images/me5.png') }}" alt=""> Branch/Affiliates</a>
                        </li>
                        <li class="menu__element "><a href="javascript:;" class="menu__link what3">
                           <img src="{{ asset('images/me6.png') }}" alt=""> location</a>
                        </li>
                        <li class="menu__element"><a href="javascript:;" class="menu__link why3">
                           <img src="{{ asset('images/me7.png') }}" alt=""> Reviews</a>
                        </li>
                        <li class="menu__element"><a href="javascript:;" class="menu__link how3">
                           <img src="{{ asset('images/me8.png') }}" alt=""> News</a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>

         <div class="all_about_school">
            <div class="container">
               <div class="row">
                  <div class="about_scholl_infos">
                     <div id="what_why_panel1" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>About School</h3>
                        </div>

                        <div class="about_sc_information">
                           <div class="acc_faqs ">
                              <div id="accordion">
                                 @if($school_record->description != null)
                                    <div class="card new_sc_faq">
                                       <div class="card-header">
                                       <a class=" btn" data-bs-toggle="" >
                                          School Description 
                                       </a>
                                       </div>
                                       <div id="collapseThree" class=" show " data-bs-parent="#accordion" style="display: block;">
                                       <div class="card-body">
                                          <p class="sch_des">{{ $school_record->description }}</p>
                                       </div>
                                       </div>
                                    </div>
                                 @endif
                                 {{-- @if(@$school_uniform->isNotEmpty())  
                                    <div class="card new_sc_faq">
                                       <div class="card-header">
                                       <a class=" btn" data-bs-toggle="">
                                          School Uniform 
                                       </a>
                                       </div>
                                       <div id="collapseFour" class=" show" data-bs-parent="#accordion"  style="display: block;">
                                          <div class="card-body unif-card d-flex flex-row flex-wrap justify-content-start align-items-stretch">
                                             @foreach($school_uniform as $data)
                                                <div class="school_in_box schoolUniform" data-image_url="{{ URL::to('storage/app/public/images/uniform_image') }}/{{ @$data->uniform_image }}">
                                                   <span>
                                                      @if(@$data->uniform_image != null)
                                                         <img src="{{ URL::to('storage/app/public/images/uniform_image') }}/{{ @$data->uniform_image }}" alt="">
                                                      @endif
                                                   </span>
                                                   <div class="unifrom_des">
                                                      @if(@$data->uniform_title != null)
                                                         <h3>{{ @$data->uniform_title }}</h3>
                                                      @endif
                                                      <p>For 
                                                         @if(@$data->uniform_type == 'M')
                                                         Male
                                                         @elseif(@$data->uniform_type == 'F')
                                                         Female
                                                         @elseif(@$data->uniform_type == 'U')
                                                         Unisex
                                                         @endif
                                                      </p>
                                                   </div>
                                                </div>
                                             @endforeach
                                          </div>
                                       </div>
                                    </div>
                                 @endif --}}

                                 <div class="card new_sc_faq">
                                    <div class="card-header">
                                    <a class="collapsed btn">
                                       Teacher & Student info
                                    </a>
                                    </div>
                                    <div id="collapseOne" class=" s " data-bs-parent="#accordion">
                                    <div class="card-body">
                                       <div class="new_al mb-3">
                                          <h3> Number of Teachers: <span> {{ optional($school_record->population)->total_teachers }} </span> </h3>
                                          <div class="mls-3">
                                             <h4>Male Teachers : <span> {{ optional($school_record->population)->male_teachers }} </span> </h4>
                                             <h4>Female Teacher : <span> {{ optional($school_record->population)->female_teachers }} </span> </h4>
                                          </div>
                                       </div>

                                       {{-- <div class="new_al mt-4 mb-4">
                                          <h3> Teacher Student Ratio: <span> {{ @$schoolDetails->teacher_student_ratio?@$schoolDetails->teacher_student_ratio:'' }} </span> </h3>
                                       </div> --}}

                                       <div class="new_al mt-3">
                                          <h3> Number of student: <span> {{ optional($school_record->population)->total_students }}  </span> </h3>
                                          <div class="mls-3">
                                             <h4> Student Male : <span> {{ optional($school_record->population)->male_students }} </span> </h4>
                                             <h4> Student Female : <span> {{ optional($school_record->population)->female_students }} </span> </h4>
                                          </div>
                                       </div>

                                    </div>
                                    </div>
                                 </div>

                                 <div class="card new_sc_faq">
                                    <div class="card-header">
                                       <a class="collapsed btn">
                                          School Services
                                       </a>
                                    </div>
                                    <div id="collapseOne" class=" s " data-bs-parent="#accordion">
                                       <div class="card-body">
                                          <div class="rule-list d-flex flex-row flex-wrap justify-content-start align-items-stretch">
                                             @php
                                                $services = $school_record->extendedSchoolServices->pluck('name')->map(fn($name) => strtolower($name));
                                             @endphp
                                             <div class="rule-box">
                                                <h4>Meals offered</h4>
                                                <p>Yes</p>
                                                {{-- @if($services->contains('Meals Offered'))
                                                   <p>Yes</p>
                                                @else
                                                   <p class="no">No</p>
                                                @endif --}}
                                             </div>
                                             <div class="rule-box">
                                                <h4>Special needs catered</h4>
                                                <p>Yes</p>
                                                {{-- @if($services->contains('Special Needs Catered'))
                                                   <p>Yes</p>
                                                @else
                                                   <p class="no">No</p>
                                                @endif --}}
                                             </div>
                                             <div class="rule-box">
                                                <h4>School transport available</h4>
                                                <p>Yes</p>
                                                {{-- @if($services->contains('School Transport Available'))
                                                   <p>Yes</p>
                                                @else
                                                   <p class="no">No</p>
                                                @endif --}}
                                             </div>
                                          </div>
                                          <div class="rule-time d-flex flex-row flex-wrap justify-content-start align-items-stretch">
                                             <h3 class="w-100">School Timing :</h3>
                                             @foreach($school_record->operationHours as $operation)
                                                <div class="rule-time-card">
                                                      <h4>{{ ucfirst($operation->period_of_day) }}</h4>
                                                      <p>
                                                         From <b>{{ date('H:i', strtotime($operation->starts_at)) }}</b>
                                                         to <b>{{ date('H:i', strtotime($operation->ends_at)) }}</b>
                                                      </p>
                                                </div>
                                             @endforeach
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                          </div>

                        </div>
                     </div>
                      
                     <div id="what_why_panel2" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>Facilities / Amenities</h3>
                        </div>
                        @if($school_record->facilities->isNotEmpty())
                           <div class="faci_ul">
                                 <ul>
                                    @foreach($school_record->facilities as $facility)
                                       <li>{{ $facility->name }}</li> {{-- ✅ Uses correct column --}}
                                    @endforeach
                                 </ul>
                           </div>
                        @else
                           <p>No facilities listed for this school.</p>
                        @endif
                     </div>
                     
                     <div id="how_sec" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>Gallery</h3>
                        </div>
                        @if($school_gallery->isNotEmpty())
                           <div class="galley_des">
                              <div class="owl-carousel owl-theme owl-gallery position-relative">
                                 @foreach($school_gallery as $data)
                                    @php
                                       // Compute storage path
                                       $imagePath = $data->image_path 
                                             ? 'public/' . ltrim($data->image_path, '/') 
                                             : 'public/default_images/default.jpg';

                                       // Fallback if file missing
                                       $finalPath = Storage::exists($imagePath) 
                                             ? $imagePath 
                                             : 'public/default_images/default.jpg';

                                       // Public URL for use in <img> and JS data attribute
                                       $imageUrl = Storage::url($finalPath);
                                    @endphp

                                    <div class="item showImage" data-image_url="{{ $imageUrl }}">
                                       <div class="school_gallery_img">
                                             <img src="{{ $imageUrl }}" alt="{{ $data->image_path ?? 'default.jpg' }}">
                                       </div>
                                    </div>
                                 @endforeach
                              </div>
                           </div>
                        @endif
                     </div>

                      
                     <div id="what_why_panel12" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>Courses Offered</h3>
                        </div>
                        @if($school_record->courses->isNotEmpty())
                           <div class="couse_detas">
                                 @foreach($school_record->courses as $course)
                                    <div class="course_in">
                                       <h3>{{ $course->name }}</h3>
                                       @if($course->description)
                                             <p>{{ $course->description }}</p>
                                       @endif
                                    </div>
                                 @endforeach
                           </div>
                        @else
                           <p>No courses listed for this school.</p>
                        @endif
                     </div>
                     @auth
                        <div id="what_why_panel22" class="about_sc_bo">
                           <div class="abot_all_headings">
                              <h3>Fees</h3>
                           </div>

                           <div class="row">
                              @if($school_record->fees->isNotEmpty())
                                 <div class="col-md-6">
                                       <div class="fees_table">
                                          <div class="fees_head">
                                             <h3>Groups/Grades</h3>
                                             <h3>Amount</h3>
                                          </div>
                                          <div class="fess_bosy">
                                             @foreach($school_record->fees as $fee)
                                                   <div class="fees_ins">
                                                      <p>{{ $fee->level->name ?? 'N/A' }}</p>
                                                      <p>{{ strtoupper($fee->currency) }} {{ number_format($fee->min_amount, 2) }} - {{ number_format($fee->max_amount, 2) }}</p>
                                                   </div>
                                             @endforeach
                                          </div>
                                       </div>
                                 </div>
                              @else
                                 <p>No fee information available for this school.</p>
                              @endif
                           </div>
                        </div>
                     @endauth

                     <div id="how_sec2" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>Branch/Affiliate</h3>
                        </div>

                        <div class="row">
                           @if($school_branches && $school_branches->count())
                              @foreach($school_branches as $keyy => $data)
                                    <div class="col-md-6">
                                       @foreach($data as $key => $branch)
                                          <div class="branshes_box">
                                                <h3>Branch {{ $loop->iteration + ($keyy * 2) }}</h3>
                                                <h5>{{ $branch->full_address }}</h5>
                                                <p><span>School Name:</span> {{ $branch->school_name }}</p>
                                                <p><span>Call:</span> {{ $branch->contact_phone }}</p>
                                                <p><span>Email:</span> {{ $branch->contact_email }}</p>
                                          </div>
                                       @endforeach
                                    </div>
                              @endforeach
                           @endif
                        </div>
                     @if(optional($school_record->address)->latitude && optional($school_record->address)->longitude)
                        <div id="what_why_panel13" class="about_sc_bo">
                           <div class="abot_all_headings">
                                 <h3>Location</h3>
                           </div>

                           {{-- Hidden fields for JS usage --}}
                           <input type="hidden" id="google_latitude" value="{{ optional($school_record->address)->latitude }}">
                           <input type="hidden" id="google_longitude" value="{{ optional($school_record->address)->longitude }}">
                           <input type="hidden" id="google_maps_link" value="{{ optional($school_record->address)->google_maps_link }}">

                           <div class="school_maps" id="map">
                                 @if(optional($school_record->address)->google_maps_link)
                                    <iframe 
                                       src="{{ optional($school_record->address)->google_maps_link }}"
                                       style="border:0;" 
                                       allowfullscreen="" 
                                       loading="lazy" 
                                       referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                 @else
                                    {{-- Generate a dynamic Google Maps embed using lat/lng --}}
                                    <iframe 
                                       width="600" 
                                       height="450" 
                                       style="border:0" 
                                       loading="lazy" 
                                       allowfullscreen 
                                       referrerpolicy="no-referrer-when-downgrade"
                                       src="https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center={{ optional($school_record->address)->latitude }},{{ optional($school_record->address)->longitude }}&zoom=15">
                                    </iframe>
                                 @endif
                           </div>
                        </div>
                     @endif
                     <div id="what_why_panel23" class="about_sc_bo">
                        <div class="abot_all_headings">
                           <h3>Reviews</h3>
                           <ul class="stars_sc">
                               @if(@$schoolDetails->avg_review)
                                 @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                                 @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                                 <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                                 @endfor
                                 @if(strpos($schoolDetails->avg_review,'.'))
                                 <li><img src="{{asset('images/star-half.png')}}"></li>
                                 @php $sst++; @endphp
                                 @endif
                                 @while ($sst<=5)
                                 <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                                 @php $sst++; @endphp
                                 @endwhile
                                 @else
                                 @for($sst = 1; $sst <= 5; $sst++)
                                 <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                                 @endfor
                                 @endif
                              <li> <p>({{ @$schoolDetails->tot_review }} reviews)</p> </li>
                           </ul>
                        </div>
                        @if($reviews->isNotEmpty())
                           <div class="reviews_des new-rev-row">
                              <div class="row align-items-stretch">
                              @foreach($reviews as $data)     
                                 <div class="col-lg-4 col-md-6 col-12 col" style="display:none;">
                                       <div class="school_review_box">
                                          <div class="school_rev_name">
                                             <div class="school_use_re">
                                                <span>
                                                   @if(@$data->getUser->profile_pic != null)
                                                      <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @$data->getUser->profile_pic }}" alt="">
                                                   @else
                                                      <img src="{{ asset('images/avatar.png') }}" alt="">
                                                   @endif 
                                                </span>
                                                <div class="sch_us_de">
                                                   <h5>{{ $data->user->first_name.' '.$data->user->last_name }}</h5>
                                                   <p>
                                                      @if(@$data->designation == 'CS')
                                                      Current Student
                                                      @elseif(@$data->designation == 'E')
                                                      Employer
                                                      @elseif(@$data->designation == 'G')
                                                      General
                                                      @endif
                                                   </p>
                                                </div>
                                             </div>
                                             <ul class="stars_sc">
                                             @for($i=1;$i<=$data->rating;$i++)
                                                <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                                             @endfor
                                             @for($j=$data->rating+1;$j<=5;$j++)
                                                <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                                             @endfor
                                             </ul>
                                          </div>
                                          <div class="revie_sc_para">
                                             <p>{{ $data->review_text }} </p>
                                          </div>
                                          <div class="revie_sc_date">
                                             <p>{{ date('jS M, Y',strtotime($data->created_at)) }}</p>
                                          </div>
                                       </div>
                                    </div>
                                 @endforeach
                                 <div class="col-12" @if($reviews->count() > 6) style="display:block;" @else style="display:none;" @endif>
                                    <button class="loadtst view_more_btn">Load more
                                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path opacity="0.2" d="M12 6C13.1046 6 14 5.10457 14 4C14 2.89543 13.1046 2 12 2C10.8954 2 10 2.89543 10 4C10 5.10457 10.8954 6 12 6Z" fill="#5BD75B"/>
                                       <path opacity="0.6" d="M12 22C13.1046 22 14 21.1046 14 20C14 18.8954 13.1046 18 12 18C10.8954 18 10 18.8954 10 20C10 21.1046 10.8954 22 12 22Z" fill="#5BD75B"/>
                                       <path d="M17.1961 9.00012C17.7483 9.9567 18.9715 10.2845 19.9281 9.73217C20.8847 9.17988 21.2124 7.9567 20.6602 7.00012C20.1079 6.04353 18.8847 5.71578 17.9281 6.26807C16.9715 6.82035 16.6438 8.04353 17.1961 9.00012Z" fill="#5BD75B"/>
                                       <path opacity="0.4" d="M3.33985 17.0001C3.89214 17.9567 5.11532 18.2844 6.07191 17.7321C7.02849 17.1799 7.35624 15.9567 6.80396 15.0001C6.25167 14.0435 5.02849 13.7158 4.07191 14.268C3.11532 14.8203 2.78757 16.0435 3.33985 17.0001Z" fill="#5BD75B"/>
                                       <path opacity="0.8" d="M17.1961 15.0001C16.6438 15.9567 16.9715 17.1799 17.9281 17.7321C18.8847 18.2844 20.1079 17.9567 20.6602 17.0001C21.2124 16.0435 20.8847 14.8203 19.9281 14.268C18.9715 13.7158 17.7483 14.0435 17.1961 15.0001Z" fill="#5BD75B"/>
                                       <path opacity="0.3" d="M3.33985 7.00012C2.78757 7.9567 3.11532 9.17988 4.0719 9.73217C5.02849 10.2845 6.25167 9.9567 6.80396 9.00012C7.35624 8.04353 7.02849 6.82035 6.0719 6.26807C5.11532 5.71578 3.89214 6.04353 3.33985 7.00012Z" fill="#5BD75B"/>
                                       </svg>
                                    </button>
                                 </div>
                              </div>
                           </div>
                        @endif
                        <div class="post_school_reviews" id="post-schs">
                           <div class="post_re_heading">
                              <h2>Post Your Reviews</h2>
                           </div>
                           <form action="{{ route('post.review') }}" method="post" id="reviewForm">
                              @csrf
                              <input type="hidden" name="school_id" value="{{ $school_record->id }}">
                              {{-- <input type="hidden" name="school_owner_id" value="{{ @$schoolDetails->user_id }}"> --}}
                              <div class="rating_sec_po">  
                                 <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                       <div class="post_ins">
                                          <label class="label_po">Rating</label>
                                          <div class="star-rating">
                                          <input class="radio-input" type="radio" id="star5" name="rating" value="5" />
                                          <label class="radio-label" class for="star5" title="5 stars">5 stars</label>

                                          <input class="radio-input" type="radio" id="star4" name="rating" value="4" />
                                          <label class="radio-label" for="star4" title="4 stars">4 stars</label>

                                          <input class="radio-input" type="radio" id="star3" name="rating" value="3" />
                                          <label class="radio-label" for="star3" title="3 stars">3 stars</label>

                                          <input class="radio-input" type="radio" id="star2" name="rating" value="2" />
                                          <label class="radio-label" for="star2" title="2 stars">2 stars</label>

                                          <input class="radio-input" type="radio" id="star1" name="rating" value="1" />
                                          <label class="radio-label" for="star1" title="1 star">1 star</label>
                                          </div>
                                          <label id="rating-error" class="error" for="rating" style="display:none;"></label>
                                       </div>
                                    </div>

                                    {{-- TEMPORARILY REMOVING THIS --}}
                                    {{-- <div class="col-md-4 col-sm-6">
                                       <div class="post_ins">
                                          <label class="label_po">designation</label>
                                          <select class="post_se" name="designation">
                                             <option value="">Select</option>
                                             <option value="Current Student">Current Student</option>
                                             <option value="Employee">Employee</option>
                                             <option value="General">General</option>
                                          </select>
                                       </div>
                                    </div> --}}

                                    <div class="col-md-12">
                                       <div class="post_ins">
                                          <textarea placeholder="Enter your review" name="review_text"></textarea>
                                          
                                       </div>
                                    </div>

                                    <div class="sub_btns_post">
                                       @auth
                                       <button type="submit">Post Reviews</button>
                                       @endauth
                                       @guest
                                       <button class="noReview">Post Reviews</button>
                                       @endguest
                                    </div>

                                 </div>
                              </div>
                           </form>
                        </div>

                     </div>
                     {{-- @if(@$allNews->isNotEmpty())
                     <div id="how_sec23" >
                        <div class="section_header">
                           <h2> News</h2>
                           <p>Lorem ipsum dolor sit amet, lorem ipsum dolor sit amet, consecteturconsectetur</p>
                        </div>

                        <div class="featured-news-inr">
                           <div class="owl-carousel owl_produs owl-theme owl_produs owl-news position-relative">
                              @foreach($allNews as $data)
                              <div class="item">
                                 <div class="news_box">
                                    <div class="news_imgs">
                                       <div class="spans"><p> {{ date('d',strtotime(@$data->created_at)) }} <span>{{ date('M',strtotime(@$data->created_at)) }}</span></p> </div> 
                                       <a href="{{ route('news.details',@$data->slug) }}"> 
                                       @if(@$data->image != null)
                                       <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ @$data->image }}" alt=""> 
                                         @endif
                                           </a>
                                    </div>
                                    <div class="news_text">
                                       <div class="news_info">
                                          <div class="adm_namee">
                                             <img src="{{ asset('images/user.png') }}" alt="">
                                             <p>Posted by, <span> {{ @$data->getUser->first_name.' '.@$data->getUser->last_name }}</span></p>
                                          </div>
                                          <h2> <a href="{{ route('news.details',@$data->slug) }}">
                                          @if(strlen(@$data->news_title)>100)
                                         {{ substr(@$data->news_title,0,100) }}
                                         @else
                                         {{ @$data->news_title }}
                                          @endif
                                          </a> </h2>

                                          <div class="read_more_b">
                                             <a href="{{ route('news.details',@$data->slug) }}">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endforeach

                              <div class="item">
                                 <div class="news_box">
                                    <div class="news_imgs">
                                       <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                                       <a href="#"> <img src="{{ asset('images/news2.png') }}" alt=""> </a>
                                    </div>
                                    <div class="news_text">
                                       <div class="news_info">
                                          <div class="adm_namee">
                                             <img src="{{ asset('images/user.png') }}" alt="">
                                             <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                          </div>
                                          <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                          <div class="read_more_b">
                                             <a href="#">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="item">
                                 <div class="news_box">
                                    <div class="news_imgs">
                                       <div class="spans"><p> 17 <span> JAN</span></p> </div> 
                                       <a href="#"> <img src="{{ asset('images/news3.png') }}" alt=""> </a>
                                    </div>
                                    <div class="news_text">
                                       <div class="news_info">
                                          <div class="adm_namee">
                                             <img src="{{ asset('images/user.png') }}" alt="">
                                             <p>Posted by, <span> Lyndah Kemunto</span></p>
                                          </div>
                                          <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                          <div class="read_more_b">
                                             <a href="#">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="item">
                                 <div class="news_box">
                                    <div class="news_imgs">
                                       <div class="spans"><p> 20 <span> SEP</span></p> </div> 
                                       <a href="#"> <img src="{{ asset('images/news4.png') }}" alt=""> </a>
                                    </div>
                                    <div class="news_text">
                                       <div class="news_info">
                                          <div class="adm_namee">
                                             <img src="{{ asset('images/user.png') }}" alt="">
                                             <p>Posted by, <span> Elizabeth Gitau</span></p>
                                          </div>
                                          <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                          <div class="read_more_b">
                                             <a href="#">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="item">
                                 <div class="news_box">
                                    <div class="news_imgs">
                                       <div class="spans"><p> 20 <span> SEP</span></p> </div> 
                                       <a href="#"> <img src="{{ asset('images/news5.png') }}" alt=""> </a>
                                    </div>
                                    <div class="news_text">
                                       <div class="news_info">
                                          <div class="adm_namee">
                                             <img src="{{ asset('images/user.png') }}" alt="">
                                             <p>Posted by, <span> Elizabeth Gitau</span></p>
                                          </div>
                                          <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                          <div class="read_more_b">
                                             <a href="#">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif --}}
                    
                    
                     {{-- @if(@$advertise->isNotEmpty())
                        <section class="adv2">
                           <div class="container">
                              <div class="row">
                                 @foreach($advertise as $data)
                                 <div class="col-sm-6">
                                    <div class="adv_n">
                                       <a href="{{ @$data->advertise_url }}" target="_blank"> <img src="{{ URL::to('storage/app/public/images/advertise_image') }}/{{ @$data->image }}" alt=""> </a>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </section>
                     @endif --}}
                  </div>
               </div>
            </div>
         </div>

      </section>

      @if(@$nearby_school != null)
       <section class="featured-school new_as_dea">
         <div class="shpa_gr">
            <img src="{{ asset('images/banner-fest.png') }}" alt="">
         </div>
         <div class="container">
            <div class="row">
               <div class="section_header">
                  <h2>
                     Find other 
                     @if(@$schoolDetails->school_types)
                        @foreach($schoolDetails->school_types as $key11=>$type)
                        {{ @$key11 > 0?',':''  }} {{ @$type->school_type }}
                        @endforeach
                     @endif Schools in {{ @$schoolDetails->getTown->city }}
                  </h2>
               </div>

               <div class="featured-school-inr">
                  <div class="owl-carousel owl_produs owl-theme owl-featured-school position-relative">
                     @if(@$nearby_school->isNotEmpty())
                     @foreach($nearby_school as $data)
                     <div class="item">
                        <div class="fea_school_div">
                           <div class="fea_school_img">
                              <span class="res-tab">
                              @if(@$data->public_private == 'PB')
                              Public
                              @elseif(@$data->public_private == 'PR')
                              Private
                              @endif
                              </span>
                              @if(@$data->getSchoolMainImage->image != null)
                           <a href="{{ route('school.details',@$data->slug) }}"><img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$data->getSchoolMainImage->image }}" alt=""></a>
                           @endif
                           </div>
                           <div class="fea_school_info">
                              <h2> <a href="{{ route('school.details',@$data->slug) }}">
                              @if(strlen(@$data->school_name)>50)
                              {{ substr(@$data->school_name,0,50) }}
                              @else
                              {{ @$data->school_name }}
                              @endif
                              </a> </h2>
                              <div class="star_loc">
                                 <ul>
                                     @if(@$data->avg_review)
                                          @php $data->avg_review = $data->avg_review+0; @endphp
                                          @for($sst = 1; $sst <= $data->avg_review; $sst++)
                                          <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                                          @endfor
                                          @if(strpos($data->avg_review,'.'))
                                          <li><img src="{{asset('images/star-half.png')}}"></li>
                                          @php $sst++; @endphp
                                           @endif
                                           @while ($sst<=5)
                                           <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                                          @php $sst++; @endphp
                                          @endwhile
                                          @else
                                          @for($sst = 1; $sst <= 5; $sst++)
                                          <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                                          @endfor
                                          @endif
                                    {{--<li><img src="{{ url('public/images/star.png') }}" alt=""></li>
                                    <li><img src="{{ url('public/images/star.png') }}" alt=""></li>
                                    <li><img src="{{ url('public/images/star.png') }}" alt=""></li>
                                    <li><img src="{{ url('public/images/star.png') }}" alt=""></li>
                                    <li><img src="{{ url('public/images/star.png') }}" alt=""></li>--}}
                                 </ul>
                                 <p><img src="{{ asset('images/map-pin.png') }}" alt="">{{ @$data->getCountry->name }}</p>
                              </div>
                              <div class="sch_info">
                                 <div>
                                    <span>Type: </span>
                                    <p>
                                    @if(@$data->school_types)
                                    @foreach(@$data->school_types as $key=>$schtype)
                                    {{ @$key > 0?',':'' }} {{ @$schtype->school_type }}
                                    @endforeach
                                    @endif
                                    </p>
                                 </div>
                                 <div>
                                    <span>Board:  </span>
                                    <p>
                                    @if(@$data->school_boards)
                                    @foreach(@$data->school_boards as $key=>$schoolboard)
                                    {{ @$key > 0?',':'' }} {{ @$schoolboard->board_name }}
                                    @endforeach
                                    @endif
                                    </p>
                                 </div>
                                 <div>
                                    <span>Gender: </span>
                                    <p>
                                    @if(@$data->gender == 'M')
                                    Male
                                    @elseif(@$data->gender == 'F')
                                    Female
                                    @elseif(@$data->gender == 'B')
                                    Both
                                    @endif
                                    </p>
                                 </div>
                              </div>
                              <div class="sch_board_fees">
                                 <p> 
                                   @if(@$data->boarding_type == 'D')
                                    Day
                                    @elseif(@$data->boarding_type == 'B')
                                    Boading
                                    @elseif(@$data->boarding_type == 'DB')
                                    Day & Boading
                                    @endif
                                   </p>
                                 <a href="{{ route('school.details',@$data->slug) }}">View School</a>
                              </div>
                           </div>
                        </div>
                     </div>
                      @endforeach
                      @endif
                    
                  </div>
               </div>
            </div>
         </div>
         
      </section>
      @endif
      <div class="modal modal_lciam" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Claim this school</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
               <div class="some_sc_de">
                 <h3>{{  $school_record->name }}</h3>
                 <div class="some_sc_add">
                     <p><img src="{{ asset('images/me6.png') }}" alt="">{{ optional($school_record->address)->address_text ?? 'Address not available' }}</p>
                     <ul class="stars_sc">
                        {{-- @if(@$schoolDetails->avg_review)
                           @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                           @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                              <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                           @endfor
                           @if(strpos($schoolDetails->avg_review,'.'))
                              <li><img src="{{asset('public/images/star-half.png')}}"></li>
                              @php $sst++; @endphp
                           @endif
                           @while ($sst<=5)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                              @php $sst++; @endphp
                           @endwhile
                        @else
                           @for($sst = 1; $sst <= 5; $sst++)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                           @endfor
                        @endif --}}
                        @for($sst = 1; $sst <= 5; $sst++)
                           <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                        @endfor
                     {{-- <li> <p>({{ @$schoolDetails->tot_review }} reviews)</p> </li> --}}
                  </ul>
               </div>
                 
              </div>
               <div class="cliam_from">
                  <h3>Claim:</h3>
                  <form action="{{ route('school.claim.save') }}" method="post" id="claimForm" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="school_id" value="{{ $school_record->id }}">
                     {{-- <input type="hidden" name="school_owner_id" value="{{ $school_record->user_id }}"> --}}
                     <div class="row">
                        <div class="col-sm-6">
                           <div class="search_in">
                              <label>Name</label>
                              <input type="text" name="user_name" placeholder="Enter here">
                           </div>
                           <label id="name-error" class="error" for="user_name" style="display:none;">This field is required.</label>
                        </div>
                        <div class="col-sm-6">
                           <div class="search_in">
                              <label>Association with the School</label>
                              <select name="contact_position_id" required>
                                    <option value="">Select</option>
                                    {{-- <option value="Admin">Admin</option>
                                    <option value="Owner">Owner</option> --}}
                                    @foreach($contactPositions->whereIn('name', ['Admin', 'Owner']) as $position)
                                       <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                              </select>
                           </div>
                           <label id="school_association-error" class="error" for="school_association" style="display:none;">
                              This field is required.
                           </label>
                        </div>
                        <div class="col-sm-12">
                           <div class="search_in">
                              <label>Official Email Address</label>
                              <input type="text" name="email_address" placeholder="Enter here">
                           </div>
                           <label id="email_address-error" class="error" for="email_address"  style="display:none;">This field is required.</label>
                        </div>

                        <div class="col-lg-12">
                              <div class="uplodimg edit-prof-big new_tooltips">
                                 <div class=" img-upld">
                                    <div class="uplodimgfil W-100">
                                       <input type="file" name="claim_file[]" id="claim_file" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="">
                                       <label for="claim_file">
                                          <img src="{{ asset('images/upload.png') }}" alt="">
                                          <h3 class="m-0">Upload proof of association</h3>
                                          <p>png, jpg, pdf</p>
                                       </label>
                                    </div>
                                 </div>

                                 <a class="css-tooltip-bottom a_tool color-red" href="javascript:;">
                                 <span>Documents to submit include, School registration certificate(s), your Id & relevant docs for verification</span> 
                                 <img src="{{ asset('images/question.png') }}" alt="">
                                 </a>
                              </div>
                              <label id="claimfile_error" for="" class="error" style="display:none;"></label>
                              <div class="uploaded-file"></div>
                           </div>


                     </div>
                     <!-- Modal footer -->
                     <div class="modal-footer">
                     <button class="clain_btns submitBtn">Submit <img src="{{ asset('images/arrow-righr.png') }}" alt="">  </button>
                     </div>
                  </form>
               </div>
            </div>

            {{-- <!-- Modal footer -->
            <div class="modal-footer">
              <button class="clain_btns submitBtn">Submit <img src="{{ asset('images/arrow-righr.png') }}" alt="">  </button>
            </div> --}}

          </div>
        </div>
      </div>

      <div class="modal modal_lciam" id="myModalHeader">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Background Header Image/Video</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
               {{-- <div class="some_sc_de">
                 <h3>{{  $school_record->school_name }}</h3>
                 <div class="some_sc_add">
                    <p><img src="{{ asset('images/me6.png') }}" alt="">{{ optional($school_record->address)->address_text ?? 'Address not available' }}</p>
                    <ul class="stars_sc">
                        @if(@$schoolDetails->avg_review)
                           @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                           @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                              <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                           @endfor
                           @if(strpos($schoolDetails->avg_review,'.'))
                              <li><img src="{{asset('images/star-half.png')}}"></li>
                              @php $sst++; @endphp
                           @endif
                           @while ($sst<=5)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                              @php $sst++; @endphp
                           @endwhile
                           @else
                           @for($sst = 1; $sst <= 5; $sst++)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                           @endfor
                        @endif
                        <li> <p>({{ @$schoolDetails->tot_review }} reviews)</p> </li>
                     </ul>
                  </div>
               </div> --}}
               <div class="cliam_from">
                  <form action="{{ route('user.add.header.image.video') }}" method="post" id="headerImageForm" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="school_master_id" value="{{ $school_record->id }}">
                     <div class="row">
                        <div class="col-lg-12">
                              <div class="uplodimg edit-prof-big">
                                 <div class=" img-upld">
                                    <div class="uplodimgfil W-100">
                                       <input type="file" name="header_image" id="header_image" class="inputfile inputfile-1" data-multiple-caption="{count} files selected">
                                       <label for="header_image">
                                          <img src="{{ asset('images/upload.png') }}" alt="">
                                          <h3 class="m-0">Upload Header Image</h3>
                                          <p>png, Jpg, gif</p>
                                       </label>
                                    </div>
                                 </div>

                              </div>
                              <label id="header_image_error" for="header_image" class="error" style="display:none;"></label>
                           </div>
                           <div class="col-lg-12">
                           <div class="uploaded-img rectangle-image" style="display:none;">
                            
                           </div>
                           </div>

                           <div class="col-sm-12">
                           <div class="search_in">
                              <label>Youtube Link</label>
                              <input type="text" name="youtube_link" id="youtube_link" placeholder="Enter here">
                           </div>
                           <label id="youtube_link-error" class="error" for="youtube_link"  style="display:none;">This field is required.</label>
                        </div>

                          </div>
                          
                  </form>
               </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button class="clain_btns submitBtn1">Submit <img src="{{ asset('images/arrow-righr.png') }}" alt="">  </button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal modal_lciam" id="myUploadPhotoModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Upload Photo</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
            <div class="some_sc_de">
                 <h3>{{  $school_record->school_name }}</h3>
                  {{-- <div class="some_sc_add">
                     <p><img src="{{ asset('images/me6.png') }}" alt="">{{ optional($school_record->address)->address_text ?? 'Address not available' }}</p>
                     <ul class="stars_sc">
                        @if(@$schoolDetails->avg_review)
                           @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                           @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                              <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                           @endfor
                           @if(strpos($schoolDetails->avg_review,'.'))
                              <li><img src="{{asset('public/images/star-half.png')}}"></li>
                              @php $sst++; @endphp
                           @endif
                           @while ($sst<=5)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                              @php $sst++; @endphp
                           @endwhile
                           @else
                           @for($sst = 1; $sst <= 5; $sst++)
                              <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                           @endfor
                        @endif
                        <li> <p>({{ @$schoolDetails->tot_review }} reviews)</p> </li>
                     </ul>
                 </div> --}}
              </div>
              <div class="cliam_from">
                  
                  <form action="{{ route('school.photo.save') }}" method="post" id="uploadPhotoForm" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="school_master_id" value="{{ $school_record->id }}">
                     <div class="row">
                     
                        <div class="col-lg-12">
                              <div class="uplodimg edit-prof-big">
                                 <div class=" img-upld">
                                    <div class="uplodimgfil W-100">
                                       <input type="file" name="school_image[]" id="school_image" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="">
                                       <label for="school_image">
                                          <img src="{{ asset('images/upload.png') }}" alt="">
                                          <h3 class="m-0">Upload Images</h3>
                                          <p>png, Jpg</p>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                            
                           </div>

                           <div class="col-lg-12">
                           <div class="upldd-scl-imgs">
                            
                           </div>
                           </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button class="clain_btns submitPhoto mt-3">Submit <img src="{{ asset('images/arrow-righr.png') }}" alt="">  </button>
            </div>

          </div>
        </div>
      </div>


      <div class="modal modal_lciam" id="myMessageModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Send Message</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
               <div class="some_sc_de">
                 <h3>{{  $school_record->school_name }}</h3>
                  {{-- <div class="some_sc_add">
                     <p><img src="{{ asset('images/me6.png') }}" alt="">{{ optional($school_record->address)->address_text ?? 'Address not available' }}</p>
                     <ul class="stars_sc">
                           @if(@$schoolDetails->avg_review)
                           @php $schoolDetails->avg_review = $schoolDetails->avg_review+0; @endphp
                           @for($sst = 1; $sst <= $schoolDetails->avg_review; $sst++)
                           <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                           @endfor
                           @if(strpos($schoolDetails->avg_review,'.'))
                           <li><img src="{{asset('public/images/star-half.png')}}"></li>
                           @php $sst++; @endphp
                           @endif
                           @while ($sst<=5)
                           <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>
                           @php $sst++; @endphp
                           @endwhile
                           @else
                           @for($sst = 1; $sst <= 5; $sst++)
                           <li><img src="{{ asset('images/lstar.png') }}" alt=""></li>                              
                           @endfor
                           @endif
                        <li> <p>({{ @$schoolDetails->tot_review }} reviews)</p> </li>
                     </ul>
                 </div> --}}
               </div>
              <div class="cliam_from">
                  
                  <form action="{{ route('user.send.message') }}" method="post" id="messageForm" enctype="multipart/form-data">
                     @csrf
                     {{-- <input type="hidden" name="to_user_id" id="" value="{{ @$schoolDetails->user_id }}"> --}}
                     <input type="hidden" name="school_id" value="{{ $school_record->id }}">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="post_ins">
                              <label>Message</label>
                              <textarea placeholder="Enter your review" name="message"></textarea>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <button class="clain_btns submitMessage mt-3">Send<img src="{{ asset('images/arrow-righr.png') }}" alt="">  </button>
            </div>

          </div>
        </div>
      </div>




      <div class="modal modal_lciam" id="schoolImageModal">
        <div class="modal-dialog modal-dialog-centered image-modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">School Image</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body image-modal">
              <img src="" alt="" id="schoolImageshow">
            </div>

         

          </div>
        </div>
      </div>

      <div class="modal modal_lciam" id="schoolUniformModal">
        <div class="modal-dialog modal-dialog-centered image-modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">School Uniform</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body image-modal">
              <img src="" alt="" id="schoolUniformshow">
            </div>
          </div>
        </div>
      </div>


      
      <div class="modal modal_lciam modal-schlvid" id="youtubeVieoModal">
        <div class="modal-dialog modal-dialog-centered image-modal-dialog">
          <div class="modal-content">
            <!-- Modal body -->
            {{-- <div class="modal-body image-modal position-relative" id="yt-player">
               <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal"></button>
               @if(@$schoolDetails->youtube_link == null)
                  @if(@$schoolDetails->header_image != null)
                     <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$schoolDetails->header_image }}" alt="" class="img-clear">
                  @else
                     <img src="{{ asset('images/default_image.png') }}" alt="" class="img-clear">
                  @endif
               @endif
               @if(@$schoolDetails->youtube_link != null)
                  <iframe src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
               @endif
            </div> --}}
          </div>
        </div>
      </div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=660bc6f958eed300122e7dab&product=inline-share-buttons&source=platform" async="async"></script>
<script>
   $(document).ready(function(){

      $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters and numbers");

       $('#claimForm').validate({

            rules: {

               name: {

                   required: true,
                   name_Regex: true,
               },
               school_association: {

                   required: true,
               },
               email_address: {

                  required: true,
                  validate_email: true,
               },
               claim_file: {

                   required: true,
               },
            },
            submitHandler: function(form){

               let filename = $('#claim_file').val();
                console.log(filename);
                if(filename == ''){

                    $('#claimfile_error').html('Please upload a file');
                    $('#claimfile_error').css('display','block');
                    return false;
                }else{

                  form.submit();
                }
            },
       })

        $('.submitBtn').click(function(){

            $('#claimForm').submit();
        })
   })
</script>

<script>
   $(document).ready(function(){

        $('#reviewForm').validate({

            rules: {

               review_point: {

                   required: true,
               },
               review_text: {

                   required: true,
               },
               designation: {

                  required: true,
               },
            },
            messages: {

               review_point: {

                  required: "Plese select at least one star",
               },
            },
            submitHandler: function(form){

                 form.submit();
            }
        })
   })
</script>

<script>
   $(document).ready(function(){

        $('#messageForm').validate({

            rules: {

               message: {

                   required: true,
               },
            },
            submitHandler: function(form){

                 form.submit();
            }
        })

        $('.submitMessage').click(function(){

            $('#messageForm').submit();
        })
   })
</script>

<script>
     $("#claim_file").change(function () {
            $('.uploaded-file').html('');
            let files = this.files;
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif','image/jpg','application/pdf'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image or pdf files (jpeg, png, gif) only.');
                    $("#claim_file").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uploaded-file').append('<h4>'+f.name+'</h4>');
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>
<script>
   $(document).ready(function(){

      //  $("body").on('click','.userNotClaimSchool', function(){
      //    Swal.fire({
      //    title: "This is your own school, so you can not claim that",
      //    //text: "Someone has placed a bid so unable to edit the auction",
      //    icon: "info"
      //    });
      //  });

       $('.notLogin').click(function(){

           window.location.href = "{{ route('login') }}";
       })

      //  $("body").on('click','.userNotPostReview', function(e){
      //     e.preventDefault();
      //    Swal.fire({
      //    title: "This is your own school, so you can not post review",
      //    //text: "Someone has placed a bid so unable to edit the auction",
      //    icon: "info"
      //    });
      //  });

       $('.noReview').click(function(e){

           e.preventDefault();
           window.location.href = "{{ route('login') }}";

       })

       
       $('.noMessage').click(function(e){

           e.preventDefault();
           window.location.href = "{{ route('login') }}";

       })

      //    $("body").on('click','.userNotSendMessage', function(e){
      //     e.preventDefault();
      //    Swal.fire({
      //    title: "This is your own school, so you can not send a message",
      //    //text: "Someone has placed a bid so unable to edit the auction",
      //    icon: "info"
      //    });
      //  });

       $("body").on('click','.schoolNotClaim', function(e){
          e.preventDefault();
         Swal.fire({
         title: "This school not claim successfully, so you can not send a message",
         //text: "Someone has placed a bid so unable to edit the auction",
         icon: "info"
         });
       });


   });
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry&key={{ env('GOOGLE_MAP_KEY') }}"></script>
<script> 
var geocoder = new google.maps.Geocoder();
var address = document.getElementById("goolge_location").value;
geocoder.geocode( { 'address': address}, function(results, status) {
  if (status == google.maps.GeocoderStatus.OK)
  {
      // do something with the geocoded result
      //
     
      var lat =results[0].geometry.location.lat();
      var lng =results[0].geometry.location.lng();
    //   var lat = 22.5726;
    //   var lng = 88.3639;
      $('#map').html('<iframe src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAP_KEY') }}&q='+address+'&center='+lat+','+lng+'&zoom=15" style="border:0;" allowfullscreen="" loading="lazy"></iframe>');
      
  }
});
</script>
<script>
     $("#school_image").change(function () {
            //$('.images-sec').html('');
            let files = this.files;
            if (files.length <= 4) {
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
                        let html = `<em class="schl-img-nw">
                                          <img src="${e.target.result}" alt="">
                                          <a href="javascript:void(0);" class="delete_image">
                                             <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.25 2.75L2.75 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2.75 2.75L8.25 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                      
                                          </a>
                                       </em>`;
                        $('.upldd-scl-imgs').append(html);
                    };
                    reader.readAsDataURL(f);
                });
            }else{

               alert('Please choose not more than 4 files');
                    $("#school_image").val('');
                    return false;
            }
            
        });
</script>
<script>
   $(document).on('click','.delete_image',function(){

// var image = document.getElementById('file-3').files;

 $(this).parent('.schl-img-nw').remove();

 // var html='';
 // for (i = 0; i < document.getElementById('file-3').files.length; ++i) {
 //     console.log(i)
 //     var ii=document.getElementById('file-3').files[i];
 //     var b=URL.createObjectURL(ii);
 //     html = html+`<li><div class="upimg"><img src="`+b+`"><a href="javascript:;" class="delete_image"><img src="{{ URL::to('public/frontend/images/w-cross.png')}}"></a></div></li>`;
 // }
 // $('#file-3-ul').html(html);
 // console.log(html)
});

$('.submitPhoto').click(function(){

$('#uploadPhotoForm').submit();
})
</script>
<script>
   $(document).ready(function(){

        $('.showImage').click(function(){

             let url = $(this).data('image_url');
             $('#schoolImageshow').attr('src',url);
             $('#schoolImageModal').modal('show');
        })

         $('.schoolUniform').click(function(){

             let url = $(this).data('image_url');
             $('#schoolUniformshow').attr('src',url);
             $('#schoolUniformModal').modal('show');
        })
   })
</script>
<script>
    $('.col').slice(0,6).show();
    $('.view_more_btn').on('click', function(){

          $('.col:hidden').slice(0,6).slideDown();
          if($('.col:hidden').length == 0){

               $('.view_more_btn').fadeOut('slow');
          }
    })
   
</script>
<script>
   $('.video-play-button').click(function(){

      $('#youtubeVieoModal').modal('show');
      let link = "{{ @$schoolDetails->youtube_link }}";
      jQuery('#youtubeVieoModal iframe').attr("src","https://www.youtube.com/embed/"+link);
   })

   $('.img-trigger').click(function(){

      $('#youtubeVieoModal').modal('show');
   })
</script>
<script type="text/javascript">
    $('.btn-close').click(function(){

      jQuery('#youtubeVieoModal iframe').removeAttr("src", jQuery("#youtubeVieoModal iframe").removeAttr("src"));
    })
    
</script>


<script>
   $(document).ready(function(){

        $('#headerImageForm').validate({

            rules: {

               header_image: {

                   required: function(element){

                       let video = $('#youtube_link').val();
                       if(video == '')
                       return true;
                       else
                       return false;
                   },
               },
               youtube_link: {

                       required: function(element){

                       let image = $('#header_image').val();
                       if(image == '')
                       return true;
                       else
                       return false;
                   },
               },
            },
            submitHandler: function(form){

                 form.submit();
            }
        })

        $('.submitBtn1').click(function(){

            $('#headerImageForm').submit();
        })
   })
</script>
<script>
        function ytVidId(url) {
        var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }

    $('#youtube_link').bind("change", function() {

        var url = $(this).val();
        if(url != ''){

            if (ytVidId(url) !== false) {
            $('#youtube_link-error').html('');
            } else {
            $("#youtube_link-error").html('Youtube Link invalid');
            $('#youtube_link-error').css('display','block');
            $('#youtube_link').val('');
            }

        }
        
    });
</script>
<script>
     $("#header_image").change(function () {
            $('.uploaded-img').html('');
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
                    $("#header_image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uploaded-img').append('<img src="'+e.target.result+'" alt="">');
                        $('.uploaded-img').css('display','block');
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>
@endsection