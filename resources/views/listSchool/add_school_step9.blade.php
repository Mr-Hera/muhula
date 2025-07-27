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
            @include('includes.message')
               <div class="col-lg-8">
                  <div class="add-schl-lft">
                     <div class="ad-schl-card adscl-crd1">
                        <h1>Add School</h1>
                        <p>Add your school for Free and start connecting with learners...</p>
                        <div class="adschl-steps-list">
                        <ul>
                           <li class="done"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                    <h6>School Register</h6>
                                 </div>                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 2</small>
                                 <h6>Basic Information</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 3</small>
                                 <h6>School Details</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 4</small>
                                 <h6>Extra Info</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>School Gallery</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 6</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 7</small>
                                    <h6>Result</h6>
                                 </div>                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 8</small>
                                    <h6>Branches</h6>
                                 </div>                                 
                              </li>
                              <li class="ongoing"><em></em>
                                 <div>
                                    <small>Step 9</small>
                                    <h6>School Fees</h6>
                                 </div>                                 
                              </li>
                           </ul>
                        </div>
                     </div>
                        <div class="ad-schl-card adscl-crd8">
                           <h2>Fees</h2>
                           <form action="{{ route('add.school.step9.fees.save') }}" method="post" enctype="multipart/form-data" id="feesForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="school_fees_id" id="">
                           <div class="row align-items-stretch">
                              <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="dash_input">
                                    <label>Grades</label>
                                    <input type="text" name="grade" id="grade" placeholder="Enter here">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6 col-sm-6">
                                 <div class="fees-tofrm d-flex justify-content-between align-items-end">
                                    <div class="dash_input">
                                       <label>Fees From</label>
                                       <input type="text" name="from_fees" id="from_fees" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')"  maxlength="10">
                                    </div>
                                    <div class="dash_input">
                                       <label>Fees To</label>
                                       <input type="text" name="to_fees" id="to_fees" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')" maxlength="10">
                                    </div>
                                    
                                    <button class="fees-frm2-btn" type="submit">+ Add</button>
                                    
                                 </div>
                                 <label id="to_fees-error" class="error" for="to_fees" style="display:none;">From fees must be less than to fees</label>
                              </div>
                              <div class="clearfix"></div>
                              <div class="col-12">
                                 <div class="row">
                                    <div class="col-12">
                                       <em class="fee-ad-ln"></em>
                                    </div>
                                    @if(@$school_fees)
                                    @foreach($school_fees as $data)
                                    <div class="col-lg-6 col-sm-6">
                                       <div class="added-fees position-relative">
                                          <h5>{{ @$data->grade }}</h5>
                                          <p>Fees KES {{ @$data->from_fees }} - KES {{ @$data->to_fees }}</p>
                                          <a href="{{ route('school.fees.delete',@$data->id) }}" class="position-absolute">
                                             <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M13.914 6.72065C13.914 6.76881 13.5365 11.5435 13.3209 13.553C13.1859 14.7862 12.3909 15.5341 11.1984 15.5554C10.2822 15.5759 9.38525 15.583 8.50278 15.583C7.56589 15.583 6.64966 15.5759 5.7603 15.5554C4.60779 15.5278 3.81212 14.7649 3.68398 13.553C3.46216 11.5364 3.09154 6.76881 3.08465 6.72065C3.07776 6.57545 3.1246 6.43733 3.21967 6.32541C3.31336 6.222 3.44838 6.15967 3.59029 6.15967H13.4153C13.5565 6.15967 13.6846 6.222 13.7859 6.32541C13.8803 6.43733 13.9278 6.57545 13.914 6.72065Z" fill="black"/>
                                                <path d="M14.875 4.23345C14.875 3.94233 14.6456 3.71426 14.37 3.71426H12.3047C11.8845 3.71426 11.5194 3.41535 11.4257 2.99391L11.31 2.47755C11.1481 1.85353 10.5894 1.4165 9.96252 1.4165H7.03817C6.40439 1.4165 5.85121 1.85353 5.68312 2.51155L5.57497 2.99462C5.48059 3.41535 5.11548 3.71426 4.69594 3.71426H2.63065C2.3544 3.71426 2.125 3.94233 2.125 4.23345V4.5026C2.125 4.78664 2.3544 5.02179 2.63065 5.02179H14.37C14.6456 5.02179 14.875 4.78664 14.875 4.5026V4.23345Z" fill="black"/>
                                             </svg>
                                          </a>
                                       </div>
                                    </div>
                                    @endforeach
                                    @endif
                                 </div>
                              </div>
                           </div>
                           </form>
                        </div>
                      
                     <form action="javascript:;">
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button class="completeBtn" data-url="{{ route('add.school.step9',[md5(@$schoolDetails->id),'CO']) }}">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                     </button>
                                 <a href="{{ route('add.school.step8',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 9 Of 9</p>
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

      $.validator.addMethod("priceMin", function(value, element) {

          let from_price = parseInt($('#from_fees').val());
          let to_price =  parseInt($('#to_fees').val());

          if(from_price > to_price){

              return false;
          }else{

            return true;
          }
         
      }, "From fees must be less than to fees");

        $('#feesForm').validate({

            rules: {

               grade: {

                   required: true,
               },
               from_fees: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               to_fees: {

                  required: true,
                  digits: true,
                  maxlength: 10,
                  priceMin: true, 
               }
            },
            submitHandler: function(form){

                 form.submit();
            }
        })
   })
</script>

<script>
   
        $('.completeBtn').click(function(e){
             
            e.preventDefault();
             let url = $(this).data('url');

             window.location.href = url;
        })
</script>
@endsection  