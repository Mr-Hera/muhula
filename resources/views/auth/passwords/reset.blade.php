@extends('layouts.app')
@section('title','Reset Password')
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
                           <h2>Reset Password</h2>
                        </div>
                        {{--<h4>Please fill in the below fields to reset your password</h4>--}}
                        <div class="login_froms">
                           <form action="{{ route('user.password.update') }}" method="post" id="SigninForm">
                              @csrf
                              <input type="hidden" name="id" value="{{ @$token }}">
                              <div class="login_input">
                                 <label class="floating__label nob" data-content="Password">Password </label>

                                 <div class="posit_rela">
                                 <input id="password"  name="password" type="password" placeholder="Enter here">
                                 <span toggle="#password-field" id="togglePassword" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>

                              <div class="login_input">
                                 <label class="floating__label nob" data-content="Password">Confirm Password </label>

                                 <div class="posit_rela">
                                 <input id="password_confirmation"  name="password_confirmation" type="password" placeholder="Enter here">
                                       <span toggle="#password-field" id="togglePassword2" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>

                             

                                  <div class="login_btns">
                                     <button type="submit">Submit <img src="{{ url('public/images/arrow-righr.png') }}" alt=""> </button>
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
<script>
       $(document).ready(function(){

        $.validator.addMethod("password_Regex", function(value, element) {
        return this.optional(element) || /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/.test(value);
    }, "Password minimum 8 character, at least one capital letter, one number, one special character from these (@ # $ % & ? ! *");


			 $('#SigninForm').validate({
				  rules: {

                    password: {
                       required: true,
                        //password_Regex: true,
                        minlength: 8
                   },
                  password_confirmation: {
                         required: true,
                           equalTo: "#password"
                     }
				          },
                  messages: {

                          password_confirmation: {
                             equalTo: 'Password and Confirm Password must be same'
                        }
                  },

                  submitHandler:function(form){

                       form.submit();
                  }
			 })
		})
    </script>
@endsection
