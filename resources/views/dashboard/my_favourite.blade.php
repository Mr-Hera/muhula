@extends('layouts.app')
@section('title','My Favourite')
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
                     <h3>My Favourite Schools</h3>
                     <p>Here You can view your Favourite school(s)</p>
                  </div>
                  <div class="dashboard_box">
                  @include('includes.message')
                     @if($favourites->isNotEmpty())
                        @foreach($favourites as $favourite)
                        <div class="message-list-box school-list">
                           <div class="message_owner">
                              <div class="measge_name">
                                 <a href="{{ route('school.details',$favourite->favouritable->slug) }}"> 
                                    @if($favourite->favouritable->logo != null)
                                       <img src="{{ URL::to('storage/app/public/images/logo') }}/{{ $favourite->favouritable->logo }}" alt="">
                                    @else
                                       {{-- <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ $favourite->favouritable->getSchoolMainImage->image }}" alt=""> --}}
                                       <img src="{{ asset('storage/default_images/default.jpg') }}" alt="">
                                    @endif
                                    <h3>{{ $favourite->favouritable->name }}</h3>
                                 </a>
                              </div>
                              {{--<div class="message_date d-blocks">
                                 <a href="{{ route('user.edit.school',@$favourite->id) }}">Edit</a>
                              <p><img src="{{ url('public/images/clock.png') }}" alt="">{{ date('jS M, Y H:i',strtotime(@$favourite->created_at)) }}</p>
                              </div>--}}
                           </div>
                           <div class="nature_s">
                                 @if($favourite->favouritable->type)
                                    <h6>{{ $favourite->favouritable->type->name }}</h6>
                                 @endif
                              </div>
                           <div class="sc_thub_ab">
                                 @if($favourite->favouritable->year_of_establishment != null)
                                    <p class="text-capital">Year of establishment @if($favourite->favouritable->year_of_establishment != null) ({{ $favourite->favouritable->year_of_establishment }}) @endif</p>
                                    <span class="no-marmin">|</span>
                                 @endif
                                 <p>Education System: 
                                    {{-- @if($favourite->favouritable->school_boards)
                                       @foreach(@$favourite->favouritable->school_boards as $key=>$schoolboard)
                                       {{ $key > 0?',':'' }} {{ $schoolboard->board_name }}
                                       @endforeach
                                    @endif --}}
                                    {{ optional($favourite->favouritable->curriculum)->name ?? 'Not Defined' }}
                                 </p>
                                 <span class="no-marmin">|</span>
                                 <p>
                                 @if($favourite->favouritable->boarding_type == 'D')
                                 Day
                                 @elseif($favourite->favouritable->boarding_type == 'B')
                                 Boading
                                 @elseif($favourite->favouritable->boarding_type == 'DB')
                                 Day & Boading
                                 @endif
                                 </p>
                              </div>
                              <div class="message_body">
                                 <p>{{ $favourite->favouritable->description }}</p>
                              </div>
                        </div>
                        @endforeach
                     @else
                     <h3><center>No Data Found</center></h3>
                     @endif

                  
                     <div class="dashboard_pagination">
                        <div class="pagination_box">
                        {{-- {{@$favouriteSchool->appends(request()->except(['page', '_token']))->links('pagination')}} --}}


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