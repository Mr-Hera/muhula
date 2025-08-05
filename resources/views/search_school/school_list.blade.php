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
                    @if(@$key['school_type'] && count(@$key['school_type']) == 1)
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
                    @endif
                  </ol>
                </nav>
                @if(@$key['school_type'] && @$key['town'] && count(@$key['school_type']) == 1)
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
               @endif
            </div>         
         </div>
      </section>

      <section class="search_countown sticky-srch">
         <div class="container">
            <div class="row">
               <div class="result_div">
                  <h3>Result: {{ @$schoolData->count() }} Results Found {{--in <span> Kakamega </span>--}} </h3>
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
                           <h3>School type</h3>

                           <ul class="category-ul agree">
                              @if($school_levels)
                                 @foreach($school_levels as $key=>$level)
                                    <li>
                                       <div class="radiobx">
                                          <label for="">{{ $level->name }}
                                             <input type="checkbox" value="{{ $level->id }}" name="school_level[]" id="{{ $level->name }}" />
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
                           <h3>Course offered</h3>

                           <div class="check_course">
                              <ul class="">
                                 @if(@$courses)
                                    @foreach($courses as $course)
                                       {{-- <div class="{{$course>12 ? 'hide_labelCheckBoxJobRole' :''}}"> --}}
                                       <li>
                                          <input  type="checkbox" name="school_subject[]" id="{{ $course->name }}"  value="{{ $course->id }}" />
                                          <label for="{{ $course->name }}">
                                             <p>{{ $course->name }}</p>
                                          </label>
                                       </li>
                                    </div>
                                    @endforeach
                                 @endif
                                 
                                 {{--<li id="show-more"><a href="javascript:void(0)" class="more_job_role_check_c" id="more_job_role_check">Show More+</a></li>--}}
                                 
                                 {{--<div id="show-more-content">
                                    <li>
                                    <input type="checkbox" name="posts1" id="control_18" value="3">
                                    <label for="control_18">
                                       <p>Business</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="posts1" id="control_19" value="2">
                                    <label for="control_19">
                                       <p>Arts </p>
                                    </label>
                                 </li>
                                 <li>
                                    <input type="checkbox" name="posts1" id="control_20" value="3" >
                                    <label for="control_20">
                                       <p>Computer Sciences</p>
                                    </label>
                                 </li>
                                 <li>
                                    <input  type="checkbox" name="posts1" id="control_21" value="2">
                                    <label for="control_21">
                                       <p>Life Sciences</p>
                                    </label>
                                 </li>
                                 </div>--}}
                                  {{--<li id="show-less"><a href="javascript:void(0)">View less</a></li>--}}
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
                  @if(@$schools->isNotEmpty())
                     @foreach($schools as $school)
                        <div class="search_school_box">
                           <div class="ser_img">
                              <span class="res-tab m-0">
                                 @if(@$school->public_private == 'PB')
                                 Public
                                 @elseif(@$school->public_private == 'PR')
                                 Private
                                 @endif
                                 </span>
                                 @if(@$school->getSchoolMainImage->image != null)
                              <a href="{{ route('school.details',@$school->slug) }}"><img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$school->getSchoolMainImage->image }}" alt=""></a>
                                 @endif
                           </div>
                           {{-- School Cards --}}
                           <div class="serach_sc_details">
                              <div class="search_heading_box">
                                 <div class="search_heading">
                                    <a href="{{ route('school.details',@$school->slug) }}"> <h3>
                                          @if(strlen(@$school->school_name)>50)
                                             {{ substr(@$school->school_name,0,50) }}
                                             @else
                                             {{ @$school->school_name }}
                                             @endif
                                       </h3> </a>
                                       <ul>
                                             @if(@$school->avg_review)
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
                                    <h3>Fees: <span>KES{{ @$school->starting_from_fees }}</span> </h3>
                                    @endauth
                                    <p><img src="{{ asset('images/map-pin.png') }}" alt=""> {{ @$school->getCountry->name }} {{ @$school->town?','.@$school->getTown->city:'' }}</p>
                                 </div>


                              </div>

                              <p class="sc_des">
                              @if(strlen(@$school->about_school)>150)
                              {{ substr(@$school->about_school,0,150) }}
                              @else
                              {{ @$school->about_school }}
                                 @endif
                              </p>

                              <div class="box_info">
                                 <div class="type_list">
                                    <div class="tpe_p">
                                       <span>Type: </span>
                                       <p>
                                       @if(@$school->school_types)
                                       @foreach(@$school->school_types as $key=>$schtype)
                                       {{ @$key > 0?',':'' }} {{ @$schtype->school_type }}
                                       @endforeach
                                       @endif
                                       </p>
                                    </div>
                                    <div class="tpe_p">
                                       <span>Board: </span>
                                       <p>
                                       @if(@$school->school_boards)
                                       @foreach(@$school->school_boards as $key=>$schoolboard)
                                       {{ @$key > 0?',':'' }} {{ @$schoolboard->board_name }}
                                       @endforeach
                                       @endif
                                       </p>
                                    </div>
                                    <div class="tpe_p">
                                       <span>Gender: </span>
                                       <p>
                                       @if(@$school->gender == 'M')
                                       Male
                                       @elseif(@$school->gender == 'F')
                                       Female
                                       @elseif(@$school->gender == 'B')
                                       Both
                                       @endif
                                       </p>
                                    </div>
                                    <div class="tpe_p">
                                       <span>Shifting: </span>
                                       <p>
                                          @if(@$school->boarding_type == 'D')
                                          Day
                                          @elseif(@$school->boarding_type == 'B')
                                          Boading
                                          @elseif(@$school->boarding_type == 'DB')
                                          Day & Boading
                                          @endif
                                       </p>
                                    </div>
                                 </div>
                                 <a href="{{ route('school.details',@$school->slug) }}" class="view_btns">View School <img src="{{ url('public/images/chevron-rights.png') }}" alt=""> </a>
                              </div>
                           </div>
                        </div>
                     @endforeach
                  @else
                  <h2><center>No Data Found</center></h2>
                  @endif
                  
            </div>


                  <div class="pagination_box">
                  {{@$schools->appends(request()->except(['page', '_token']))->links('pagination')}}
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