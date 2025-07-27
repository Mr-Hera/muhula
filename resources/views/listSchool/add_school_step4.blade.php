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
            {{--@include('includes.message')--}}
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
                              <li class="ongoing"><em></em>
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
                    
                        
                       
                        <div class="ad-schl-card adscl-crd7">
                           <h2>School Rules</h2>
                           <form action="{{ route('add.school.step4.rules.save') }}" method="post" enctype="multipart/form-data" id="rulesForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                           <div class="row">
                                 <div class="col-12">
                                    <div class="dash_input">
                                       <ul class="rules-list">
                                          <li style="text-transform: none !important;">
                                             Meals offered
                                             <label class="switch">
                                                <input type="checkbox" name="meal_offer" value="Y" @if(@$schoolDetails->meal_offer == 'Y') checked @endif>
                                                <span class="slider round"></span>
                                             </label>
                                          </li>
                                          <li style="text-transform: none !important;">
                                             Special needs catered
                                             <label class="switch">
                                                <input type="checkbox" name="special_need_catered" value="Y" @if(@$schoolDetails->special_need_catered == 'Y') checked @endif>
                                                <span class="slider round"></span>
                                             </label>
                                          </li>
                                          <li style="text-transform: none !important;">
                                             School transport available
                                             <label class="switch">
                                                <input type="checkbox" name="school_transport_available" value="Y" @if(@$schoolDetails->school_transport_available == 'Y') checked @endif>
                                                <span class="slider round"></span>
                                             </label>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <h3 class="ratio-hd">Day learning period</h3>
                                    <div class="row">
                                       <div class="col-sm-6 col-12">
                                          <div class="dash_input">
                                             <label>From</label>
                                             <select name="day_learn_period_from" id="day_learn_period_from">
                                             <option value="">Select</option>  
                                             @foreach (range(1,17) as $number) 
                                             @if($number < 10)
                                              @php
                                              $time1 = '0'.@$number.':00';
                                              @endphp
                                             <option value="{{ @$time1 }}" @if(date('H:i',strtotime(@$schoolDetails->day_learn_period_from)) == $time1) selected="" @endif>{{ @$time1 }}</option>
                                              @else
                                              @php
                                              $time2 = @$number.':00';
                                              @endphp
                                             <option value="{{$time2}}"  @if(date('H:i',strtotime(@$schoolDetails->day_learn_period_from)) == $time2) selected="" @endif>{{@$time2}}</option>
                                              @endif
                                               @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-sm-6 col-6">
                                          <div class="dash_input">
                                             <label>Until</label>
                                             <select name="day_learn_period_until" id="day_learn_period_until">
                                             <option value="">Select</option>
                                             @foreach (range(1,17) as $number) 
                                             @if($number < 10)
                                              @php
                                              $time1 = '0'.@$number.':00';
                                              @endphp
                                             <option value="{{ @$time1 }}" @if(date('H:i',strtotime(@$schoolDetails->day_learn_period_until)) == $time1) selected="" @endif>{{ @$time1 }}</option>
                                              @else
                                              @php
                                              $time2 = @$number.':00';
                                              @endphp
                                             <option value="{{$time2}}"  @if(date('H:i',strtotime(@$schoolDetails->day_learn_period_until)) == $time2) selected="" @endif>{{@$time2}}</option>
                                              @endif
                                               @endforeach
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <h3 class="ratio-hd mt-3p">Evening Studies</h3>
                                    <div class="row">
                                       <div class="col-sm-6 col-12">
                                          <div class="dash_input">
                                             <label>From</label>
                                             <select name="evening_studies_from" id="evening_studies_from">
                                             <option value="">Select</option>
                                             @foreach (range(17,24) as $number) 
                                             @if($number < 10)
                                              @php
                                              $time1 = '0'.@$number.':00';
                                              @endphp
                                             <option value="{{ @$time1 }}" @if(date('H:i',strtotime(@$schoolDetails->evening_studies_from)) == $time1) selected="" @endif>{{ @$time1 }}</option>
                                              @else
                                              @php
                                              $time2 = @$number.':00';
                                              @endphp
                                             <option value="{{$time2}}"   @if(date('H:i',strtotime(@$schoolDetails->evening_studies_from)) == $time2) selected="" @endif>{{@$time2}}</option>
                                              @endif
                                               @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-sm-6 col-6">
                                          <div class="dash_input">
                                             <label>Until</label>
                                             <select name="evening_studies_until" id="evening_studies_until">
                                             <option value="">Select</option>
                                             @foreach (range(17,24) as $number) 
                                             @if($number < 10)
                                              @php
                                              $time1 = '0'.@$number.':00';
                                              @endphp
                                             <option value="{{ @$time1 }}"  @if(date('H:i',strtotime(@$schoolDetails->evening_studies_until)) == $time1) selected="" @endif>{{ @$time1 }}</option>
                                              @else
                                              @php
                                              $time2 = @$number.':00';
                                              @endphp
                                             <option value="{{$time2}}" @if(date('H:i',strtotime(@$schoolDetails->evening_studies_until)) == $time2) selected="" @endif>{{@$time2}}</option>
                                              @endif
                                               @endforeach
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                     <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                 </div>
                             </div>
                           </form>                        
                        </div>
                        <div class="ad-schl-card adscl-crd7">
                           <h2>Teacher-Student ratio</h2>
                           <form action="{{ route('add.school.step4.ratio.save') }}" method="post" enctype="multipart/form-data" id="ratioForm">
                            @csrf
                            <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="teacher_student_ratio" id="teacher_student_ratio" value="{{ @$schoolDetails->teacher_student_ratio?@$schoolDetails->teacher_student_ratio:'0' }}"> 
                           <div class="row align-items-end">
                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="dash_input">
                                       <label>Teacher-Student ratio</label>
                                       <div class="ratio-counter">
                                          <span id="minus-btn">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                          
                                          </span>
                                          <h6 id="count"></h6>
                                          <span id="plus-btn">
                                             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 5V19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M5 12H19" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                          
                                          </span>
                                       </div>
                                       <label for="" id="ratio_error" class="error" style="display:none;"></label>
                                    </div>
                                 </div>

                                 <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="add-grade agree mb-4">
                                       <div class="radiobx">
                                             <label for="">Show Frontend
                                                <input type="checkbox" id="aboutSchoolcheck" value="Y" name="show_ratio" @if(@$schoolDetails->show_ratio == 'Y') checked @endif>
                                                <span class="checkbox"></span>
                                             </label>
                                          </div>
                                    </div>
                                 </div>


                                 <div class="col-12">
                                    <h3 class="ratio-hd">Students</h3>
                                    <div class="row">
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Total</label>
                                             <input type="text" name="total_student" id="total_student" placeholder="Enter here" value="{{ @$schoolDetails->total_student }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                             <label id="total_student-error" class="error" for="total_student" style="display:none;">Plese enter valid number</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Boys</label>
                                             <input type="text" name="student_boys" id="student_boys" placeholder="Enter here" value="{{ @$schoolDetails->student_boys }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Girls</label>
                                             <input type="text" name="student_girls" id="student_girls" placeholder="Enter here" value="{{ @$schoolDetails->student_girls }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <h3 class="ratio-hd mt-3p">Teachers</h3>
                                    <div class="row">
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                                          <div class="dash_input">
                                             <label>Total</label>
                                             <input type="text" name="total_teacher" id="total_teacher" placeholder="Enter here" value="{{ @$schoolDetails->total_teacher }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Male</label>
                                             <input type="text" name="teacher_male" id="teacher_male" placeholder="Enter here" value="{{ @$schoolDetails->teacher_male }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                          <div class="dash_input">
                                             <label>Female</label>
                                             <input type="text" name="teacher_female" id="teacher_female" placeholder="Enter here" value="{{ @$schoolDetails->teacher_female }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                          </div>
                                       </div>
                                       <div class="col-12">
                                          <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                       </div>
                                    </div>
                                 </div>
                             </div>
                           </form>                        
                        </div>
                           <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button id="submitBtn" data-url="{{ route('add.school.step5',[md5(@$schoolDetails->id)]) }}">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 <a href="{{ route('add.school.step3',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 4 Of 9</p>
                           </div>
                        </div>
            
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


      $.validator.addMethod("total_student_valid", function(value, element) {
       
         let total_student = parseInt($('#total_student').val());
         let student_boys = parseInt($('#student_boys').val());
         let student_girls = parseInt($('#student_girls').val());
         let sum_of_student = student_boys+student_girls
           console.log(student_boys);
            if(total_student == sum_of_student){
               return true;
             }
             else if(isNaN(student_boys) || isNaN(student_girls)){

               return true;
             }
             else{
              return false;
             }

    });


    $.validator.addMethod("total_teacher_valid", function(value, element) {
       
       let total_teacher = parseInt($('#total_teacher').val());
       let teacher_male = parseInt($('#teacher_male').val());
       let teacher_female = parseInt($('#teacher_female').val());
       let sum_of_teacher = teacher_male+teacher_female
       if(total_teacher == sum_of_teacher){

           return true;
       }
        else if(isNaN(teacher_male) || isNaN(teacher_female)){ 
           return true;
       }
       else{

           return false;
       }


    });

        $('#ratioForm').validate({

             rules: {
               total_student: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
                   
                   total_student_valid: true,
                  
               },
               student_boys: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               student_girls: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               total_teacher: {

                 // required: true,
                  digits: true,
                  maxlength: 10,
                  total_teacher_valid: true,
               },
               teacher_male: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
               teacher_female: {

                  //required: true,
                  digits: true,
                  maxlength: 10,
               },
             },
             messages:{

               total_student: {

                  total_student_valid: "Plese enter valid number",
               },
               total_teacher: {

                  total_teacher_valid: "Plese enter valid number",
               },
             },
             submitHandler: function(form){
                 let ratio = parseInt($('#teacher_student_ratio').val());
                 if(ratio <= 0){
                     $('#ratio_error').css('display','block');
                     $('#ratio_error').text("Plese select grater than 0");
                     return false;
                 }else{

                  form.submit();
                 }
                 
             },
        })
   })
