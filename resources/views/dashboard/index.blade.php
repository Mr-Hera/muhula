@extends('layouts.app')
@section('title','Dashboard')
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
                     <h3>Dashboard</h3>
                     <p>Welcome to your muhula dashboard.</p>
                  </div>
                  <div class="dashboard_box">
                     <div class="dashbord_fild">
                        <h3>Hi,{{ Auth::user()->first_name }} </h3>
                     </div>

                     <div class="dashboard_statistic">
                        <div class="row">
                           <div class="col-md-4 col-sm-6">
                              <a href="{{ route('user.message.list') }}" class="static_box">
                                 <span>
                                    <img src="{{ asset('images/mail.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h4>Unread Messages</h4>
                                    <p>{{ $unread_messages ?? "No Messages yet" }}</p>
                                 </div>
                               </a>
                           </div>

                           {{-- <div class="col-md-4 col-sm-6">
                              <a href="{{ route('user.subscription') }}" class="static_box">
                                 <span>
                                    <img src="{{ asset('images/calendar.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h4>Subscription Expiry on</h4>
                                    <p>{{ Auth::user()->subscription_expire_date?date('d.m.Y',strtotime(Auth::user()->subscription_expire_date)):'' }}</p>
                                 </div>
                                </a>
                           </div> --}}

                           <div class="col-md-4 col-sm-6">
                              <a href="{{ route('user.my.review.by.school') }}" class="static_box">
                                 <span>
                                    <img src="{{ asset('images/thumbs-up.png') }}" alt="">
                                 </span>
                                 <div>
                                    <h4>Reviews Received </h4>
                                    <p>{{ $total_reviews ?? "No reviews yet" }}</p>
                                 </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-sm-6">
                              <a href="{{ route('user.my.school') }}" class="static_box">
                                 <span>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.5 9H9C9.79565 9 10.5587 9.31607 11.1213 9.87868C11.6839 10.4413 12 11.2044 12 12V22.5C12 21.9033 11.7629 21.331 11.341 20.909C10.919 20.4871 10.3467 20.25 9.75 20.25H4.5V9Z" stroke="#30333F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19.5 9H15C14.2044 9 13.4413 9.31607 12.8787 9.87868C12.3161 10.4413 12 11.2044 12 12V22.5C12 21.9033 12.2371 21.331 12.659 20.909C13.081 20.4871 13.6533 20.25 14.25 20.25H19.5V9Z" stroke="#30333F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 6.5L12.3462 2L21 6.5" stroke="#30333F" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                 </span>
                                 <div>
                                    <h4>Total Schools </h4>
                                    <p>{{ $total_school }}</p>
                                 </div>
                              </a>
                            </div>
                        </div>
                     </div>
                    {{-- @if(@$recentNews->isNotEmpty()) 
                        <div class="new_list_dash">
                            <div class="new_list_dash_headings">
                            <h3>Recently posted news</h3>
                            </div>
                            @foreach($recentNews as $data)
                                <div class="dash_news_list_box">
                                <div class="dash_news_info">
                                    <a href="{{ route('news.details',@$data->slug) }}">
                                        <span>
                                        @if(@$data->image != null)
                                            <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ @$data->image }}" alt="">
                                            @endif
                                        </span>
                                        <div>
                                            <h3>{{ @$data->news_title }}</h3>
                                            <p> <img src="{{ asset('images/gclock.png') }}"> Posted on : {{ date('jS M, Y',strtotime(@$data->created_at)) }}</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="dash_news_action">
                                    <a href="{{ route('user.create.news',[@$data->school_id,@$data->id]) }}">  
                                        <img src="{{ asset('images/bedit.png') }}" alt="" class="hovern">
                                        <img src="{{ asset('images/bedit2.png') }}" alt="" class="hoverb">
                                    </a>
                                    <a href="{{ route('user.news.delete',@$data->id) }}" onclick="return confirm('Do you want to delete this news?')">  
                                        <img src="{{ asset('images/bdelete.png') }}" alt="" class="hovern">
                                        <img src="{{ asset('images/bdelete1.png') }}" alt="" class="hoverb">
                                    </a>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    @endif --}}
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