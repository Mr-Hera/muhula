@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="inner_banner">
   <img src="{{ asset('images/inner-banner.png') }}" alt="" class="innr-bnnr-img ">
   <div class="in-bn-txt">
      <div class="container ">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               {{-- @if(@$key['school_type'] && count(@$key['school_type']) == 1)
                  @php
                     $schoolType = App\Models\SchoolType::whereIn('id',@$key['school_type'])->first();
                  @endphp
                  <li class="breadcrumb-item active">{{ @$schoolType->school_type }}</li>
               @endif
               @if(@$key['board'])
                  @php
                     $schoolBoard = App\Models\Board::where('id',@$key['board'])->first();
                  @endphp
                  <li class="breadcrumb-item active">{{ @$schoolBoard->board_name }}</li>
               @endif
               @if(@$key['location'])
                  <li class="breadcrumb-item active">{{ @$key['location'] }}</li>
               @endif
               @if(@$key['town'])
                  @php
                     $town_name = App\Models\City::where('id',@$key['town'])->first();
                  @endphp
                  <li class="breadcrumb-item active" aria-current="page">{{ @$town_name->city }}</li>
               @endif
               @if(@$key['keyword'])
                  <li class="breadcrumb-item active" aria-current="page">{{ @$key['keyword'] }}</li>
               @endif --}}
            </ol>
         </nav>
         {{-- @if(@$key['school_type'] && @$key['town'] && count(@$key['school_type']) == 1)
            @php
               $schoolType1 = App\Models\SchoolType::whereIn('id',@$key['school_type'])->first();
               $town_name1 = App\Models\City::where('id',@$key['town'])->first();
            @endphp
            @if(@$schoolType1->school_type != 'College')
               <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for {{ @$schoolType1->school_type }} schools @if($town_name1) in {{ @$town_name1->city }} @endif</h1>
            @else
               <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for {{ @$schoolType1->school_type }} @if($town_name1) in {{ @$town_name1->city }} @endif</h1>
            @endif
         @elseif(@$key['school_type'] && count(@$key['school_type']) == 1)
            @php
               $schoolType1 = App\Models\SchoolType::whereIn('id',@$key['school_type'])->first();
            @endphp
            @if(@$schoolType1->school_type != 'College')
               <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for {{ @$schoolType1->school_type }} schools</h1>
            @else
               <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for {{ @$schoolType1->school_type }}</h1>
            @endif
         @elseif((@$key['town'] && !@$key['board']))
            @php
               $town_name1 = App\Models\City::where('id',@$key['town'])->first();
            @endphp
            <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results in {{ @$town_name1->city }}</h1>
         @endif
            
         @if(@$key['board'] && @$key['town'])
            @php
               $schoolBoard = App\Models\Board::where('id',@$key['board'])->first();
               $town_name = App\Models\City::where('id',@$key['town'])->first();
            @endphp
            <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for schools offering {{ @$schoolBoard->board_name }} @if($town_name) in {{ @$town_name->city }} @endif</h1>
         @elseif(@$key['board'])
            @php
               $schoolBoard = App\Models\Board::where('id',@$key['board'])->first();
            @endphp
            <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Search results for schools offering {{ @$schoolBoard->board_name }}</h1>
         @endif

         @if(!@$key['school_type'] && !@$key['board'] && !@$key['town'])
            <h1>{{ @$schoolData->count() }} Results Found</h1>
         @elseif(@$key['school_type'] && count(@$key['school_type']) > 1)
            <h1>{{ @$schoolData->count() }} of {{ @$total_school }} Results Found</h1>
         @endif --}}
      </div>         
   </div>
