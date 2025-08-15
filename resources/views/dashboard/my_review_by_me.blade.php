@extends('layouts.app')
@section('title','My Reviews')
@section('links')
@include('includes.links')
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
                     <h3>My Reviews</h3>
                     <p>See all your reviews here.</p>
                  </div>
                  
                  <div class="my_review_btn2">
                  	<a href="{{ route('user.my.review.by.me') }}" class="rev_active">Posted By me</a>
                     <a href="{{ route('user.my.review.by.school') }}" class="">Posted For My School</a>
                  </div>
                  
                  <div class="dashboard_box ex_mtop">
                     
                     <!---->
                     @if($reviews->isNotEmpty())
                     @foreach($reviews as $review)
                     <div class="review_boxxs">
                     <div class="posted_by_and_date">
                     	<div class="posted_by">
                        	<span class="float-none">
                              @if($review->school->logo != null)
                                 <img src="{{ URL::to('storage/app/public/images/school_logo') }}/{{ $review->school->logo }}" alt="">
                              @else
                                 {{-- <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ $review->getSchool->getSchoolMainImage->image }}" alt=""> --}}
                                 <img src="{{ asset('storage/default_images/default.jpg') }}" alt="">
                              @endif
                           </span>
                              <div>
                                <h5 class="float-none">{{ $review->school->name }}</h5>
                                <p>{{ $review->school->address_text }}</p>
                              </div>
                        </div>
                        <div class="posted_date">
                        	<div class="star_rrv">
                              @for($i=1;$i<=$review->review_point;$i++)
                                 <span><img src="{{ asset('images/star.png') }}" alt=""></span>
                              @endfor
                              @for($j=$review->review_point+1;$j<=5;$j++)
                                 <span><img src="{{ asset('images/star1.png') }}" alt=""></span>
                              @endfor
                           </div>
                           <div class="clearfix"></div>
                           <p><img src="{{ asset('images/clock.png') }}" alt="">{{ date('jS M, Y H:i',strtotime($review->created_at)) }}</p>
                        </div>
                     </div>
                     	<p>{{ $review->review_text }}</p>
                        @if($review->review_reply_by_admin != null)
                           <div class="reply_boxes_i">
                              <h6>Reply By Admin:</h6>
                              <p>{{ $review->review_reply_by_admin }}</p>
                           </div>
                        @endif
                        @if($review->review_reply_by_ownner != null)
                           <div class="reply_boxes_i">
                              <h6>Reply by ownner:</h6>
                              <p>{{ $review->review_reply_by_ownner }}</p>
                           </div>
                        @endif
                            
                     </div>
                     @endforeach
                     @else
                        <h3><center>No Data Found</center></h3>
                     @endif
                     <!---->

                     <div class="pagination_box">
                     {{-- {{$reviews->appends(request()->except(['page', '_token']))->links('pagination')}} --}}


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
@endsection     