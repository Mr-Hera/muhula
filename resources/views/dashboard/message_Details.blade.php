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
                      <input type="hidden" name="to_user_id" id="" value="{{ @$message->from_user_id }}">
                      <input type="hidden" name="message_id" id="" value="{{ @$message->id }}"> 
                      <input type="hidden" name="school_id" id="" value="{{ @$message->school_id }}"> 
                     <div class="message_details_reply">
                        <div class="dash_input">
                           <label>Reply</label>
                           <textarea placeholder="Write your reply" name="message"></textarea>
                        </div>
                        <button class="save_btns mt-0" type="submit">Send Message <img src="{{ url('public/images/click_s.png') }}" alt="" class="ml-2"> </button>
                     </div>
                    </form>
                  </div>
                  

                  <div class="dashboard_box mt-4">
                  
                     <div class="message_details_all">
                         @if(@$allMessage->isNotEmpty())
                         @foreach($allMessage as $data)
                         @if(@$data->from_user_id != Auth::user()->id)
                        <div class="message-list-box">
                           <div class="message_owner">
                              <div class="measge_name">
                              @if(@$data->getUser->profile_pic != null)
                              <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @$data->getUser->profile_pic }}" alt="">
                              @else
                              <img src="{{ url('public/images/avatar.png') }}" alt="">
                               @endif
                                 <h3>{{ @$data->getUser->first_name.' '.@$data->getUser->last_name }}</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="{{ url('public/images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime(@$data->date)) }}, {{ date('h:i A',strtotime(@$data->date)) }}</p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>{{ @$data->message }} </p>
                              </div>
                        </div>
                        @else
                        <div class="message-list-box">
                           <div class="message_owner">
                              <div class="measge_name">
                              @if(Auth::user()->profile_pic != null)
                              <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @Auth::user()->profile_pic }}" alt="">
                              @else
                              <img src="{{ url('public/images/avatar.png') }}" alt="">
                               @endif
                                 <h3>You</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="{{ url('public/images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime(@$data->date)) }}, {{ date('h:i A',strtotime(@$data->date)) }}</p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>{{ @$data->message }} </p>
                              </div>
                        </div>
                        @endif
                         @endforeach
                         @endif  
                        {{--<div class="message-list-box">
                           <div class="message_owner">
                              <div class="measge_name">
                                    <img src="images/mess3.png" alt="">
                                    <h3>Jack Nicholson</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="images/clock.png" alt="">24/01/2024, 11.10 AM </p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                              <div class="attachment_box">
                                 <a href="#"> <img src="images/paperclip.png" alt="">Dummy file name.jpg </a>
                              </div>
                        </div>

                        <div class="message-list-box read_message">
                           <div class="message_owner">
                              <div class="measge_name">
                                <img src="images/mess1.png" alt="">
                                 <h3>You</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="images/clock.png" alt="">20/01/2024, 11.10 AM</p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. </p>
                              </div>
                        </div>

                        <div class="message-list-box">
                           <div class="message_owner">
                              <div class="measge_name">
                                    <img src="images/mess3.png" alt="">
                                    <h3>Jack Nicholson</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="images/clock.png" alt="">24/01/2024, 11.10 AM </p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                              <div class="attachment_box">
                                 <a href="#"> <img src="images/paperclip.png" alt="">Dummy file name.jpg </a>
                              </div>
                        </div>

                        <div class="message-list-box read_message">
                           <div class="message_owner">
                              <div class="measge_name">
                                <img src="images/mess1.png" alt="">
                                 <h3>You</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="images/clock.png" alt="">20/01/2024, 11.10 AM</p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. </p>
                              </div>
                        </div>

                        <div class="message-list-box">
                           <div class="message_owner">
                              <div class="measge_name">
                                    <img src="images/mess3.png" alt="">
                                    <h3>Jack Nicholson</h3>
                              </div>
                              <div class="message_date">
                                 <p> <img src="images/clock.png" alt="">24/01/2024, 11.10 AM </p>
                              </div>
                           </div>
                              <div class="message_body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                              <div class="attachment_box">
                                 <a href="#"> <img src="images/paperclip.png" alt="">Dummy file name.jpg </a>
                              </div>
                        </div>--}}


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