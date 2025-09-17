@extends('layouts.app')
@section('title','My Reviews')
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
                     <h3>My Reviews</h3>
                     <p>See all your reviews here.</p>
                  </div>
                  
                  <div class="my_review_btn2">
                  	<a href="{{ route('user.my.review.by.me') }}" class="">Posted By me</a>
                    <a href="{{ route('user.my.review.by.school') }}" class="rev_active">Posted For My School</a>
                  </div>
                  
                  <div class="dashboard_box ex_mtop">
                  @include('includes.message')
                     <!---->
                     @if($reviews->isNotEmpty())
                     @foreach($reviews as $data)
                     <div class="review_boxxs">
                     <div class="posted_by_and_date">
                     	<div class="posted_by">
                        	<span>
                                @if($user->profile_image != null)
                                    <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ $data->getUser->profile_pic }}" alt="">
                                @else
                                    <img src="{{ asset('images/avatar.png') }}" alt="">
                                @endif
                            </span>
                            <div>
                                <h5>{{ $user->first_name.' '.$user->last_name }}
                                    @if($data->status != 'D')  
                                        <a href="javascript:;" class="replyBtn" data-reply="{{ $data->review_reply_by_ownner }}" data-review_id="{{ $data->id }}"> <img src="{{ asset('images/repeat.png') }}">Reply</a>
                                    @endif
                                 </h5>
                                 <div class="clearfix"></div>
                                 {{-- <p>
                                     @if($data->designation == 'CS')
                                     Current Student
                                     @elseif($data->designation == 'E')
                                     Employer
                                     @elseif($data->designation == 'G')
                                     General
                                     @endif
                                 </p> --}}
                             </div>

                           
                        </div>
                        <div class="posted_date">
                            @if($data->is_featured == 0 && $data->status != 'D')
                                <a href="{{ route('user.featured.review',$data->id) }}" class="mk-ftrd" onclick="return confirm('Do you want to add this as Featured review?')">Make Featured</a>
                            @elseif($data->is_featured == 1 && $data->status != 'D')
                                <a href="{{ route('user.featured.review',$data->id) }}" class="mk-ftrd" onclick="return confirm('Do you want to remove this from Featured review?')">Remove Featured</a>
                            @endif
                        	<div class="star_rrv flex flex-col space-y-1">
                                {{-- ⭐ School’s average rating --}}
                                <div class="flex items-center space-x-2">
                                    @php
                                        $avg = round($data->school->reviews_avg_rating, 1); // e.g. 3.7
                                        $fullStars = floor($avg);
                                        $halfStar = ($avg - $fullStars) >= 0.5;
                                    @endphp

                                    {{-- Full stars --}}
                                    @for($i = 1; $i <= $fullStars; $i++)
                                        <span><img src="{{ asset('images/star.png') }}" alt="★" class="w-4 h-4 inline-block"></span>
                                    @endfor

                                    {{-- Half star --}}
                                    @if($halfStar)
                                        <span><img src="{{ asset('images/star-half.png') }}" alt="☆" class="w-4 h-4 inline-block"></span>
                                        @php $fullStars++; @endphp
                                    @endif

                                    {{-- Empty stars --}}
                                    @for($i = $fullStars + 1; $i <= 5; $i++)
                                        <span><img src="{{ asset('images/star1.png') }}" alt="☆" class="w-4 h-4 inline-block"></span>
                                    @endfor
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <p><img src="{{ asset('images/clock.png') }}" alt=""> {{ date('jS M, Y H:i',strtotime($data->created_at)) }}</p>
                        </div>
                     </div>
                     	<p>{{ $data->review_text }}</p>
                        @if($data->review_reply_by_admin != null)
                             <div class="reply_boxes_i">
                                <h6>Reply By Admin:</h6>
                                <p>{{ $data->review_reply_by_admin }}</p>
                            </div>
                            @endif
                            @if($data->review_reply_by_ownner != null)
                                <div class="reply_boxes_i">
                                    <h6>Reply by you:</h6>
                                    <p>{{ $data->review_reply_by_ownner }}</p>
                                </div>
                            @endif
                     </div>
                     @endforeach
                     @else
                     <h3><center>No Data Found</center></h3>
                     @endif
                     <!---->
                 
                    <div class="pagination_box">
                        {{-- {{@$reviewData->appends(request()->except(['page', '_token']))->links('pagination')}} --}}
                    </div>
                     
                  </div>
                  
               </div>
            </div>
         </div>
      </section>

      <div class="modal" id="reviewReplyModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h4 class="modal-title">Review Reply</h4>
                <button type="button" class="btn-close close-crop" data-bs-dismiss="modal"></button>
            </div>
            <form id="replyForm" class="edit-frm-inr" method="POST" action="{{ route('user.review.reply') }}">
                @csrf
                <input type="hidden" name="review_id" id="review_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                        <div class="dash_input">
                           <label>Review Reply</label>
                           <textarea placeholder="Write your reply" name="review_reply_by_ownner" id="review_reply_by_ownner"></textarea>
                        </div>
                            
                        </div>
                        <div class="col-12">
                        <button class="save_btns mt-0">Submit<img src="{{ asset('images/arrow-righr.png') }}" alt=""> </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script>
   $(document).ready(function(){

        $('#replyForm').validate({

             rules: {

               review_reply_by_ownner: {

                    required: true,
               },
             },
             submitHandler: function(form){

                 form.submit();
             }
        })


        $('.replyBtn').click(function(){

             let review_id = $(this).data('review_id');
             let reply = $(this).data('reply');
             $('#review_id').val(review_id);
             $('#review_reply_by_ownner').text(reply);
             $('#reviewReplyModal').modal('show');
        })
   })
</script>
@endsection      