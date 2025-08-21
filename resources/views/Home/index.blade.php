@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="banner-home d-block position-relative w-100">
         <div class="banner-inr">
               <div class="owl-carousel owl-theme owl-banner position-relative">
                  <div class="item">
                     <div class="banner_img">
                        <img src="{{ asset('images/banner1a.png') }}" alt="">
                        <div class="banner_overlay"></div>
                     </div>
                  </div>
                  <div class="item">
                     <div class="banner_img">
                        <img src="{{ asset('images/banner2a.png') }}" alt="">
                     </div>
                  </div>
                  <div class="item">
                     <div class="banner_img">
                        <img src="{{ asset('images/banner3a.png') }}" alt="">
                     </div>
                  </div>
               </div>
         </div>
         <div class="banner_txt">
            <div class="container">
               <div class="txt_area">
                   <h1>Your Comprehensive Listing of Learning Institutions in Kenya. Let more people know about your learning institution</h1>
               </div>
            </div>
         </div>

      </section>

       <section class="banner_serach">
            <div class="container">
               <div class="banner-form">
                    <form action="{{ route('school.search') }}" class="bnr-frm" method="post">
                        @csrf
                        <div class="bnr-inpt1 bnr-frm-ins">
                            <label for="Keywords" class="form-label">Search by Keywords</label>
                            <input type="text" class="form-control" id="Keywords" placeholder="Enter here" name="keyword">
                        </div>
                        <div class="bnr-inpt2 bnr-frm-ins" id="location2">
                            <label for="location" class="form-label">Schools by Location</label>
                            <input type="text" class="form-control" placeholder="Enter here" name="location">                            
                        </div>
                        <button type="submit" class="bnr-btn">Search</button>                        
                    </form>
                </div>
            </div>
      </section>

      <section class="index-how">
        <div class="container">
         <div class="row">
          <div class="index-how-hdr">
            <h2>Why Choose Muhula</h2>
          </div>
          <div class="inx-how-inr">
            <div class="row g-0 align-items-stretch">
              <div class="col-lg-4 col-md-4">
                <div class="how-box-outr position-relative ml-15">
                  <span>1</span>
                  <div class="how-box-inr mr-15">
                    <div class="hb-img">
                        <img src="{{ asset('images/how-bx1.png') }}" alt="">
                     </div>
                    <h5>Register on Muhula.com</h5>
                    <p>Register your school on muhula.com and let prospective learners know more about your school and communicate important information, such as your programs, mission, and history.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="how-box-outr position-relative">
                  <span>2</span>
                  <div class="how-box-inr ml-15 mr-15">
                    <div class="hb-img">
                        <img src="{{ asset('images/how-bx2.png') }}" alt="">
                     </div>
                    <h5>Search & Choose School</h5>
                    <p>On muhula.com you can find school(s) that are best suited to your learning needs. Explore common considerations, including costs, facilities, courses, and student resources and services.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="how-box-outr position-relative mr-15">
                  <span>3</span>
                  <div class="how-box-inr ml-15">
                    <div class="hb-img">
                        <img src="{{ asset('images/how-bx3.png') }}" alt="">
                     </div>
                    <h5>Claim School & reply to reviews</h5>
                    <p>You can claim and manage your school on  muhula.com by sharing up to date information. Our reviews on Muhula.com are community driven and help learners gain better understanding of your institution.</p>
                  </div>
                </div>
              </div>
              <div class="col-12">
              <div class="join_us_btns mt-2">
                  <div class="join_box">
                     <p>Want to explore more Popular School </p>
                     <a href="{{ route('user.register') }}">Join for Free! </a>
                  </div>
               </div>          
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="spae_whys">
            <img src="{{ asset('images/sh1.png') }}" alt="">
        </div>
      </section>

      {{-- <section class="featured-school">
         <div class="shpa_gr">
            <img src="{{ url('public/images/banner-fest.png') }}" alt="">
         </div>
         <div class="container">
            <div class="row">
            @if(@$featuredSchool->isNotEmpty())
               <div class="section_header">
                  <h2>Featured Schools</h2>
                  <p>Lorem ipsum dolor sit amet, lorem ipsum dolor sit amet, consecteturconsectetur</p>
               </div>
                @endif
               <div class="featured-school-inr">
                  <div class="owl-carousel owl_produs owl-theme owl-featured-school position-relative">
                     @if(@$featuredSchool->isNotEmpty())
                     @foreach($featuredSchool as $data)
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
                                 <li><img src="{{ url('public/images/fstar.png') }}" alt=""></li>
                                 @endfor
                                 @if(strpos($data->avg_review,'.'))
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
                                 <p><img src="{{ url('public/images/map-pin.png') }}" alt="">{{ @$data->getCountry->name }}</p>
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
                                    @endif</p>
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
                                 @auth
                                 <h3>Fees: <span>KES{{ @$data->starting_from_fees }}</span> </h3>
                                 @endauth
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
         <div class="shpa_wh">
            <img src="{{ url('public/images/white_back.png') }}" alt="">
         </div>
      </section> --}}

        {{-- @if(@$advertise)
            <section class="adv_sec mt-5 mb-5 position-relative" style="z-index:99;">
                <div class="container">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="ad_box ">
                            <a href="{{ @$advertise->advertise_url }}" target="_blank">
                                <div class="ad_imgs">
                                @if(@$advertise->image != null)
                                <img src="{{ URL::to('storage/app/public/images/advertise_image') }}/{{ @$advertise->image }}" alt="">
                                @endif
                                </div>
                                <div class="ad_text">
                                    <h2>{{ @$advertise->heading }}</h2> 
                                <p>{{ @$advertise->description }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        @endif --}}


      <section class="school-type">
         <div class="container">
            <div class="row">
               <div class="section_header">
                  <h2>School by Types</h2>
                  <p>Choose a School Type and discover interesting schools for you</p>
               </div>

               <div class="subject-inr">
               {{--<div class="subject-box">
                     <a href="javascript:;">
                      <div class="sub-img"><img src="{{ url('public/images/type1.png') }}" alt=""></div>
                      <div class="sub-txt"><h3>Nursery<span>(256)</span></h3></div>
                     </a>
                  </div>

                  <div class="subject-box">
                     <a href="javascript:;">
                      <div class="sub-img"><img src="{{ url('public/images/type2.png') }}" alt=""></div>
                      <div class="sub-txt"><h3>Primary<span>(189)</span></h3></div>
                     </a>
                  </div>

                  <div class="subject-box">
                     <a href="javascript:;">
                      <div class="sub-img"><img src="{{ url('public/images/type3.png') }}" alt=""></div>
                      <div class="sub-txt"><h3>Upper Primary<span>(901)</span></h3></div>
                     </a>
                  </div>

                  <div class="subject-box">
                     <a href="javascript:;">
                      <div class="sub-img"><img src="{{ url('public/images/type4.png') }}" alt=""></div>
                      <div class="sub-txt"><h3>Secondary<span>(1025)</span></h3></div>
                     </a>
                  </div>

                  <div class="subject-box">
                     <a href="javascript:;">
                      <div class="sub-img"><img src="{{ url('public/images/type5.png') }}" alt=""></div>
                      <div class="sub-txt"><h3>Colleges<span>(2045)</span></h3></div>
                     </a>
                  </div>--}}
                  @if($school_levels && $school_levels->count())
                     @foreach($school_levels as $level)
                        @php
                              $levelName = strtolower($level->name); // e.g., 'nursery'
                              $imageNumber = match($levelName) {
                                 'nursery' => '1',
                                 'primary' => '2',
                                 'secondary' => '3',
                                 'college' => '4',
                                 default => '1'
                              };
                              $schoolCount = $schoolLevelCounts[$levelName] ?? 0;
                        @endphp

                        <div class="subject-box">
                           <a class="nav-link" href="{{ route('school.search') }}?school_type={{ $level->id }}">
                              <div class="sub-img">
                                 <img src="{{ asset("images/type{$imageNumber}.png") }}" alt="{{ $level->name }}">
                              </div>
                              <div class="sub-txt">
                                 <h3>{{ $level->name }} <span>({{ $schoolCount }})</span></h3>
                              </div>
                           </a>
                        </div>
                     @endforeach
                  @endif
               </div>
            </div>
         </div>
      </section>

      <section class="get_started">
         <div class="container">
             <div class="satis-inr">
               <div class="satis-number">
                   <p class="counter-count">1500</p>
                   <h5>Satisfied Client</h5>
               </div>
               <div class="satis-txt">
                 <img src="{{ asset('images/satis-bg.png') }}" alt="">
                 <div class="satis-main">
                   <h5>Looking for a School & It’s missing?</h5>
                   <p>You can list your school for Free & connect with thousands of other connections</p>
                 </div>
                 <a href="{{ route('user.register') }}" class="satis-btn">Get Started</a>
               </div>
             </div>
           </div>
      </section>
      @if(@$advertise)
      <section class="adv_sec">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="ad_box">
                     <a href="{{ @$advertise->advertise_url }}" target="_blank">
                        <div class="ad_imgs">
                           @if(@$advertise->image != null)
                           <img src="{{ URL::to('storage/app/public/images/advertise_image') }}/{{ @$advertise->image }}" alt="">
                           @endif
                        </div>
                        <div class="ad_text">
                            <h2>{{ @$advertise->heading }}</h2> 
                           <p>{{ @$advertise->description }}</p>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      @endif

      <section class="school_curicullam">
         <div class="container-fluid top-container">
            <div class="row">
               <div class="section_header">
                  <h2>Schools by Curriculum</h2>
                  <p>Choose a Curriculum and discover interesting schools for you</p>
               </div>
               <form action="{{ route('school.search') }}" method="post" id="searchSchoolBoard">
                  @csrf
                 <input type="hidden" name="curriculum_id" id="schoolBoard">
                 <input type="hidden" name="county" id="schoolTown">
               </form>
               <div class="curriculam_info">
                  @if($curricula && $curricula->count())
                     @foreach($curricula as $curriculum)
                        <div class="curriculam_box">
                              <a href="javascript:;" class="school_board" data-school_board="{{ $curriculum->id }}">
                                 <h2>{{ $curriculum->name }}</h2>
                                 <p>
                                    {{ $curriculum->schools_count }} School{{ $curriculum->schools_count !== 1 ? 's' : '' }}
                                    <img src="{{ asset('images/chevrone.png') }}" alt="">
                                 </p>
                              </a>
                        </div>
                     @endforeach
                  @else
                     <p class="text-center text-muted">No curriculum records found.</p>
                  @endif
               </div>
            </div>
         </div>
      </section>

      <section class="loaction_school">
         <div class="loc_sha">
            <img src="{{ asset('images/icon-e.png') }}" alt="">
         </div>
         <div class="container-fluid top-container">
            <div class="row">
               <div class="section_header">
                  <h2>Schools by Town/City</h2>
                  <p>Choose a Town/City and discover interesting schools for you</p>
               </div>

               <div class="featured-location-inr">
                  <div class="owl-carousel owl_produs owl-theme owl_produs owl-loaction position-relative">
                     @if($county && $county->count())
                        @foreach($county->chunk(2) as $group)
                           <div class="item">
                                 @foreach($group as $c)
                                    <div class="loc_box">
                                       <a class="town" href="{{ route('school.search') }}?city={{ $c->name }}">
                                             <h2>{{ $c->name }}<span>({{ $c->schools_count ?? 0 }})</span></h2>
                                             <img src="{{ asset('images/chevrone.png') }}" alt="">
                                       </a>
                                       {{-- <a href="javascript:;" class="town" data-town="{{ $c->id }}">
                                             <h2>{{ $c->name }}<span>({{ $c->schools_count ?? 0 }})</span></h2>
                                             <img src="{{ asset('images/chevrone.png') }}" alt="">
                                       </a> --}}
                                    </div>
                                 @endforeach
                           </div>
                        @endforeach
                     @endif
                  </div>
               </div>
            </div>
         </div>

         <!-- <div class="loactin_btns">
            <div class="btns_loc">
               <a href="{{ route('school.search') }}">Explore all Location <img src="{{ asset('images/arrow-up-right.png') }}" alt=""> </a>
            </div>
         </div> -->


      </section>

      @if(@$advertise)
      <section class="adv_sec mt-0">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="ad_box">
                     <a href="{{ @$advertise->advertise_url }}" target="_blank">
                        <div class="ad_imgs">
                           @if(@$advertise->image != null)
                           <img src="{{ URL::to('storage/app/public/images/advertise_image') }}/{{ @$advertise->image }}" alt="">
                           @endif
                        </div>
                        <div class="ad_text">
                            <h2>{{ @$advertise->heading }}</h2> 
                           <p>{{ @$advertise->description }}</p>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      @endif



      @if($news_articles->isNotEmpty())
      <section class="featured_news">
         <div class="container">
            <div class="row">
               <div class="section_header">
                  <h2>Featured News</h2>
                  <p>Get all the latest news and updates on matters education</p>
               </div>

               <div class="featured-news-inr">
                  <div class="owl-carousel owl_produs owl-theme owl_produs owl-news position-relative">
                     @foreach($news_articles as $news_article) 
                     <div class="item">
                        <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> {{$news_article->published_at?date('d',strtotime($news_article->published_at)):'' }} <span>{{ $news_article->published_at?date('M',strtotime($news_article->published_at)):'' }}</span></p> </div> 
                              <a href="{{ route('news.details',$news_article->slug) }}"> 
                                 @if($news_article->cover_image != null)
                                    {{-- <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ $news_article->cover_image }}" alt=""> --}}
                                 @else
                                    <img src="{{ asset('storage/default_images/default.jpg') }}" alt="">
                                 @endif
                              </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ asset('images/user.png') }}" alt="">
                                    <p>Posted by, <span>
                                       @if(@$newsData->posted_by == 'U')
                                          {{ @$newsData->getUser->first_name.' '.@$newsData->getUser->last_name }}
                                       @else
                                          Admin
                                       @endif
                                    </span></p>
                                 </div>
                                 <h2> <a href="{{ route('news.details',$news_article->slug) }}">
                                 @if(strlen($news_article->title)>100)
                                    {{ substr($news_article->title,0,100) }}
                                 @else
                                    {{ @$news_article->title }}
                                 @endif
                                 </a> </h2>

                                 <div class="read_more_b">
                                    <a href="{{ route('news.details',$news_article->slug) }}">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </section>
      @endif

      <!-- <section class="adv2">
         <div class="container">
            <div class="row">
               <div class="col-sm-6">
                  <div class="adv_n">
                     <a href="#"> <img src="{{ url('public/images/adv1.png') }}" alt=""> </a>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="adv_n">
                     <a href="#"> <img src="{{ url('public/images/adv2.png') }}" alt=""> </a>
                  </div>
               </div>
            </div>
         </div>
      </section> -->

      {{--<section class="featured_testimonials">
         <div class="container">
            <div class="row">
               <div class="section_header">
                  <h2>Testimonials</h2>
               </div>

               <div class="featured-testim-inr">
                  <div class="owl-carousel owl_produs owl-theme owl_produs owl-testimonials position-relative">
                     <div class="item">
                        <div class="testimonails_box">
                           <div class="para_tes">
                              <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demon trate the visual form of a document or a type face without relying on meaningful content. Lorem ipsum as a placeholder.</p>
                           </div>

                           <div class="tsti_user">
                              <div class="user-tes">
                                 <img src="{{ url('public/images/test1.png') }}" alt="">
                                 <h3>Ludianyanim Hore <span>Kisumu</span> </h3>
                              </div>
                              <img src="{{ url('public/images/quote.png') }}" alt="" class="qute_img">

                           </div>


                        </div>
                     </div>

                     <div class="item">
                        <div class="testimonails_box">
                           <div class="para_tes">
                              <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demon trate the visual form of a document or a type face without relying on meaningful content. Lorem ipsum as a placeholder.</p>
                           </div>

                           <div class="tsti_user">
                              <div class="user-tes">
                                 <img src="{{ url('public/images/test2.png') }}" alt="">
                                 <h3>Dianaisaly Marionaul <span>Kakamega</span> </h3>
                              </div>
                              <img src="{{ url('public/images/quote.png') }}" alt="" class="qute_img">

                           </div>


                        </div>
                     </div>

                     <div class="item">
                        <div class="testimonails_box">
                           <div class="para_tes">
                              <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demon trate the visual form of a document or a type face without relying on meaningful content. Lorem ipsum as a placeholder.</p>
                           </div>

                           <div class="tsti_user">
                              <div class="user-tes">
                                 <img src="{{ url('public/images/test3.png') }}" alt="">
                                 <h3>Wanjiku Ndungu <span>Moyale </span> </h3>
                              </div>
                              <img src="{{ url('public/images/quote.png') }}" alt="" class="qute_img">

                           </div>


                        </div>
                     </div>
               </div>
            </div>
         </div>
      </section>--}}
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script>
   $(document).ready(function(){

       $('.school_board').click(function(){

           let board = $(this).data('school_board');
           $('#schoolBoard').val(board);
           $('#searchSchoolBoard').submit();
       })
   })
</script>
<script>
   $(document).ready(function(){

       $('.town').click(function(){

           let town = $(this).data('town');
           $('#schoolTown').val(town);
           $('#searchSchoolBoard').submit();
       })
   })
</script>
@endsection
