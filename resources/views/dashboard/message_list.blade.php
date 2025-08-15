@extends('layouts.app')
@section('title','Messages')
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
                     <h3>My Messages</h3>
                     <p>See all your messages here.</p>
                  </div>
                  <div class="dashboard_box">
                  @if(@$messages->isNotEmpty())
                  <?php $sub_array = []; ?>
                     @foreach($messages as $data)
                     @if(!in_array(@$data->from_user_id, $sub_array))
                     <div class="message-list-box">
                        <div class="message_owner">
                           <div class="measge_name">
                              <a href="{{ route('user.message.detail',[@$data->id]) }}">
                              @if(@$data->getUser->profile_pic != null)
                              <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @$data->getUser->profile_pic }}" alt="">
                              @else
                              <img src="{{ url('public/images/avatar.png') }}" alt="">
                               @endif
                                 <h3>{{ @$data->getUser->first_name.' '.@$data->getUser->last_name }}</h3>
                              </a>
                           </div>
                           <div class="message_date">
                              <p> <img src="{{ url('public/images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime(@$data->date)) }}, {{ date('h:i A',strtotime(@$data->date)) }} </p>
                              <a href="{{ route('user.message.detail',[@$data->id]) }}"> <img src="{{ url('public/images/repeat.png') }}"> Reply</a>
                           </div>
                        </div>
                           <div class="message_body">
                              <p>{{ @$data->message }}</p>
                           </div>
                     </div>
                     @endif
                     <?php array_push($sub_array,@$data->from_user_id); ?>
                     @endforeach
                     @else
                     <h3><center>No Data Found</center></h3>
                     @endif

                     <div class="dashboard_pagination">
                        <div class="pagination_box">
                        {{-- {{@$messageData->appends(request()->except(['page', '_token']))->links('pagination')}} --}}


                  </div>
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
