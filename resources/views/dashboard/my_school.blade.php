@extends('layouts.app')
@section('title','Manage School(s)')
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
                     <h3>My School</h3>
                     <p>Here You can view your Claimed school(s)</p>
                  </div>
                  <div class="dashboard_box">
                  @include('includes.message')
                     @if($claimedSchools->isNotEmpty())
                        @foreach($claimedSchools as $school)
                           <div class="message-list-box school-list">
                              <div class="message_owner">
                                 <div class="measge_name">
                                    <a href="{{ route('school.details',$school->slug) }}">
                                       @php
                                          // Normalize the file path (prepend 'public/' since files are stored in storage/app/public)
                                          $logoPath = $school->logo ? 'public/' . ltrim($school->logo, '/') : null;

                                          // Check if logo exists in storage, otherwise use default image
                                          $finalPath = ($logoPath && Storage::exists($logoPath))
                                             ? $logoPath
                                             : 'public/default_images/default.jpg';

                                          // Generate a public URL for display
                                          $imageUrl = Storage::url($finalPath);
                                       @endphp

                                       <img src="{{ $imageUrl }}" alt="{{ $school->name ?? 'School Logo' }}">
                                       <h3>{{ $school->name }}</h3>
                                    </a>
                                 </div>
                                 <div class="message_date d-blocks">
                                    <a class="mx-2" href="{{ route('user.edit.school',$school->id) }}">Edit</a>
                                    <form action="{{ route('user.delete.school', $school->id) }}"
                                          method="POST"
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Are you sure you want to permanently delete this school? This action cannot be undone.');">
                                       @csrf
                                       @method('DELETE')

                                       <button type="submit" class="py-1 btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                    <p><img src="{{ asset('images/clock.png') }}" alt="">{{ date('jS M, Y H:i',strtotime($school->created_at)) }}</p>
                                 </div>
                              </div>
                              <div class="nature_s">
                                 @if($school->type)
                                    <h6>{{ $school->type->name }}</h6>
                                 @else
                                    <h6>Not Defined</h6>
                                 @endif
                              </div>
                              <div class="sc_thub_ab">
                                    @if($school->year_of_establishment != null)
                                    <p class="text-capital">Year of establishment @if($school->year_of_establishment != null) ({{ $school->year_of_establishment }}) @endif</p>
                                    <span class="no-marmin">|</span>
                                    @endif
                                    <p>
                                       Education System:
                                       {{-- @if($school->school_boards)
                                          @foreach($school->school_boards as $key=>$schoolboard)
                                             {{ @$key > 0?',':'' }} {{ $schoolboard->board_name }}
                                          @endforeach
                                       @endif --}}
                                       {{ optional($school->curriculum)->name ?? 'Not Defined' }}
                                    </p>
                                    <span class="no-marmin">|</span>
                                    <p>
                                       @if($school->boarding_type == 'D')
                                       Day
                                       @elseif($school->boarding_type == 'B')
                                       Boading
                                       @elseif($school->boarding_type == 'DB')
                                       Day & Boading
                                       @endif
                                    </p>
                                 </div>
                                 <div class="message_body">
                                    <p>{{ $school->description }}</p>
                                 </div>
                           </div>
                        @endforeach
                     @else
                        <h3><center>No Data Found</center></h3>
                     @endif


                  {{-- <div class="dashboard_pagination">
                     <div class="pagination_box">
                        {{$claimedSchools->appends(request()->except(['page', '_token']))->links('pagination')}}
                     </div>
                  </div> --}}

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
