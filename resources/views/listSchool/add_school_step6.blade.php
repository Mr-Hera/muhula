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
                              {{-- <li class="done"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                    <h6>School Register</h6>
                                 </div>                                 
                              </li> --}}
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                 <h6>Basic Information</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 2</small>
                                 <h6>School Details</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 3</small>
                                 <h6>Extra Info</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 4</small>
                                 <h6>School Gallery</h6>
                                 </div>
                                 
                              </li>
                              <li class="ongoing"><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 6</small>
                                    <h6>Result</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 7</small>
                                    <h6>Branches</h6>
                                 </div>                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 8</small>
                                    <h6>School Fees</h6>
                                 </div>                                 
                              </li>
                           </ul>
                        </div>
                     </div>
                     
                     
                        <div class="ad-schl-card adscl-crd9">
                           <h2>Add Subject</h2>
                           <form action="{{ route('add.school.step6.subject.save') }}" method="post" enctype="multipart/form-data" id="subjectForm">
                              @csrf
                              
                              <div class="row">
                                 {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="dash_input">
                                       <label>Curriculum </label>
                                       <select name="curriculum_id" id="board_id" class="board_id">
                                          <option value="" >Select</option>
                                          @foreach($curricula as $curriculum)
                                             <option value="{{ $curriculum->id }}" >{{ $curriculum->name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div> --}}
                                 {{-- <div class="col-12">
                                    <div class="row align-items-center">
                                       <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="new_class_level">
                                          <div class="dash_input">
                                             <label>Class Level </label>
                                             <select name="school_level_id" id="class_level">
                                                <option value="">Select</option>
                                                @foreach($school_levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                @endforeach
                                             </select>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-6 col-12" id="otherPet" @if(@$schoolDetails->curriculum == 5) style="display:block;" @else style="display: none;" @endif>
                                          <div class="dash_input">
                                             <label>Class Level </label>
                                             <input type="text" name="other_class_level" id="other_class_level" placeholder="Enter here">
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                          <ul class="add-grade agree d-flex justify-content-start align-items-center">
                                             <li>
                                                <div class="radiobx" id="add_new">
                                                   <label for="">Add New
                                                      <input type="checkbox" name="" id="otherpetdrop">
                                                      <span class="checkbox"></span>
                                                   </label>
                                                </div>
                                             </li>                              
                                          </ul>
                                       </div>
                                    </div>
                                 </div> --}}
                                 <div class="col-12">
                                    <div class="dash_input">
                                       <label>Select Subjects:</label>
                                       <ul class="category-ul subs-list agree d-flex justify-content-start align-items-center flex-wrap">
                                          @if($courses)
                                             @foreach($courses as $course)
                                             <li class="mb-1">
                                                <div class="radiobx">
                                                   <label for="">{{ $course->name }}
                                                      <input type="checkbox" name="courses[]" value="{{ $course->id }}" />
                                                      <span class="checkbox"></span>
                                                   </label>
                                                </div>
                                             </li>
                                             @endforeach
                                          @endif                                  
                                       </ul>
                                       <label id="subject[]-error" class="error" for="courses[]" style="display:none;">This field is required.</label>
                                    </div>
                                    
                                 </div>
                                 <div class="col-lg-6 col-md-6">
                                    <div class="dash_input">
                                       <label>Other subjects </label>
                                       <input type="text" name="other_subject" placeholder="Enter here">
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <button class="submit-ratio mt-1" type="submit">+ &nbsp;Add</button>
                                 </div>
                                 <div class="col-12">
                                    <div class="added-subs-div">
                                       @if(!empty($selectedCourses))
                                          <h2>Added Subject</h2>
                                          @foreach($selectedCourses as $course)
                                             <div class="added-subs-box position-relative">
                                                <a href="{{ route('add.school.step6') }}" class="edit-subs" style="right: 42px">
                                                   <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                                      <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                                      <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                                   </svg>
                                                </a>
                                                <a href="{{ route('school.subject.delete', [$course['id']]) }}" class="edit-subs" onclick="return confirm('Do you want to delete this subject?')">
                                                   <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                      <path opacity="0.4" d="M13.9121 6.72089C13.9121 6.76906 13.5346 11.5438 13.3189 13.5532C13.1839 14.7864 12.3889 15.5344 11.1965 15.5556C10.2802 15.5762 9.3833 15.5833 8.50083 15.5833C7.56393 15.5833 6.64771 15.5762 5.75835 15.5556C4.60583 15.528 3.81016 14.7652 3.68203 13.5532C3.46021 11.5367 3.08958 6.76906 3.0827 6.72089C3.07581 6.57569 3.12265 6.43757 3.21772 6.32566C3.31141 6.22224 3.44643 6.15991 3.58834 6.15991H13.4133C13.5545 6.15991 13.6827 6.22224 13.7839 6.32566C13.8783 6.43757 13.9258 6.57569 13.9121 6.72089Z" fill="black"/>
                                                      <path d="M14.875 4.23357C14.875 3.94245 14.6456 3.71438 14.37 3.71438H12.3047C11.8845 3.71438 11.5194 3.41547 11.4257 2.99403L11.31 2.47767C11.1481 1.85365 10.5894 1.41663 9.96252 1.41663H7.03817C6.40439 1.41663 5.85121 1.85365 5.68312 2.51167L5.57497 2.99474C5.48059 3.41547 5.11548 3.71438 4.69594 3.71438H2.63065C2.3544 3.71438 2.125 3.94245 2.125 4.23357V4.50273C2.125 4.78676 2.3544 5.02192 2.63065 5.02192H14.37C14.6456 5.02192 14.875 4.78676 14.875 4.50273V4.23357Z" fill="black"/>
                                                   </svg>
                                                </a>
                                                <ul>
                                                   <li>
                                                      <h6>Subjects&nbsp;</h6>
                                                      <p>:&nbsp;{{ $course['name'] ?? 'N/A' }}</p>
                                                   </li>
                                                </ul>
                                             </div>
                                          @endforeach
                                       @endif
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     <form action="{{ route('add.school.step7',[md5(@$schoolDetails->id)]) }}">
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button type="submit">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                     </button>
                                 <a href="{{ route('add.school.step5',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 6 Of 9</p>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="add-schl-r8">
                     <div class="ad-schl-rtcrd">                        
                        <em><span class="cardimg-line-top"></span><img src="{{ url('public/images/ad-schl-rt.png') }}" alt=""><span class="cardimg-line-bottom"></span></em>   
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

        $('#subjectForm').validate({

             rules: {

               board_id: {

                   required: true,
               },
               class_level: {

                  required: function(){

                      let other_level = $('#other_class_level').val();
                      if(other_level == '')
                      return true;
                     else
                     return false;
                  }
               },
               'subject[]': {

                  required: true,
               }

             },
             ignore: [],
             submitHandler: function(form){

                 form.submit();
             }
             
        })
   })
</script>
<script>
   $('.board_id').change(function(){
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'board_id'    : $(this).val()
                }
            };
            $.ajax(
            {
                url: '{{ route('get.class.level') }}',
                dataType: 'json',
                data: reqData,
                type: 'post',
                success: function(response)
                {
                  $('#class_level').html('');
                    console.log(response)
                    html='<option value="">Select</option>';
                         response.result.classLevel.forEach(function(item, index){
                             html+='<option value="'+item.id+'">'+item.class_level+'</option>';
                         });
                         $('#class_level').html(html);

                },
                error:function(error)
                {
                    console.log(error.responseText);
                }
            });
        });
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

        $('#otherpetdrop').click(function(){

            if($('#otherpetdrop').is(':checked')){

                 $('#new_class_level').css('display','none');
                 $('#otherPet').css('display','block');
                 $('#other_class_level').rules('add','required');
            }else{

               $('#new_class_level').css('display','block');
                 $('#otherPet').css('display','none');
                 $('#other_class_level').rules('remove','required');
            }
        })


   })
</script>
@endsection 