@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
<style>
  .error{

     color:red !important;
     text-transform: none !important;
  }
</style>
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<div class="inner-banner position-relative">
         <img src="{{asset('images/contact-banner.png')}}" alt="" class="inner-banner-bg position-absolute">
         <div class="container">
            <div class="inner-banner-txt">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb inner-brdcrmb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                  </ol>
               </nav>
               <h1>Contact Muhula</h1>
            </div>
         </div>
      </div>

      <scection class="contact-outr position-relative">
         
         <div class="contact-pap-inr position-relative">
            <span class="cont-icon1 position-absolute"><img src="{{asset('images/abt-sec1-bg.png')}}" alt="" class="img-fit"></span>
         <span class="cont-icon2 position-absolute"><img src="{{asset('images/mis-vis-icon.png')}}" alt="" class="img-fit"></span>
            <div class="container">
            @include('includes.message')
               <div class="row align-items-stretch">
                  <div class="col-lg-8">
                     <div class="cont-page-lft">
                        <div class="cont-lft-hdr">
                           <h2>Get in touch</h2>
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>                          
                        </div>
                        <form action="{{ route('contact.us.save') }}" method="post" id="contactform">
                           @csrf
                           <div class="row">
                              <div class="col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>Full name</label>
                                    <input type="text" name="name" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>Subject</label>
                                    <select name="subject" id="">
                                       <option value="" selected disabled>Select</option>
                                       <option value="Query">Query</option>
                                       <option value="Complaint">Complaint</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="dash_input ">
                                    <label>Message</label>
                                    <textarea placeholder="Enter here" name="message"></textarea>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <button type="submit" class="contct-submit">Submit
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                       
                                 </button>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-lg-4">
                     <div class="cont-page-rt">
                        <ul class="cont-info-list">
                           <li>
                              <em>
                                 <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.25 9.16699C19.25 15.5837 11 21.0837 11 21.0837C11 21.0837 2.75 15.5837 2.75 9.16699C2.75 6.97896 3.61919 4.88054 5.16637 3.33336C6.71354 1.78619 8.81196 0.916992 11 0.916992C13.188 0.916992 15.2865 1.78619 16.8336 3.33336C18.3808 4.88054 19.25 6.97896 19.25 9.16699Z" stroke="#566778" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11 11.917C12.5188 11.917 13.75 10.6858 13.75 9.16699C13.75 7.64821 12.5188 6.41699 11 6.41699C9.48122 6.41699 8.25 7.64821 8.25 9.16699C8.25 10.6858 9.48122 11.917 11 11.917Z" stroke="#566778" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>                                    
                              </em>
                              <h5><span class="d-block">Address</span>
                                 Lorem Ipsum is simply dummy text of the printing and typesetting
                              </h5>
                           </li>
                           <li>
                              <em>
                                 <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.3332 14.1004V16.6004C18.3341 16.8325 18.2866 17.0622 18.1936 17.2749C18.1006 17.4875 17.9643 17.6784 17.7933 17.8353C17.6222 17.9922 17.4203 18.1116 17.2005 18.186C16.9806 18.2603 16.7477 18.288 16.5165 18.2671C13.9522 17.9884 11.489 17.1122 9.32486 15.7087C7.31139 14.4293 5.60431 12.7222 4.32486 10.7087C2.91651 8.53474 2.04007 6.05957 1.76653 3.48374C1.7457 3.2533 1.77309 3.02104 1.84695 2.80176C1.9208 2.58248 2.03951 2.38098 2.1955 2.21009C2.3515 2.0392 2.54137 1.90266 2.75302 1.80917C2.96468 1.71569 3.19348 1.66729 3.42486 1.66707H5.92486C6.32928 1.66309 6.72136 1.80631 7.028 2.07002C7.33464 2.33373 7.53493 2.69995 7.59153 3.10041C7.69705 3.90046 7.89274 4.68601 8.17486 5.44207C8.28698 5.74034 8.31125 6.0645 8.24478 6.37614C8.17832 6.68778 8.02392 6.97383 7.79986 7.20041L6.74153 8.25874C7.92783 10.345 9.65524 12.0724 11.7415 13.2587L12.7999 12.2004C13.0264 11.9764 13.3125 11.8219 13.6241 11.7555C13.9358 11.689 14.2599 11.7133 14.5582 11.8254C15.3143 12.1075 16.0998 12.3032 16.8999 12.4087C17.3047 12.4658 17.6744 12.6697 17.9386 12.9817C18.2029 13.2936 18.3433 13.6917 18.3332 14.1004Z" stroke="#566778" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>                                                                        
                              </em>
                              <h5><span class="d-block">Call Us</span>
                                 <b><a href="tel:1 0123456789;" class="d-inline-block">+1 0123456789</a> &nbsp;/&nbsp; <a href="tel:1 9876543210;" class="d-inline-block">+1 9876543210</a></b>
                              </h5>
                           </li>
                           <li>
                              <em>
                                 <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.5 3.5H17.5C18.4625 3.5 19.25 4.2875 19.25 5.25V15.75C19.25 16.7125 18.4625 17.5 17.5 17.5H3.5C2.5375 17.5 1.75 16.7125 1.75 15.75V5.25C1.75 4.2875 2.5375 3.5 3.5 3.5Z" stroke="#566778" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M19.25 5.25L10.5 11.375L1.75 5.25" stroke="#566778" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>                                                                       
                              </em>
                              <h5><span class="d-block">Email</span>
                                <b><a href="mailto:muhula-info123@gmail.com;">muhula-info123@gmail.com</a></b>
                              </h5>
                           </li>
                        </ul>
                        <div class="sos-list">
                           <h4>Connect with social media</h4>
                           <ul>
                              <li><a href="#" style="background-color: #426BC3;" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                              <li><a href="#" style="background-color: #55ACEF;" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                              <li><a href="#" style="background-color: #CE201F;" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                              <li><a href="#" style="background-color: #CD47EE;" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </scection>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
<script>
$(document).ready(function() {

   $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

  $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only numbers and letters");

    $.validator.addMethod("phone_Regex", function(value, element) {
        return this.optional(element) || /^[0-9\+]+$/.test(value);
    }, "Please enter only numbers");

    $('#contactform').validate({
        rules: {
            name: {
                required: true,
                name_Regex: true,
				        maxlength:30,
            },
            email: {
                required: true,
				      maxlength:200,
                  validate_email: true
              },
            phone: {

                 required: true,
                 //digits: true,
                 minlength: 10,
                 maxlength: 13,
                 phone_Regex: true,
            },
			      subject: {

				       required: true,
			        },
              message: {
                required: true,
				          maxlength:500,
            },
        },
        messages: {

             phone: {
              maxlength: 'Please enter no more than 10 digits',
                minlength: 'Please enter no more than 10 digits',
             }, 
        },
        submitHandler: function(form) {
            form.submit();
        },
    });

});
</script>
@endsection
