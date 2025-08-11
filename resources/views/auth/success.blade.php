@extends('layouts.app')
@section('title','Success')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')

 <section class="login_main_section for_sucess_msg">

    <div class="container">

      

           <div class="mesg-cls success-cls">

              <span class="img-span"><img width="100" src="{{asset('public/images/success2.png')}}" alt="" class="img-fit"></span>

              <h2 class="thankyou">Success !!</h2>

              @if(Session::has('success'))

                 <div class="alert alert-success blue-success" role="alert">

                    <p>{{ session('success') }}</p>

                 </div>
                @endif
                

                 <a href="{{ route('login') }}" class="go_login">Go to Login
                  <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                 </a>

           </div>


    </div>

</section> 

@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('scripts')
@include('includes.scripts')
@endsection