</script>

<script>
   $(document).ready(function(){

      $.validator.addMethod("mintime", function(value, element) {
       
       let time1 = $('#day_learn_period_from').val();
       let time2 = $('#day_learn_period_until').val();
       //console.log(time2);
       if(time1 < time2){

           return true;
       }else{

           return false;
       }


    }, "Plese select valid time");

    $.validator.addMethod("mintime1", function(value, element) {
       
       let time1 = $('#evening_studies_from').val();
       let time2 = $('#evening_studies_until').val();
       //console.log(time2);
       if(time1 < time2){

           return true;
       }else{

           return false;
       }


    }, "Plese select valid time");

        $("#rulesForm").validate({

             rules: {

               day_learn_period_from: {

                    required: true,
               },
               day_learn_period_until: {

                  required: true,
                  mintime: function(element){
                        if($("#day_learn_period_from").val() != ""){
                          return true;
                       }
                  },
               },
               evening_studies_from: {

                  //required: true,
               },
               evening_studies_until: {

                  //required: true,
                  mintime1: function(element){
                        if($("#evening_studies_from").val() != ""){
                          return true;
                       }
                  },
               }
             },
             submitHandler: function(form){

                 form.submit();
             }
        })
   })
</script>

<script>
   $(document).ready(function(){

        $('#otherpetdrop1').click(function(){

              if($('#otherpetdrop1').is(":checked")){

                  $('#otherPet1').css('display','block');
                  $('#other_board').rules('add','required');
              }else{

                  $('#otherPet1').css('display','none');
                  $('#other_board').rules('remove','required');
                  $('#other_board').val('');
                  
              }
        })
   })
