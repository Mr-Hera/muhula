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
                              <li class="ongoing"><em></em>
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
                    
                        <div class="ad-schl-card adscl-crd2">
                        <form action="{{ route('add.school.step3.save') }}" method="POST" enctype="multipart/form-data" id="schoolForm">
                        @csrf
                        {{-- <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                        <input type="hidden" name="status" id="stepStatus"> --}}
                           <div class="row">
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label for="">School Logo</label>
                                    <div class="row align-items-center">
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uplodimgfil2">
                                             <input type="file" name="school_logo" id="school_logo" class="inputfile2 inputfile-1" data-multiple-caption="{count} files selected">
                                             <label for="school_logo">                                          
                                                <h3>Click here to upload </h3>
                                                <img src="{{ asset('images/upload1.png') }}" alt="">
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uploaded-img position-relative">
                                              {{-- @if(@$schoolDetails->school_logo != null)
                                              <img src="{{ URL::to('storage/app/public/images/school_logo') }}/{{ @$schoolDetails->school_logo }}" alt="">
                                              @endif --}}
                                             {{--<a href="#" class="upld-img-del position-absolute">
                                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.25 2.75L2.75 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2.75 2.75L8.25 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                             </a>--}}
                                          </div>
                                       </div>
                                    </div>                                
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="check_gender adscl-type">
                                    <ul>
                                       <li>
                                          <input type="radio" name="ownership_type" id="ownership_type_public" value="Public">
                                          <label for="ownership_type_public">
                                             <p>Public</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="ownership_type" id="ownership_type_private" value="Private">
                                          <label for="ownership_type_private">
                                             <p>Private</p>
                                          </label>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Year of Establishment <small>(Optional)</small></label>
                                    <input type="text" name="year_of_establishment" id="year_of_establishment" placeholder="Enter here" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>School Levels</label>
                                    <select multiple name="school_level_id[]" id="school_level" class="filter-multi-select">
                                       @foreach($school_levels as $level)
                                          <option value="{{ $level->id }}" >{{ $level->name }}</option>
                                       @endforeach
                                   </select>
                                   <label id="school_level[]-error" class="error" for="school_level[]" style="display:none;">This field is required.</label>
                                 </div>
                                 
                              </div>
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label>Board</label>
                                    <ul class="category-ul agree d-flex justify-content-start align-items-center flex-wrap row-gap-2">
                                       @if($school_curricula)
                                          @foreach($school_curricula as $curriculum)
                                             <li>
                                                <div class="radiobx">
                                                   <label for="">{{ $curriculum->name }}
                                                      <input type="checkbox" value="{{ $curriculum->name }}" curriculum-board_name="{{ $curriculum->board_name }}" name="curricula[]"  id="{{ $curriculum->name }}"
                                                         class="quote-label" />
                                                      <span class="checkbox"></span>
                                                   </label>
                                                </div>
                                             </li>
                                          @endforeach
                                       @endif
                                       <li>
                                          <div class="radiobx">
                                             <label for="">Others
                                                  <input type="checkbox" name="board_id" id="otherpetdrop1" class="board" data-board_name="Others">
                                                  <span class="checkbox"></span>
                                              </label>
                                          </div>
                                       </li>                                   
                                    </ul>
                                    <label id="board[]-error" class="error" for="board[]" style="display:none;">This field is required.</label>
                                 </div>
                              </div>
                              {{-- <div class="col-lg-6 col-md-6" id="otherPet1" style="display:none;">
                                 <div class="dash_input">
                                    <label>Other Board</label>
                                    <input type="text" name="other_board" id="other_board" value="" placeholder="Enter here">
                                 </div>
                              </div> --}}
                              
                              <div class="clearfix"></div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input mb-1">
                                    <label>Gender</label>
                                 </div>
                                 <div class="check_gender adscl-type">
                                    <ul>
                                       <li>
                                          <input type="radio" name="gender_is_male" id="gender_is_male" value="Male" />
                                          <label for="gender_is_male">
                                             <p>Male</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="gender_is_female" id="gender_is_female" value="Female" />
                                          <label for="gender_is_female">
                                             <p>Female</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="gender_is_mixed" id="gender_is_mixed" value="Mixed" />
                                          <label for="gender_02">
                                             <p>Both</p>
                                          </label>
                                       </li>
                                    </ul>
                                 </div>
                                 <label id="gender-error" class="error" for="gender" style="display:none;">This field is required.</label>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input mb-1">
                                    <label>Type</label>
                                 </div>
                                 <div class="check_gender adscl-type adscl-tp2">
                                    <ul>
                                       <li>
                                          <input type="radio" name="school_type_id" id="gender_04" value="{{ $school_types_day->id }}" />
                                          <label for="gender_01">
                                             <p>Day</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="school_type_id" id="gender_05" value="{{ $school_types_boarding->id }}"/>
                                          <label for="gender_02">
                                             <p>Boarding</p>
                                          </label>
                                       </li>
                                       <li>
                                          <input type="radio" name="school_type_id" id="gender_06" value="{{ $school_types_day_n_boarding->id }}"/>
                                          <label for="gender_02">
                                             <p>Day & boarding</p>
                                          </label>
                                       </li>
                                    </ul>
                                 </div>
                                 <label id="boarding_type-error" class="error" for="boarding_type" style="display:none;">This field is required.</label>
                              </div>

                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label style="text-transform: none !important;">What is your Relationship with this School?</label>
                                    <select name="contact_relationship_id" id="contact_relationship_id">
                                        <option value="">Select</option>
                                         @foreach($school_contact_positions as $position)
                                          <option value="{{ $position->id }}" >{{ $position->name }}</option>
                                         @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6" style="display:none;" id="otherRelationship">
                                 <div class="dash_input">
                                    <label>Other Relationship</label>
                                    <input type="text" name="other_relationship" id="other_relationship" placeholder="Enter here">
                                 </div>
                              </div>

                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Religion <small>(Optional)</small></label>
                                    <select name="religion_id" id="religion_id">
                                        <option value="">Select</option>
                                         @foreach($school_religion as $religion)
                                         <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                         @endforeach
                                    </select>
                                 </div>
                              </div>

                           </div>
                           <h2 class="mt-4">Facilities / Amenities</h2>
                           <div class="row">
                              <div class="col-12">
                                <div class="amenities-select">
                                 <div class="row">
                                    @if($facilities)
                                       @foreach($facilities as $facility)
                                          <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                             <div class="radiobx amn-div">
                                                <label for="">{{ $facility->name }}
                                                   <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"/>
                                                   <span class="checkbox"></span>
                                                </label>
                                             </div>
                                          </div>
                                       @endforeach
                                    @endif
                                 </div>
                                 <label id="facilities[]-error" class="error" for="facilities[]" style="display:none;">This field is required.</label>
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Other Facilities / Amenities</label>
                                    <input type="text" name="other_facilities" placeholder="Enter here">
                                 </div>
                              </div>
                           </div>
                           <div class="col-12">
                           <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                           </div>
                           </form>
                        </div>
                        
                        <div class="ad-schl-card adscl-crd6">
                           <h2>Uniform</h2>
                           <form action="{{ route('add.school.step3.uniform.save') }}" method="post" enctype="multipart/form-data" id="uniformForm">
                            @csrf
                            {{-- <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                            <input type="hidden" name="school_uniform_id" id="">                          --}}
                           <div class="row">
                           
                                 <div class="col-12">
                                    <div class="uni-type">
                                       <label for="uniform_type_male" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_male" value="Male" checked>
                                          <span class="uni-text"><img src="{{ asset('images/uni-male.png') }}" alt="">Male</span>                            
                                       </label>
                                       <label for="uniform_type_female" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_female" value="Female">
                                          <span class="uni-text"><img src="{{ asset('images/uni-female.png') }}" alt="">Female</span>                            
                                       </label>
                                       <label for="uniform_type_mixed" class="uni-label">
                                          <input type="radio" name="uniform_type" id="uniform_type_mixed" value="Mixed">
                                          <span class="uni-text"><img src="{{ asset('images/uni-unisex.png') }}" alt="">Unisex</span>                            
                                       </label>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="dash_input">
                                       <label>Uniform Title <small>(Optional)</small></label>
                                       <input type="text" name="uniform_title" id="uniform_title" placeholder="Enter here">
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="dash_input">
                                       <label>Uniform Image</label>
                                       <div class="uplodimgfil2">
                                          <input type="file" name="uniform_image" id="uniform_image" class="inputfile2 inputfile-1">
                                          <label for="uniform_image">                                          
                                             <h3>Click here to upload </h3>
                                             <img src="{{ asset('images/upload1.png') }}" alt="">
                                          </label>
                                       </div>
                                       <label for="" id="showFilename" style="display:none;"></label>
                                       <label id="uniformImage_error" for="" class="error" style="display:none;"></label>
                                    </div>                              
                                 </div>
                                   <div class="col-12">
                                          <button class="submit-ratio" type="submit">+ &nbsp;Save</button>
                                 </div>
                                 <div class="col-12">
                                    <div class="uploaded-uniform">
                                        @if(@$school_uniform)
                                        @foreach($school_uniform as $data)
                                       <div class="upld-uniform-div">
                                          <em>
                                             @if(@$data->uniform_image != null)
                                             <img src="{{ URL::to('storage/app/public/images/uniform_image') }}/{{ @$data->uniform_image }}" alt="">
                                             @endif
                                           </em>
                                          <h6>
                                             @if(@$data->uniform_type == 'M')
                                             Male
                                             @elseif(@$data->uniform_type == 'F')
                                             Female
                                             @elseif(@$data->uniform_type == 'U')
                                             Unisex
                                             @endif
                                          </h6>
                                          <p>{{ @$data->uniform_title }}</p>
                                          <a href="{{ route('school.uniform.delete',@$data->id) }}" class="uni-delet">
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 3L3 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M3 3L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                       
                                          </a>
                                       </div>
                                       @endforeach
                                       @endif
                                       {{--<div class="upld-uniform-div">
                                          <em><img src="{{ url('public/images/uniform-girl.png') }}" alt=""></em>
                                          <h6>Female</h6>
                                          <p>Uniform title here</p>
                                          <a href="javascript:void(0);" class="uni-delet">
                                             <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 3L3 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M3 3L9 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                       
                                          </a>
                                       </div>--}}
                                    </div>
                                 </div>
                           </div> 
                           </form>                      
                        </div>
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button type="submit" id="submitBtn" data-value="CO">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 <a href="{{ route('add.school.step2',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 3 Of 9</p>
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

      $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters");

        $('#schoolForm').validate({

              rules: {

                school_logo: {

                    //required: true,
                },
                year_of_establishment: {

                   digits: true,
                   maxlength: 4,
                   min: 1200,
                    max: "{{ date('Y') }}",  
                },
                'school_type[]': {

                  required: true,
                },
                'facilities[]': {

                  //required: true,
                },
                 'board[]': {

                  required: true,
                },
                order_board: {

                  name_Regex: true,
                },
                gender: {

                  required: true,
                },
                boarding_type: {

                  required: true,
                },
                language_instruction_id: {

                    //required: true,
                },

              },
              ignore:[],
              messages: {

                 year_of_establishment:{

                   maxlength: "Please enter 4 digits",
                 },
              },
              submitHandler: function(form) {
                 $('#submitBtn').prop('disabled',true);
                 
                  form.submit();
              
              },
        })



        $('#submitBtn').click(function(e){

           e.preventDefault();
           let value = $(this).data('value');
           $('#stepStatus').val(value);
           $('#schoolForm').submit();

           
      })
   })
