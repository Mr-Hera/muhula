<header @if(Route::is('add.school.step1','add.school.step2','add.school.step3','add.school.step4','add.school.step5','add.school.step6')) class="w-shadow" @elseif(Route::is('school.details')) class="login-header"  @endif @auth class="login-header" @endauth>
         <div class="container-fluid top-container">
            <nav class="navbar navbar-expand-lg">
               <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarNav">
                  <form action="{{ route('school.search') }}" method="post" id="schoolTypeForm">
                     @csrf
                     <input type="hidden" name="school_type[]" id="schoolType">
                  </form>
                  <ul class="navbar-nav post_link">
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                     </li>
                     {{-- @php
                     $school_typee = App\Models\SchoolType::orderBy('id','asc')->get();
                     @endphp
                     @if(@$school_typee)
                     @foreach($school_typee as $type)
                     <li class="nav-item">
                        <a class="nav-link school_type" href="javascript:;" data-school_type="{{ @$type->id }}">{{ @$type->school_type }}</a>
                     </li>
                     @endforeach
                     @endif --}}
                     @foreach($school_levels as $level)
                        <li class="nav-item">
                           <a class="nav-link" href="{{ route('school.search') }}?school_type={{ $level->id }}">
                                 {{ $level->name }}
                           </a>
                        </li>
                     @endforeach
                     {{--<li class="nav-item">
                        <a class="nav-link" href="#">primary</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">secondary</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">Colleges</a>
                     </li>--}}
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('about.us') }}">about Us</a>
                     </li>
                   
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('add.school.step2') }}">List your School</a>
                     </li>                
                     
                  </ul>
                  @guest
                  <ul class="navbar-nav">
                     <span class="nav-line"></span>
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.register') }}"><img src="{{ asset('images/hdr-user.png') }}" alt="">Sign Up</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link nav-log" href="{{ route('login') }}"><img src="{{ asset('images/hdr-login.png') }}" alt="">Login</a>
                     </li>
                  </ul>
                  @endguest
               </div>
               @auth
               <div class="logged-nav-r8 position-relative">
                  <div class="loggd-nv-btn d-flex justify-content-start align-items-center">
                     <em class="d-flex justify-content-center align-items-center">
                        @if(Auth::user()->profile_pic != null)
                           <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ @Auth::user()->profile_pic }}" alt="" class="img-fit">
                        @else
                           <img src="{{ asset('images/avatar.png') }}" alt="" class="img-fit">
                        @endif
                      </em>
                     <h4>Hi, {{ @Auth::user()->first_name }}</h4>
                  </div>
                  <div class="loggd-nv-list" style="display: none;">
                     <ul>
                        <li> <a href="{{ route('user.dashboard') }}">Dashboard</a> </li>
                        <li><a href="{{ route('user.profile') }}">Edit Profile</a></li>
                        <li><a href="{{ route('user.my.school') }}">My School</a></li>
                        <li><a href="{{ route('user.my.favourite') }}">My Favourite</a></li>
                        <li><a href="{{ route('user.add.news') }}">Add News</a></li>
                        <li><a href="{{ route('user.my.review.by.me') }}">My Reviews</a></li>
                        <li><a href="{{ route('user.message.list') }}">Messages</a></li>
                        <li><a href="{{ route('school.search') }}">Claim School</a></li>
                        <li><a href="{{ route('user.subscription') }}">Subscription</a></li>
                        <li><a href="{{ route('user.subscription.history') }}">Subscription History</a></li>
                        <span class="list-dvdr"></span>
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                     </ul>
                  </div>
               </div>
               @endauth
            </nav>
         </div>
      </header>
      <div class="banner-padding"></div>

<!-- header section end -->
