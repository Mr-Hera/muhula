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
               <form action="{{ route('school.search.map') }}" method="post" id="searchForm">
                @csrf
                <input type="hidden" name="location" placeholder="Enter here" value="{{ @$key['location'] }}">
                  <input type="hidden" name="keyword" placeholder="Enter here" value="{{ @$key['keyword'] }}">
                <input type="hidden" name="sort_by" id="sort_by">
                  <div class="serach_panels left-bar">
                     <div class="top_toggle">
                        <ul>
                           <li><a class="active" href="{{ route('school.search.map') }}"> <img src="{{ asset('images/location1.png') }}" alt=""> Map View</a> </li>
                           <li><a class="" href="{{ route('school.search') }}"> <img src="{{ asset('images/list1.png') }}" alt=""> Listing View</a> </li>
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
                                    @if ($level->name != "General")
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
                                    @endif
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
                                 @if($courses && $courses->count())
                                    @foreach($courses as $course)
                                          <li>
                                             <input type="checkbox" 
                                                   name="school_subject[]" 
                                                   id="course_{{ $course->id }}" 
                                                   value="{{ $course->id }}" />
                                             <label for="course_{{ $course->id }}">
                                                <p>{{ $course->name }}</p>
                                             </label>
                                          </li>
                                    @endforeach
                                 @else
                                    <li>
                                          <p>No courses available for this level.</p>
                                    </li>
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
                           <button class="app_btns" >Apply Filter</button>
                           <button class="clear_btns clearBtn">Clear All</button>
                        </div>
                     </div>


                  </div>
                  </form>
               </div>

               <div class="right_panel_serach ">
                  <div class="new_fixed_area">
                     <div class="new_ares" id="map">
                        {{--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255282.3586903348!2d36.682580554191205!3d-1.3028602819557467!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1172d84d49a7%3A0xf7cf0254b297924c!2sNairobi%2C%20Kenya!5e0!3m2!1sen!2sin!4v1708521789976!5m2!1sen!2sin"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}

                        {{--<div class="map_lac1">
                          <a href="#"><img src="{{ asset('images/location2.png') }}" alt=""></a> 
                        </div>
                        <div class="map_lac2">
                          <a href="#"><img src="{{ asset('images/location2.png') }}" alt=""></a>
                        </div>
                        <div class="map_lac3">
                          <a href="#"><img src="{{ asset('images/location2.png') }}" alt=""></a> 
                        </div>
                        <div class="map_lac4">
                          <a href="#"><img src="{{ asset('images/location2.png') }}" alt=""></a>
                        </div>--}}
                     </div>
                  </div>
                 
               </div>

            </div>
         </div>
      </section>

      <div class="modal modal_lciam" id="schoolInfoModal">
        <div class="modal-dialog modal-dialog-centered">
        
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">School Information</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <a href="" id="moreDetails">
            <div class="modal-body image-modal school-modal">
                <em class="schl-mod-logo"><img src="" alt="" id="schoolLogo"></em>
                <div class="schl-mod-txt">
                   <h3><b>School Name:</b><span id="schoolname"></span></h3>
                   <h3><b>School Board:</b><span id="schoolboard"></span></h3>
                   <h3><b>Location:</b><span id="schoolLocation"></span></h3>
                </div>
            </div>
            </a>
          </div>
         
        </div>
      </div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap"></script>
<script>
   var latArray = [];
   var lngArray = [];
   var slugArray = [];
   var schoolnameArray = [];
   var locationArray = [];
   var logoArray = [];
   let schooltype = [];
   let typeArray = [];
   let boardArray = [];
   @if(@$schoolData)
   @foreach($schoolData as $lat)
   latArray.push('{{ @$lat->google_lat }}');
   @endforeach
   @endif

   @if(@$schoolData)
   @foreach($schoolData as $lng)
   lngArray.push('{{ @$lng->google_long }}');
   @endforeach
   @endif

   @if(@$schoolData)
   @foreach($schoolData as $slug)
   slugArray.push('{{ @$slug->slug }}');
   @endforeach
   @endif

   @if(@$schoolData)
   @foreach($schoolData as $schoolname)
   schoolnameArray.push('{{ @$schoolname->school_name }}');
   @endforeach
   @endif

   @if(@$schoolData)
   @foreach($schoolData as $location)
   locationArray.push('{{ @$location->google_location }}');
   @endforeach
   @endif

   @if(@$schoolData)
   @foreach($schoolData as $logo)
   logoArray.push('{{ @$logo->school_logo }}');
   @endforeach
   @endif

@if(@$schoolData)
   @foreach($schoolData as $board)
   boardArray.push('{{ @$board->getSchoolBoard->getBoard->board_name }}');
   @endforeach
   @endif

   //console.log(typeArray);
   function initMap() {
        var bounds = new google.maps.LatLngBounds();
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv);
        if(latArray.length > 0){
           
         map.setCenter(new google.maps.LatLng(latArray[0],lngArray[0]));
        }else{

         map.setCenter(new google.maps.LatLng(0.0236,37.9062));
        } 

        map.setZoom(3);
        var marker=[];
        for(let i=0;i<latArray.length;i++)
        {
            marker[i] = new google.maps.Marker({
                position: new google.maps.LatLng(latArray[i],lngArray[i]),
                map: map,
                title:"This is the place.",
                // icon:"phone4.png" 
            }); 
            marker[i].addListener('click', function() {
            //infoWindow.open(map, marker);
            $('#schoolname').html(schoolnameArray[i]);
            $('#schoolLocation').html(locationArray[i]);
            $('#schoolboard').html(boardArray[i]);
            $('#moreDetails').attr('href',"{{ route('school.details') }}/"+slugArray[i]);
            $('#schoolLogo').attr('src',"{{ URL::to('storage/app/public/images/school_logo') }}/"+logoArray[i])
            $('#schoolInfoModal').modal('show');
            // window.location.href = "{{ route('school.details') }}/"+slugArray[i];
            //alert(latArray[i]);
            });

            //bounds.extend(marker.getPosition());  
            //console.log(latArray);
            //console.log(lngArray);
        }
        //map.fitBounds(bounds);
      //   var infoWindow = new google.maps.InfoWindow({
      //       content: contentString
      //   });
    }
</script>

<script>
   $(document).ready(function(){

        $('.clearBtn').click(function(e){

             e.preventDefault();
             window.location.href = "{{ route('school.search.map') }}";
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