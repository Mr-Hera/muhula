<div class="dashboard_left_panel">
<div class="dashboard_left_panel_box">
   <div class="lft-panel-list">
      <ul>
         <li>
            <a href="{{ route('user.dashboard') }}" class="{{ Route::is('user.dashboard')?'active' : '' }}"> <span><img src="{{asset('images/dash1.png')}}" alt="" ></span>  Dashboard </a>
         </li>
         <li>
            <a href="{{ route('user.profile') }}" class="{{ Route::is('user.profile')?'active' : '' }}"> <span><img src="{{asset('images/dash2.png')}}" alt="" ></span>  Edit Profile</a>
         </li>
         <li>
            <a href="{{ route('user.my.school') }}" class="{{ Route::is('user.my.school','user.edit.school')?'active' : '' }}"> <span><img src="{{ asset('images/dash3.png') }}" alt=""></span>  My School </a>
         </li>
         <li>
            <a href="{{ route('user.my.favourite') }}" class="{{ Route::is('user.my.favourite')?'active' : '' }}"> <span><img src="{{asset('images/heart.png')}}" alt="" ></span>  My Favourite </a>
         </li>
         <li>
            <a href="{{ route('user.my.review.by.me') }}" class="{{ Route::is('user.my.review.by.me','user.my.review.by.school')?'active' : '' }}"> <span><img src="{{asset('images/dash3.png')}}" alt="" ></span>  My Reviews </a>
         </li>
         <li>
            <a href="{{ route('user.message.list') }}" class="{{ Route::is('user.message.list','user.message.detail')?'active' : '' }}"> <span><img src="{{ asset('images/dash5.png') }}" alt=""></span>  Messages </a>
         </li>
         @auth
            @if(auth()->user()->is_admin)
               <li>
                  <a href="{{ route('user.add.news') }}" class="{{ Route::is('user.add.news', 'user.manage.news')?'active' : '' }}"> <span><img src="{{asset('images/dash3.PNG')}}" alt="" ></span> Manage News </a>
               </li>
            @endif
         @endauth
         <li>
            <a href="{{ route('school.search') }}"> <span><img src="{{asset('images/claim-school.png')}}" alt="" ></span>Claim School </a>
         </li>
         <li>
            <a href="{{ route('admin.users.index') }}" class="{{ Route::is('admin.users.index', 'admin.users.edit')?'active' : '' }}"> <span><img src="{{asset('images/dash4.png')}}" alt="" ></span>  Manage Users</a>
         </li>
         @auth
            @if(auth()->user()->is_admin)
               <li>
                  <a href="{{ route('dashboard.adverts.index') }}" class="{{ Route::is('dashboard.adverts.index','dashboard.manage.adverts')?'active' : '' }}"> <span><img src="{{ asset('images/dash3.png') }}" alt=""></span>Manage Adverts </a>
               </li>
            @endif
         @endauth
         @auth
            @if(auth()->user()->is_admin)
               <li>
                  <a href="{{ route('get.manage.claims') }}"class="{{ Route::is('get.manage.claims')?'active' : '' }}"> <span><img src="{{ asset('images/dash3.png') }}" alt=""></span>Manage Claims </a>
               </li>
            @endif
         @endauth
         {{-- <li>
            <a href="{{ route('user.subscription') }}" class="{{ Route::is('user.subscription')?'active' : '' }}"> <span><img src="{{asset('images/subscription.png')}}" alt="" ></span>Subscription</a>
         </li>
         <li>
            <a href="{{ route('user.subscription.history') }}" class="{{ Route::is('user.subscription.history')?'active' : '' }}"> <span><img src="{{asset('images/subs-history.png')}}" alt="" ></span>  Subscription History </a>
         </li> --}}
         <li>
            <a href="{{ route('logout') }}" class=""> <span><img src="{{asset('images/dash6.png')}}" alt="" ></span>  Logout </a>
         </li>
      </ul>
   </div>
</div>
</div>
