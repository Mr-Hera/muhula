@extends('layouts.app')
@section('title','Change password')
@section('links')
@include('includes.links')
<style>
  .error{

     color:red !important;
  }
</style>
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="after-loggd-page">
         <div class="container-fluid top-container">
            <div class="row ram001">
            @include('includes.sidebar') 
               <div class="right-section">
                  <div class="page-title-sec">
                     <h1>Change Password</h1>
                     <p>You can change your password here</p>
                  </div>
                  <div class="right-sec-paper dashboard_from">
                  @include('includes.message')
                     <div class="inner_dash">
                        
                        <div class="edit_froms">
                           <form action="{{ route('update.password') }}" method="post" id="changePasswordForm">
                            @csrf
                              <div class="from_inner">
                                 <h3 class="sub_dash_heading">Password:</h3>
                                 <div class="row">

                                    <div class="col-md-4 col-sm-6 col-12">
                                       <div class="from_inputs">
                                          <label class="post_label">
                                             Current Password
                                          </label>
                                          <div class="position-relative">
                                             <input type="Password" name="old_password" id="old_password" placeholder="Enter Here">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                       <div class="from_inputs">
                                          <label class="post_label">
                                             New Password
                                          </label>
                                          <div class="position-relative">
                                             <input type="Password" name="new_password" id="new_password" placeholder="Enter Here">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                       <div class="from_inputs">
                                          <label class="post_label">
                                             Re-Enter Password
                                          </label>
                                          <div class="position-relative">
                                             <input type="Password" name="password_confirmation" id="password_confirmation" placeholder="Enter Here">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="border_topns"></div>
                                       <div class="dash_submits" style="margin: 23px 0px 0px 0px;">
                                          <button type="submit">Save Changes <img src="{{ url('public/images/arrow-up-right2.png') }}" alt=""> </button>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                           </form>
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
<script>
    $(document).ready(function(){
        $.validator.addMethod("password_Regex", function(value, element) {

        return this.optional(element) || /^.*(?=.{8,})(?=.*\d)(?=.*[A-Z])(?=.*[@#$%&?!*]).*$/.test(value);
    }, "Password minimum 8 character, at least one capital letter, one number, one special character from these (@ # $ % & ? ! *");

      $('#changePasswordForm').validate({
        rules:{
            old_password:{
                required:true,
            },
            new_password:{
                required:true,
                //password_Regex:true,
                minlength:8,
            },
            password_confirmation:{
                required:true,
                equalTo: "#new_password",
            }
        },
        messages: {
            password_confirmation:{
                equalTo: 'New Password and Confirm Password must be same',
            }
         }
      });
    });
   </script>
@endsection