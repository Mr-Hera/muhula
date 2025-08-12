@extends('layouts.app')
@section('title','Sign Up')
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
                  <div class="login_from_body mt-3">
                     <div class="inner_logn_b">
                     @include('includes.message')
                        <div class="login_heading">
                           <h2>Create Your <span>Muhula </span>  Account</h2>
                        </div>

                        <div class="login_froms">
                           <form action="{{ route('user.register.save') }}" method="POST" id="register-form">
                              @csrf
                              
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="login_input">
                                       <label>First name </label>
                                       <input type="text" name="first_name" id="first_name" placeholder="Enter here">
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="login_input">
                                       <label>Last name </label>
                                       <input type="text" name="last_name" id="last_name" placeholder="Enter here">
                                    </div>
                                 </div>
                              </div>
                              <div class="login_input">
                                 <label>Email </label>
                                 <input type="text" name="email" id="email" placeholder="Enter here">
                              </div>

                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="login_input">
                                       <label class="floating__label nob" data-content="Password">Password </label>

                                       <div class="posit_rela">
                                       <input id="password"  name="password" type="password" placeholder="Enter here">
                                       <span toggle="#password-field" id="togglePassword" class="fa fa-eye field-icon toggle-password"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="login_input">
                                       <label class="floating__label nob" data-content="Password">Confirm Password </label>

                                       <div class="posit_rela">
                                       <input id="password2"  name="password2" type="password" placeholder="Enter here">
                                       <span toggle="#password-field" id="togglePassword2" class="fa fa-eye field-icon toggle-password"></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                                 <div class="remember d-flex justify-content-between align-items-center">
                                      <div class="check_re">
                                          <label for="">I agree to the <a href="#">Terms of service</a> 
                                                  <input type="checkbox" name="terms_of_service" id="agree2">
                                                  <span class="checkbox"></span>
                                          </label>
                                          <label id="check_me-error" class="error" for="check_me" style="display:none;">Your consent is required.</label>
                                       </div>
                                      
                                  </div>


                                    <div class="capca_box">
                                      <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                       @if($errors->has('g-recaptcha-response'))
                                       <span >
                                          <strong style="color: red !important">{{$errors->first('g-recaptcha-response')}}</strong>
                                       </span>
                                       @endif
                                    </div>
                                       
                                    <label class="captcha_error error mb-2"></label>
                                  <div class="login_btns">
                                     <button type="submit">Signup <img src="{{ asset('images/arrow-righr.png') }}" alt=""> </button>
                                  </div>

                                  <div class="login_gma">
                                     <div class="gmail_log">
                                       <a href="{{ route('login.social') }}">
                                          <div class="google_logo"> <img src="{{ asset('images/google.png') }}" alt=""> </div>
                                          <h3>Signup with Google account</h3>
                                       </a> 
                                     </div>
                                     <p>Already have an account? <a href="{{ route('login') }}">Login</a> </p>
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
                           <img src="{{ asset('images/log1.png') }}" alt="">
                        </div>
                        <div class="st_info">
                        <h5>Register on Muhula.com</h5>
                         <p>Register your school on muhula.com and let prospective learners know more about your school and communicate important information, such as your programs, mission, and history.</p>
                        </div>
                     </div>

                     <div class="statis_ic">
                        <div class="st_imgs">
                           <img src="{{ asset('images/log2.png') }}" alt="">
                        </div>
                        <div class="st_info">
                         <h5>Search & Choose School</h5>
                           <p>On muhula.com you can find school(s) that are best suited to your learning needs. Explore common considerations, including costs, facilities, courses, and student resources and services.</p>
                        </div>
                     </div>

                     <div class="statis_ic">
                        <div class="st_imgs">
                           <img src="{{ asset('images/log3.png') }}" alt="">
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
{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
$(document).ready(function() {
  $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter only letters");

    $.validator.addMethod("password_Regex", function(value, element) {
        return this.optional(element) || /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/.test(value);
    }, "Password minimum 8 character, at least one capital letter, one number, one special character from these (@ # $ % & ? ! * )'");
    // validate the comment form when it is submitted
    $("#register-form").validate({
        rules: {
            first_name: {
                name_Regex: true,
                required: true,
                maxlength: 30
            },
            last_name: {
                name_Regex: true,
                required: true,
                maxlength: 30
            },
            email: {
                required: true,
                //email: true,
                validate_email: true,
                remote: {
                    url: '{{ route("user.email.check") }}',
                    type: "post",
                    data: {
                        email: function() {
                            return $("#email").val();
                        },
                        _token: '{{ csrf_token() }}'
                    }
                },

            },
            password:{
                required: true,
                //password_Regex: true,
                minlength: 8
            },
            password2: {
                required: true,
                equalTo: "#password"
            },
            check_me: {

                 required: true,
            },

        },
        messages: {
            first_name: {
                maxlength: 'Please enter not more than 30 characters',
                name_Regex: 'First Name must contain only letters'
            },
            last_name: {
                maxlength: 'Please enter not more than 30 characters',
                name_Regex: 'Last Name must contain only letters'
            },
            email: {
                remote: 'This email has already been taken',
            },
            password2: {

              equalTo: "Confirm password not match",
            }
        },

      submitHandler: function(form) {
         // if (typeof grecaptcha !== 'undefined') {
         //    var res = grecaptcha.getResponse();
         //    if (res.length == 0) {
         //          $('.captcha_error').text("Please confirm captcha to proceed");
         //          $('.captcha_error').show();
         //          return false;
         //    }
         // }
         // $('.captcha_error').text("");
         form.submit();
      }

    });

    $('#email').keyup(function(){
      let val = $(this).val().toLowerCase()
      $(this).val(val)
})



});
</script> --}}
@endsection
