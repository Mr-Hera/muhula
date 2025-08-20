@extends('layouts.app')
@section('title','Message Details')
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
                     <h3>My Messages</h3>
                     <p>See all your messages here.</p>
                  </div>
                  <div class="dashboard_box">
                     @include('includes.message')
                     <form action="{{ route('user.send.message.reply') }}" method="post" id="messageForm">
                        @csrf
                        <input type="hidden" name="to_user_id" id="" value="{{ $message->from_user_id }}">
                        <input type="hidden" name="message_id" id="" value="{{ $message->id }}"> 
                        <input type="hidden" name="school_id" id="" value="{{ $message->school_id }}"> 
                        <div class="message_details_reply">
                           <div class="dash_input">
                              <label>Reply</label>
                              <textarea placeholder="Write your reply" name="message"></textarea>
                           </div>
                           <button class="save_btns mt-0" type="submit">Send Message <img src="{{ asset('images/click_s.png') }}" alt="" class="ml-2"> </button>
                        </div>
                     </form>
                  </div>
                  

                  <div class="dashboard_box mt-4">
                  
                     <div class="message_details_all">
                        @if($allMessages->isNotEmpty())
                           @foreach($allMessages as $data)
                              @if($data->from_user_id != Auth::user()->id)
                                 <div class="message-list-box">
                                    <div class="message_owner">
                                       <div class="measge_name">
                                          @if($data->sender->profile_image != null)
                                             <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ $data->sender->profile_pic }}" alt="">
                                          @else
                                             <img src="{{ asset('images/avatar.png') }}" alt="">
                                          @endif
                                          <h3>{{ $data->sender->first_name.' '.$data->sender->last_name }}</h3>
                                       </div>
                                       <div class="message_date">
                                          <p> <img src="{{ asset('images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime($data->date)) }}, {{ date('h:i A',strtotime($data->date)) }}</p>
                                       </div>
                                    </div>
                                       <div class="message_body">
                                          <p>{{ $data->content }} </p>
                                       </div>
                                 </div>
                              @else
                                 <div class="message-list-box">
                                    <div class="message_owner">
                                       <div class="measge_name">
                                       @if(Auth::user()->profile_pic != null)
                                          <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @Auth::user()->profile_pic }}" alt="">
                                       @else
                                          <img src="{{ asset('images/avatar.png') }}" alt="">
                                       @endif
                                          <h3>You</h3>
                                       </div>
                                       <div class="message_date">
                                          <p> <img src="{{ asset('images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime($data->date)) }}, {{ date('h:i A',strtotime($data->date)) }}</p>
                                       </div>
                                    </div>
                                       <div class="message_body">
                                          <p>{{ $data->message }} </p>
                                          <p>{{ $data->message }} </p>
                                       </div>
                                 </div>
                              @endif
                           @endforeach
                        @endif
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
@endsection      