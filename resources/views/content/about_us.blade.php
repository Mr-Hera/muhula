@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<div class="inner-banner position-relative">
         <img src="{{asset('images/about-bg.png')}}" alt="" class="inner-banner-bg position-absolute">
         <div class="container">
            <div class="inner-banner-txt">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb inner-brdcrmb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About</li>
                  </ol>
               </nav>
               <h1>About Us</h1>
            </div>
         </div>
      </div>

      <section class="about-1 position-relative">
        <span class="abt-sec1-bg position-absolute">
            <img src="{{asset('images/abt-sec1-bg.png.png')}}" alt="" class="img-fit">
        </span>
         <div class="about-deets-sec">
            <div class="container">
               <div class="row align-items-stretch">
                  <div class="col-lg-3">
                     <div class="abt-deet-imgs h-100">
                        <div class="row align-items-stretch h-100">
                           <!-- <div class="col-sm-6 col-6">
                              <em><img src="{{ url('public/images/abt-dt1.png') }}" alt="" class="img-fit"></em>
                           </div>
                           <div class="col-sm-6 col-6">
                              <em><img src="{{ url('public/images/abt-dt2.png') }}" alt="" class="img-fit"></em>
                           </div> -->
                            <div class="col-12">
                                <em>
                                    <img src="{{asset('images/abt-dt1.png')}}" alt="" class="img-fit">
                                </em>
                            </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-9">
                     <div class="abt-deet-txt">
                        <!-- <h3>Simply dummy heading caption/heading text for about Muhula</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown</p>
                        <a href="{{ route('user.register') }}">Get Started
                           <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg>                              
                        </a> -->
                        <h4>MUHULA</h4>
                        <p>Muhula simplifies the search and access to information about learning institutions and education partners for parents and students, regardless of their educational journey. It also allows for authentic reviews that helps improve decision making when it comes to education.</p>
                        <h4>For learning institutions</h4>
                        <p>We give you a place to shape and share the learning experiences and requirements at your institution. Post what makes you standout,  respond to reviews, and gain insights to shape your messaging.</p>
                        <h4>For Parents & learners</h4>
                        <p>We simplify your search, so you can choose the right learning institution with confidence. Filter millions of options and ratings, talk to professionals, and make smart about your eduation—then apply with ease. Leave reviews, search  and join candid conversations about your learning institution.</p>
                        <h4>For education partners</h4>
                        <p>We amplify your voice, so you can be visible to a captive audience that needs the services  or products you offer. enhance the learning experience at your learning institution. Respond and Leave reviews, post & sale your product/service, to a captive audience.</p>
                        <h4>Reviews</h4>
                        <p>To post a review, each person must be registered and choose under one of the categories Learning institution, Parent, student/alumni or education partner that they would like to comment as.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="about-why-sec">
            <div class="container">
               <h2>Why Choose Muhula</h2>
               <div class="abt-why-inr position-relative">
                  <div class="row align-items-stretch">
                     <div class="col-lg-4 col-md-4">
                        <div class="abt-why-bx position-relative">
                           <span class="whybx-num d-flex justify-content-center align-items-center">1</span>
                           <div class="why-bx-txt d-flex">
                                <img src="{{asset('images/why-1.png')}}" alt="" >
                                <div class="why-mn-txt">
                                    <h3>Register on Muhula.com</h3>
                                    <p>Register your school on muhula.com and let prospective learners know more about your school and communicate important information, such as your programs, mission, and history.</p>
                                </div>
                           </div>
                           <img src="{{asset('images/why-dots.png')}}" alt="" class="why-dots position-absolute">
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4">
                        <div class="abt-why-bx position-relative">
                           <span class="whybx-num d-flex justify-content-center align-items-center">2</span>
                           <div class="why-bx-txt d-flex">
                                <img src="{{asset('images/why-2.png')}}" alt="" >
                                <div class="why-mn-txt">
                                    <h3>Search & Choose School</h3>
                                    <p>On muhula.com you can find school(s) that are best suited to your learning needs. Explore common considerations, including costs, facilities, courses, and student resources and services.</p>
                                </div>
                           </div>
                           <img src="{{asset('images/why-dots.png')}}" alt="" class="why-dots position-absolute">
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-4">
                        <div class="abt-why-bx abt-why-last position-relative">
                           <span class="whybx-num d-flex justify-content-center align-items-center">3</span>
                           <div class="why-bx-txt d-flex">
                                <img src="{{asset('images/why-3.png')}}" alt="" >
                                <div class="why-mn-txt">
                                    <h3>Claim School & reply to reviews</h3>
                                    <p>You can claim and manage your school on  muhula.com by sharing up to date information. Our reviews on Muhula.com are community driven and help learners gain better understanding of your institution.</p>
                                </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- <section class="abt-counter">
         <div class="container">
            <div class="abt-countr-paper">
               <div class="abt-cntr-mn">
                  <h4 class="counter" data-target="1500"></h4>
                  <p>Satisfied Clients</p>
               </div>
               <div class="abt-cntr-txtsc">
                  <img src="{{ url('public/images/abt-cntr-img.png') }}" alt="" class="d-block">
                  <div class="cntr-dttxt">
                     <h3>Looking for a School, Get It</h3>
                     <p>About this listing Lorem ipsum dolor simply amet, consectetuer adipiscing this is a simplt dummy text here...</p>
                  </div>
                  <a href="{{ route('user.register') }}">Get Started
                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3360_265)">
                        <path d="M-2.5 10H14.1667" stroke="#414750" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 4.16699L15.8333 10.0003L10 15.8337" stroke="#414750" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                     </svg>                        
                  </a>
               </div>
            </div>
         </div>
      </section> -->

      <!-- <section class="mis-vis position-relative">
         <span class="mis-top-graph position-absolute">
            <svg width="859" height="76" viewBox="0 0 859 76" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M61 76H795H859L795 0H61L0 76H61Z" fill="#F0FCF0"/>
            </svg>               
         </span>
         <span class="mis-vis-icon position-absolute"><img src="images/mis-vis-icon.png" alt="" class="img-fit"></span>
         <div class="misvis-main">
            <div class="container">
               <div class="misvis-hd">
                  <h3>Creating world class experiences</h3>
                  <p>Lorem ipsum dolor sit amet, lorem ipsum dolor sit amet, consecteturconsectetur</p>
               </div>
               <div class="row justify-content-center align-items-stretch">
                  <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                     <div class="mis-box">
                        <img src="{{ url('public/images/mis1.png') }}" alt="">
                        <h4>Our Vision</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing sed do eiusmod tempor incidid unt labore dolore ing elit, sed eiusmod tempor the Lorem dolor sit amet.</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                     <div class="mis-box">
                        <img src="{{ url('public/images/mis2.png') }}" alt="">
                        <h4>Our Mission</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing sed do eiusmod tempor incidid unt labore dolore ing elit, sed eiusmod tempor the Lorem dolor sit amet.</p>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                     <div class="mis-box">
                        <img src="{{ url('public/images/mis3.png') }}" alt="">
                        <h4>Our Goals</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing sed do eiusmod tempor incidid unt labore dolore ing elit, sed eiusmod tempor the Lorem dolor sit amet.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section> -->

@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script>
  $(document).ready(function(){ 

$('.readMore').click(function(){
    $(this).parent().parent().find('.completeDesc').css('display',"block");
    $(this).parent().css('display',"none");
}); 

$('.readLess').click(function(){
    $(this).parent().parent().find('.descc').css('display',"block");
    $(this).parent().css('display',"none");
}); 
});
</script>
@endsection
