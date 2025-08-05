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
<section class="add-school-container">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                  <div class="add-schl-lft">
                     <div class="ad-schl-card adscl-crd1">
                        <h1>Add School</h1>
                        <p>Add your school for Free and start connecting with learners...</p>
                        <div class="adschl-steps-list">
                           <ul>
                           <li class="ongoing"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                    <h6>School Register</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 2</small>
                                 <h6>Basic Information</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 3</small>
                                 <h6>School Details</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 4</small>
                                 <h6>Extra Info</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>School Gallery</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 6</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 7</small>
                                    <h6>Result</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 8</small>
                                    <h6>Branches</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 9</small>
                                    <h6>School Fees</h6>
                                 </div>                                 
                              </li>
                           </ul>
                        </div>
                     </div>
                     <form action="{{ route('add.school.step1.save') }}" method="POST" id="SchollForm">
                        @csrf
                        <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                        <div class="ad-schl-card adscl-crd10">
                        <div class="col-lg-12 col-md-12">
                                 <div class="dash_input nf_step01 mb-1">
                                    <label>How many schools are you registering?</label>
                                 </div>
                                 <div class="check_gender nf_step01 adscl-type">
                                    <ul>
                                    <li>
                                          <input type="radio" name="school_register" id="gender_02" value="OS" class="school_register" @if(@$schoolDetails) {{ @$schoolDetails->school_register == 'OS'?'checked':'' }} @elseif(session()->get('school_register') == 'OS') checked @else checked @endif>
                                          <label for="gender_02">
                                             <p><span><img src="{{ asset('images/one_school.PNG') }}" alt=""></span> One School</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="school_register" id="gender_01" value="MS" class="school_register" @if(@$schoolDetails) {{ @$schoolDetails->school_register == 'MS'?'checked':'' }} @elseif(session()->get('school_register') == 'MS') checked @endif>
                                          <label for="gender_01">
                                             <p><span><img src="{{ asset('images/multi_school.PNG') }}" alt=""></span> Multiple Schools</p>
                                          </label>
                                       </li>
                                      
                                    </ul>
                                 </div>
                                 <label id="school_register-error" class="error" for="school_register" style="display:none;">This field is required.</label>
                              </div>
                              <div class="col-lg-12 col-md-12 addre_sec" @if(@$schoolDetails->school_register == 'MS') style="display:block" @elseif(session()->get('school_register') == 'MS') style="display:block;" @else style="display:none;" @endif>
                                 <div class="dash_input nf_step01 mb-1">
                                    <label>Are these schools in the same address?</label>
                                 </div>
                                 <div class="check_gender nf_step01 adscl-type  adscl-tp2">
                                    <ul>
                                       <li>
                                          <input type="radio" name="school_same_address" id="gender_04" value="Y" @if(@$schoolDetails) {{ @$schoolDetails->school_same_address == 'Y'?'checked':'' }} @elseif(session()->get('school_same_address') == 'Y') checked @endif>
                                          <label for="gender_04 nf_step01">
                                             <p><span><img src="{{ asset('images/one_location.png') }}" alt=""></span>Yes, these schools are in the same address.</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="school_same_address" id="gender_05" value="N"  @if(@$schoolDetails) {{ @$schoolDetails->school_same_address == 'N'?'checked':'' }} @elseif(session()->get('school_same_address') == 'N') checked @endif>
                                          <label for="gender_05 nf_step01 ">
                                             <p><span><img src="{{ asset('images/multi_location.PNG') }}" alt=""></span>No, these schools are not in the same address.</p>
                                          </label>
                                       </li>
                                    </ul>
                                 </div>
                                 <label id="school_same_address-error" class="error" for="school_same_address" style="display:none;">This field is required.</label>
                              </div>
                              <div class="col-md-3 col-sm-3 schoolNoSec" @if(@$schoolDetails->school_register == 'MS') style="display:block" @elseif(session()->get('school_register') == 'MS') style="display:block;" @else style="display:none;" @endif>
                                 <div class="dash_input">
                                    <label>No Of School</label>
                                    <input type="number" name="no_of_school" id="no_of_school" value="{{ @$schoolDetails->no_of_school }}" placeholder="Enter here">
                                 </div>
                              </div>
                        </div>
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button type="submit" id="submitBtn">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>

                              </div>
                              <p>Step 1 Of 9</p>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="add-schl-r8">
                     <div class="ad-schl-rtcrd">                        
                        <em><span class="cardimg-line-top"></span><img src="{{ asset('images/ad-schl-rt.png') }}" alt=""><span class="cardimg-line-bottom"></span></em>   
                        <span class="line-img-btm"></span>        
                        <h2>Listing your School will help others make informed choices on their educational journey</h2> 
                        <!-- <ul>
                           <li>In publishing and graphic design, Lorem ipsum is a placeholder sample caption</li>
                           <li>Lorem Ipsum is simply dummy text</li>
                           <li>In publishing and graphic design lorem ipsum is a placeholder</li>
                        </ul>             -->
                        <p>Our diverse directory ensures that we cater to a wide array of educational interests and goals while helping you connect with learners, parents/guardians along their education journey!</p>
                     </div>
                     <h6>Please follow our <a href="#">Guidelines</a></h6>
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

        $('#SchollForm').validate({

             rules: {
               school_register: {

                  required: true,
               },
               school_same_address: {

                  //required: true,
               },
               no_of_school: {
                   digits: true,
                   min:1,
                   max:50,
               }

             },
             messages: {

               no_of_school: "Please enter valid number",
             },
             submitHandler: function(form){
                 $('#submitBtn').prop('disabled',true);
                 form.submit();
             }
             
        })
   })
</script>
<script>
   $(document).ready(function(){

        $('.school_register').click(function(){

             let value = $(this).val();
             if(value == 'MS'){
                 $('.schoolNoSec').css('display','block');
                 $('.addre_sec').css('display','block');
                 $('#no_of_school').rules('add','required');
                 $("input[name=school_same_address]").rules('add','required');
             }
             else if(value == 'OS'){
               $('.schoolNoSec').css('display','none');
               $('.addre_sec').css('display','none');
               $('#no_of_school').rules('remove','required');
               $('#no_of_school').val('');
               $("input[name=school_same_address]").rules('remove','required');
               $("input[name=school_same_address]").prop('checked',false);
             }
        })

   })
</script>
@endsection  