</script>
    <script>
     $("#school_logo").change(function () {
            $('.uploaded-img').html('');
            let files = this.files;
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif','image/jpg'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#school_logo").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uploaded-img').append('<img src="'+e.target.result+'" alt="">');
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>
<script>
   $(document).ready(function(){

        $('#otherpetdrop1').click(function(){

              if($('#otherpetdrop1').is(":checked")){

                  $('#otherPet1').css('display','block');
                  $('#other_board').rules('add','required');
                  $("input[name='board[]']").rules('remove','required');
              }else{

                  $('#otherPet1').css('display','none');
                  $('#other_board').rules('remove','required');
                  $("input[name='board[]']").rules('add','required');
                  $('#other_board').val('');
                  
              }
        })
   })
</script>
<script>
   $(document).ready(function(){

      $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters and numbers");

        $('#uniformForm').validate({

             rules: {

               uniform_image: {

                    required: true,
               },
               uniform_title: {

                  //required: true,
                  name_Regex: true,
               }
             },
             submitHandler: function(form){
                let filename = $('#uniform_image').val();
                console.log(filename);
                if(filename == ''){

                    $('#uniformImage_error').html('Please upload a uniform image');
                    $('#uniformImage_error').css('display','block');
                    return false;
                }else{

                  form.submit();
                }
             }
        })
   })
</script>
<script>
   $(document).ready(function(){

        $('#uniform_image').change(function(){
           $('#showFilename').html('');
             let filename = this.files[0].name;
             $('#showFilename').css('display','block');
             $('#showFilename').html(filename);
        })

      //   $('.board_id').change(function(){

      //        let board_id = $(this).val();
      //        if(board_id == 5){

      //            $('#add_new').css('display','block');
      //        }else{

      //          $('#add_new').css('display','none');
      //        }
      //   })

      

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
   })
</script>
@endsection 