</script>
<script>
    $(document).ready(function() {
      let minusBtn = document.getElementById("minus-btn");
      let count = document.getElementById("count");
      let plusBtn = document.getElementById("plus-btn");
      @if(@$schoolDetails->teacher_student_ratio != null)
      let countNum = '{{ @$schoolDetails->teacher_student_ratio }}';
      countNum = parseInt(countNum);
      @else
      let countNum = 0;
      @endif
      count.innerHTML = countNum;
      
      minusBtn.addEventListener("click", () => {
        if (countNum > 0) {
          countNum -= 1;
          count.innerHTML = countNum;
          console.log(countNum);
          $('#teacher_student_ratio').val(countNum);
        }
      });
      
      plusBtn.addEventListener("click", () => {
        countNum += 1;
        count.innerHTML = countNum;
        console.log(countNum);
        $('#teacher_student_ratio').val(countNum);
      });
    })
</script>
<script>
   $(document).ready(function(){

       $('#relationship_id').change(function(){

           let value = $(this).val();
           if(value == '0'){
               
              $('#otherRelationship').css('display','block');
              $('#other_relationship').rules('add','required');
               
           }else{

              $('#otherRelationship').css('display','none');
              $('#other_relationship').rules('remove','required');
              $('#other_relationship').val('');
           }
       })

       $('#submitBtn').click(function(e){
             e.preventDefault();
            let nextUrl = $(this).data('url');
            window.location.href = nextUrl;
       })
   })
</script>
@endsection 