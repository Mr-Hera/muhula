@extends('layouts.app')
@section('title','Forgot Password')
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
                     <a href="{{ route('home') }}"> <img src="{{ url('public/images/login-logo.png') }}" alt=""> </a>
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
                           <h2> Forgot Password </h2>
                        </div>
                        {{--<h4>Please fill in the below fields to reset your password</h4>--}}
                        <div class="login_froms">
                           <form action="{{ route('user.password.email') }}" method="post" id="SigninForm">
                              @csrf
                              <div class="login_input">
                                 <label>Email </label>
                                 <input type="text" name="email" id="email" placeholder="Enter here">
                              </div>

                                  <div class="login_btns">
                                     <button type="submit">Submit<img src="{{ url('public/images/arrow-righr.png') }}" alt=""> </button>
                                  </div>

                                  {{--<div class="login_gma">
                                     <div class="gmail_log">
                                       <a href="#">
                                          <div class="google_logo"> <img src="{{ url('public/images/google.png') }}" alt=""> </div>
                                          <h3>Login with  Google account</h3>
                                       </a> 
                                     </div>
                                     <p>Don't have an account? <a href="{{ route('user.register') }}">Signup</a> </p>
                                  </div>--}}

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
});
</script>
@endsection
