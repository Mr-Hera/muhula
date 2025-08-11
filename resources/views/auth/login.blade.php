@extends('layouts.app')
@section('title','Login')
@section('links')
@include('includes.links')
<style>
  .error{

     color:red !important;
  }
</style>
@endsection
@section('content')
<section class="loagin_body">
         <div class="container-fluid top-container">
            <div class="row">
               <div class="col-12">
                  <div class="logo_login">
                     <a href="{{ route('home') }}"> <img src="{{ asset('images/login-logo.png') }}" alt=""> </a>
                  </div>
               </div>
            </div>
         </div>

         <div class="container-fluid top-container">
            <div class="row">
               <div class="col-12">
                  <div class="login_from_body">
                  @include('includes.message')
                     <div class="inner_logn_b">
                        <div class="login_heading">
                           <h2>Login in to <span>Muhula </span> </h2>
                        </div>

                        <div class="login_froms">
                           <form action="{{ route('login') }}" method="POST" id="SigninForm">
                              @csrf
                              <div class="login_input">
                                 <label>Email </label>
                                 <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="Enter here">
                              </div>
                              <div class="login_input">
                                 <label class="floating__label nob" data-content="Password">Password </label>

                                 <div class="posit_rela">
                                 <input id="password"  name="password" type="password" placeholder="Enter here">
                                 <span toggle="#password-field" id="togglePassword" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>

                              <div class="remember d-flex justify-content-between align-items-center">
                                    <div class="check_re">
                                       <label for="">Remember Me
                                                <input type="checkbox"  name="remember" {{ @$remember ? 'checked' : '' }} id="agree2">
                                                <span class="checkbox"></span>
                                       </label>
                                    </div>
                                    <a href="{{ route('user.password.request') }}" class="log-forgot">Forgot Password?</a>
                                 </div>

                                 <div class="login_btns">
                                    <button type="submit">Login <img src="{{ asset('images/arrow-righr.png') }}" alt=""> </button>
                                 </div>

                                 <div class="login_gma">
                                    <div class="gmail_log">
                                    <a href="{{ route('login.social') }}">
                                       <div class="google_logo"> <img src="{{ asset('images/google.png') }}" alt=""> </div>
                                       <h3>Login with  Google account</h3>
                                    </a> 
                                    </div>
                                    <p>Don't have an account? <a href="{{ route('user.register') }}">Signup</a> </p>
                                 </div>
                           </form>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="container-fluid top-container">
            <div class="row">
               <div class="col-12">
                  <div class="login_statis">
                     <div class="statis_ic">
                        <div class="st_imgs">
                           <img src="{{ url('public/images/log1.png') }}" alt="">
                        </div>
                        <div class="st_info">
                           <h5>Register on Muhula.com</h5>
                           <p>Register your school on muhula.com and let prospective learners know more about your school and communicate important information, such as your programs, mission, and history.</p>
                        </div>
                     </div>

                     <div class="statis_ic">
                        <div class="st_imgs">
                           <img src="{{ url('public/images/log2.png') }}" alt="">
                        </div>
                        <div class="st_info">
                           <h5>Search & Choose School</h5>
                           <p>On muhula.com you can find school(s) that are best suited to your learning needs. Explore common considerations, including costs, facilities, courses, and student resources and services.</p>
                        </div>
                     </div>

                     <div class="statis_ic">
                        <div class="st_imgs">
                           <img src="{{ url('public/images/log3.png') }}" alt="">
                        </div>
                        <div class="st_info">
                           <h5>Claim School & reply to reviews</h5>
                           <p>You can claim and manage your school on  muhula.com by sharing up to date information. Our reviews on Muhula.com are community driven and help learners gain better understanding of your institution.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </section>
@endsection
@section('script')
@include('includes.scripts')
<script type="text/javascript">
$(document).ready(function() {
    $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");
    $('#SigninForm').validate({
        rules: {
            email: {
                required: true,
                validate_email: true,
            },
            password: {
                required: true
            },
        },
        messages: {
            email: {
                email: 'Please enter a valid email address'
            }
        },

        submitHandler: function(form) {
            form.submit();
        },
    });

    $('#email').keyup(function(){
 let val = $(this).val().toLowerCase()
 $(this).val(val)
})

 
});
</script>
@endsection