</section>

      <section class="search_countown sticky-srch">
         <div class="container">
            <div class="row">
               <div class="result_div">
                  <h3>Result: {{ $schools->count() }} Results Found {{--in <span> Kakamega </span>--}} </h3>
                  <a  class="filter-btn click_filter"> <img src="{{ url('public/images/Icon.png') }}" alt=""> Filter</a>
                  
                     <form action="{{ route('school.search') }}" class="sorts-srch d-flex" method="post">
                        @csrf
                        <div class="search_in">
                           <label>Search by Location</label>
                           <input type="text" name="location" placeholder="Enter here" value="{{ @$key['location'] }}">
                        </div>
                        <div class="search_in">
                           <label>Search by Keywords</label>
                           <input type="text" name="keyword" placeholder="Enter here" value="{{ @$key['keyword'] }}">
                        </div>
                        <button type="submit" class="loc-key-srch"><img src="{{ asset('images/search.png') }}" alt=""> </button>
                     </form>
                     <div class="sort_divs">
                        <p>Sort By:</p>
                        <select id="sortBy">
                           <option value="1" @if(@$key['sort_by'] == 1) selected @endif>Popularity</option>
                           <option value="2" @if(@$key['sort_by'] == 2) selected @endif>High to Low Fees</option>
                           <option value="3" @if(@$key['sort_by'] == 3) selected @endif>Low to High Fees</option>
                        </select>
                     </div>
               </div>
            </div>
         </div>
      </section>

      <section class="search_listing">
         <div class="container">
            <div class="row">
               <div class="left_panel_serach">
               <form action="{{ route('school.search') }}" method="post" id="searchForm">
                  @csrf
                  <input type="hidden" name="location" placeholder="Enter here" value="{{ @$key['location'] }}">
                  <input type="hidden" name="keyword" placeholder="Enter here" value="{{ @$key['keyword'] }}">
                  <input type="hidden" name="board" id="board" value="{{ @$key['board'] }}">
                  <input type="hidden" name="sort_by" id="sort_by">
                  <div class="serach_panels left-bar">
                     <div class="top_toggle">
                        <ul>
                           <li><a class="" href="{{ route('school.search.map') }}"> <img src="{{ url('public/images/location.png') }}" alt=""> Map View</a> </li>
                           <li><a class="{{ Route::is('school.search')?'active':'' }}" href="{{ route('school.search') }}"> <img src="{{ url('public/images/list.png') }}" alt=""> Listing View</a> </li>
                        </ul>
                     </div>

                     <div class="search_cirtariya">
                        
                        {{--<div class="search_in">
                           <label>Search by Location</label>
                           <input type="text" name="location" placeholder="Enter here" value="{{ @$key['location'] }}">
                        </div>
                        <div class="search_in">
                           <label>Search by Keywords</label>
                           <input type="text" name="keyword" placeholder="Enter here" value="{{ @$key['keyword'] }}">
                        </div>--}}

                        <div class="post_radio">
                           <div class="row">
                              <div class="col-6 col-sm-4 col-md-3 col-lg-6">
                                 <div class="radio_post">
                                    <input  type="checkbox" name="public_private[]" id="control_01" @if(@$key['public_private']) {{ in_array('PR',@$key['public_private'])?'checked':'' }} @else checked @endif value="PR">
                                    <label for="control_01">
                                       <img src="{{ asset('images/school.png') }}" alt="" class="dis_b">
                                       <p>Private School</p>
                                    </label>
                                 </div>
                              </div>
                              <div class="col-6 col-sm-4 col-md-3  col-lg-6">
                                 <div class="radio_post">
                                    <input type="checkbox" name="public_private[]" id="control_02" value="PB" @if(@$key['public_private']) {{ in_array('PB',@$key['public_private'])?'checked':'' }} @endif>
                                    <label for="control_02">
                                       <img src="{{ asset('images/school.png') }}" alt="" class="dis_b">
                                       <p>Public School</p>
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="check_short">
                           <h3>School Level</h3>

                           <ul class="category-ul agree">
                              @if($school_levels)
                                 @foreach($school_levels as $key=>$level)
                                    <li>
                                       <div class="radiobx">
                                          <label for="">{{ $level->name }}
                                             <input
                                                type="checkbox"
                                                value="{{ $level->id }}"
                                                name="school_level[]"
                                                id="{{ $level->name }}"
                                                @if(isset($dynamic_school_level) && $level->name === $dynamic_school_level) checked @endif
                                             />
                                             <span class="checkbox"></span>
                                          </label>
                                       </div>
                                    </li>
                                 @endforeach
                              @endif
                           </ul>
                        </div>

                        <div class="check_short">
                           <h3>Town</h3>
                           <div class="sort_divs">
                              <select name="town" id="town" class="w-100">
                                 <option value="">Select</option>
                                 @if($counties)
                                    @foreach($counties as $county)
                                       <option value="{{ $county->id }}" >{{ @$county->name }}</option>
                                    @endforeach
                                 @endif
                              </select>
                           </div>
                        </div>

                        <div class="check_short">
                           <h3>Course Offered</h3>

                           <div class="check_gender">
                              <ul>
                                 @if($courses)
                                    @foreach($courses as $course)
                                       <li>
                                          <input type="checkbox" name="school_subject[]" id="course_{{ $course->id }}" value="{{ $course->id }}" />
                                          <label for="course_{{ $course->id }}">
                                             <p>{{ $course->name }}</p>
                                          </label>
                                       </li>
                                    @endforeach
                                 @endif
                              </ul>
                           </div>
                        </div>

                        <div class="check_short">
                           <h3>Gender</h3>

                           <div class="check_gender">
                              <ul>
                                 <li>
                                    <input  type="checkbox" name="gender[]" id="gender_is_male" value="Male" />
                                    <label for="gender_is_male">
                                       <p>Male</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="gender[]" id="gender_is_female"  value="Female" />
                                    <label for="gender_is_female">
                                       <p>Female</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="gender[]" id="gender_is_mixed" value="Mixed" />
                                    <label for="gender_is_mixed">
                                       <p>Both</p>
                                    </label>
                                 </li>
                              </ul>
                           </div>
                           
                        </div>

                        <div class="check_short">
                           <h3>Type</h3>

                           <div class="check_gender">
                              <ul>
                                 <li>
                                    <input  type="checkbox" name="boarding_type[]" id="type_01"  value="{{ $school_types_day->id }}" />
                                    <label for="type_01">
                                       <p>Day</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="boarding_type[]" id="type_02"  value="{{ $school_types_boarding->id }}" />
                                    <label for="type_02">
                                       <p>Boarding</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="boarding_type[]" id="type_03" value="{{ $school_types_day_n_boarding->id }}" />
                                    <label for="type_03">
                                       <p>Day & Boarding</p>
                                    </label>
                                 </li>
                              </ul>
                           </div>
                           
                        </div>

                        <div class="check_short">
                           <h3>Average reviews</h3>

                           <ul class="category-ul agree">
                              <li>
                                 <div class="radiobx">
                                    <label for="">
                                          <ul class="start_ca">
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li><p>(5 Star)</p></li>
                                          </ul>

                                          <input type="radio" name="avg_review" id="reviews1" value="5.0" @if(@$key['avg_review'] == 5.0) checked @endif>
                                          <span class="checkbox"></span>
                                       </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radiobx">
                                    <label for="">
                                       <ul class="start_ca">
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li><p>(4 Star)</p></li>
                                          </ul>
                                          <input type="radio" name="avg_review" id="reviews2" value="4.0" @if(@$key['avg_review'] == 4.0) checked @endif>
                                          <span class="checkbox"></span>
                                       </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radiobx">
                                    <label for="">
                                       <ul class="start_ca">
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li><p>(3 Star)</p></li>
                                          </ul>
                                          <input type="radio" name="avg_review" id="reviews3" value="3.0" @if(@$key['avg_review'] == 3.0) checked @endif>
                                          <span class="checkbox"></span>
                                       </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radiobx">
                                    <label for="">
                                       <ul class="start_ca">
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li><p>(2 Star)</p></li>
                                          </ul>
                                          <input type="radio" name="avg_review" id="reviews4" value="2.0" @if(@$key['avg_review'] == 2.0) checked @endif>
                                          <span class="checkbox"></span>
                                       </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radiobx">
                                    <label for="">
                                       <ul class="start_ca">
                                             <li>
                                                <img src="{{ asset('images/fstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li>
                                                <img src="{{ asset('images/lstar.png') }}" alt="">
                                             </li>
                                             <li><p>(1 Star)</p></li>
                                          </ul>
                                          <input type="radio" name="avg_review" id="reviews5" value="1.0" @if(@$key['avg_review'] == 1.0) checked @endif>
                                          <span class="checkbox"></span>
                                       </label>
                                 </div>
                              </li>
                              
                           </ul>
                     </div>

                     <div class="clear_list_button">
                        <button class="app_btns" type="submit">Apply Filter</button>
                        <button class="clear_btns clearBtn" >Clear All</button>
                     </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="right_panel_serach">
               <div class="serach_box_listing">
                  @if($schools->isNotEmpty())
                     @foreach($schools as $school)
                        <div class="search_school_box">
                           <div class="ser_img">
                              <span class="res-tab m-0">
                                 @if($school->ownership == 'Public')
                                 Public
                                 @elseif($school->ownership == 'Private')
                                 Private
                                 @endif
                                 </span>
                                 @if($school->logo == null)
                                    <a href="{{ route('school.details',$school->slug) }}">
                                       {{-- <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$school->getSchoolMainImage->image }}" alt=""> --}}
                                       <img src="{{asset('public/default_images/default.jpg')}}" alt="" />
                                    </a>
                                 @else
                                    <a href="{{ route('school.details',$school->slug) }}">
                                       {{-- <img src="{{asset('storage/default_images/default.jpg')}}" alt="" /> --}}
                                       <img 
                                          src="{{ asset('storage/'. $school->logo) }}" 
                                          alt="{{ $school->name }}" 
                                       />
                                    </a>
                                 @endif
                           </div>
                           {{-- School Cards --}}
                           <div class="serach_sc_details">
                              <div class="search_heading_box">
                                 <div class="search_heading">
                                    <div class="d-flex align-items-center">
                                       <a href="{{ route('school.details',$school->slug) }}">
                                          <h3 class="mb-0">
                                                @if(strlen($school->name) > 50)
                                                   {{ substr($school->name, 0, 50) }}
                                                @else
                                                   {{ $school->name }}
                                                @endif
                                          </h3>
                                       </a>

                                       @auth
                                       @php
                                          $check = App\Models\Favourite::where('user_id', Auth::id())
                                                ->where('favouritable_id', $school->id)
                                                ->where('favouritable_type', App\Models\School::class)
                                                ->first();
                                       @endphp

                                       <form action="{{ route('user.add.favourite') }}" method="POST" class="ms-2">
                                          @csrf
                                          <input type="hidden" name="school_id" value="{{ $school->id }}">
                                          <button type="submit" class="{{ $check ? 'active' : '' }}" style="background: none; border: none; padding: 0; cursor: pointer;">
                                             <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20.8401 4.61012C20.3294 4.09912 19.7229 3.69376 
                                                         19.0555 3.4172C18.388 3.14064 17.6726 2.99829 16.9501 2.99829
                                                         C16.2276 2.99829 15.5122 3.14064 14.8448 3.4172C14.1773 3.69376 
                                                         13.5709 4.09912 13.0601 4.61012L12.0001 5.67012L10.9401 
                                                         4.61012C9.90843 3.57842 8.50915 2.99883 7.05012 2.99883
                                                         C5.59109 2.99883 4.19181 3.57842 3.16012 4.61012C2.12843 
                                                         5.64181 1.54883 7.04108 1.54883 8.50012C1.54883 9.95915 
                                                         2.12843 11.3584 3.16012 12.3901L4.22012 13.4501L12.0001 
                                                         21.2301L19.7801 13.4501L20.8401 12.3901C21.3511 11.8794 
                                                         21.7565 11.2729 22.033 10.6055C22.3096 9.93801 22.4519 
                                                         9.2226 22.4519 8.50012C22.4519 7.77763 22.3096 7.06222 
                                                         22.033 6.39476C21.7565 5.7273 21.3511 5.12087 
                                                         20.8401 4.61012Z"
                                                      stroke="{{ $check ? '#CC0000' : '#B9B9B9' }}"
                                                      fill="{{ $check ? '#CC0000' : 'none' }}"
                                                      stroke-width="2"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                             </svg>
                                             </button>
                                       </form>
                                       @endauth
                                    </div>
                                       <ul>
                                             @if($school->avg_review)
                                             @php $school->avg_review = $school->avg_review+0; @endphp
                                             @for($sst = 1; $sst <= $school->avg_review; $sst++)
                                             <li><img src="{{ asset('images/fstar.png') }}" alt=""></li>
                                             @endfor
                                             @if(strpos($school->avg_review,'.'))
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
                                       {{--<li> <img src="{{ url('public/images/fstar.png') }}" alt=""> </li>
                                       <li> <img src="{{ url('public/images/fstar.png') }}" alt=""> </li>
                                       <li> <img src="{{ url('public/images/fstar.png') }}" alt=""> </li>
                                       <li> <img src="{{ url('public/images/fstar.png') }}" alt=""> </li>
                                       <li> <img src="{{ url('public/images/lstar.png') }}" alt="">--}}
                                    </ul>
                                 </div>

                                 <div class="search_price">
                                    @auth
                                       <h3>Fees: <span>KES{{ $school->starting_from_fees }}</span> </h3>
                                    @endauth
                                    <p><img src="{{ asset('images/map-pin.png') }}" alt="" /> {{ optional($school->country)->name ?? 'N/A' }}, {{ optional($school->county)->name ?? 'N/A' }}</p>
                                 </div>


                              </div>

                              <p class="sc_des">
                                 @if(strlen($school->description)>150)
                                    {{ substr($school->description,0,150) }}
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
                                       @if($school->gender_admission == 'Male')
                                       Male
                                       @elseif($school->gender_admission == 'Female')
                                       Female
                                       @elseif($school->gender_admission == 'Mixed')
                                       Mixed
                                       @endif
                                       </p>
                                    </div>
                                    <div class="tpe_p">
                                       <span>Shifting: </span>
                                       <p>
                                          {{ $school->type->name ?? 'N/A' }}
                                       </p>
                                    </div>
                                 </div>
                                 <a href="{{ route('school.details',$school->slug) }}" class="view_btns">View School <img src="{{ url('public/images/chevron-rights.png') }}" alt=""> </a>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  @else
                  <h2><center>No Data Found</center></h2>
                  @endif
                  
            </div>


                  <div class="pagination_box">
                  {{-- {{@$schools->appends(request()->except(['page', '_token']))->links('pagination')}} --}}
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

        $('.clearBtn').click(function(e){

             e.preventDefault();
             window.location.href = "{{ route('school.search') }}";
        })
   })
</script>
<script>
     $("body").delegate("#more_job_role_check", "click", function(e) {
      var less_btn = `<a href="javascript:;" class="more_job_role_check_c" id="less_job_role_check" >Less -</a>`;
        //$(".hide_labelCheckBoxJobRole").slideDown();
        $(this).parent().append(less_btn);
        $(this).remove();
      });
      $("body").delegate("#less_job_role_check", "click", function(e) {

        var more_btn = `<a href="javascript:;" class="less_job_role_check_c" id="more_job_role_check" >More +</a>`;
        $(".hide_labelCheckBoxJobRole").slideUp();
        $(this).parent().append(more_btn);
        $(this).remove();
      });
</script>
<script>
   $(document).ready(function(){

        $('#sortBy').change(function(){

            var value = $(this).val();
            $('#sort_by').val(value);
            $('#searchForm').submit();
        })

        $('#agree1').click(function(e){
            $('#board').val('');
        })
        $('#agree2').click(function(e){
            $('#board').val('');
        })
        $('#agree3').click(function(e){
            $('#board').val('');
        })
        $('#agree4').click(function(e){
            $('#board').val('');
        })
   })
</script>
@endsection