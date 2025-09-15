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
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class="ongoing"><em></em>
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
                     <form action="{{ route('add.school.step7.save') }}" method="post" id="resultForm">
                        @csrf
                        
                        <div class="ad-schl-card adscl-crd12">
                           <div class="row">
                              {{-- <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Year</label>
                                    <select name="year" id="">
                                       <option value="0" selected disabled>Select</option>
                                        @foreach(range(date('Y'),date('Y')-20) as $data)
                                        <option value="{{ @$data }}" @if(@$schoolResult->year == @$data) selected @endif>{{ @$data }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Curriculum</label>
                                    <select name="board_id" id="board_id">
                                       <option value="" selected disabled>Select</option>
                                        @foreach($board as $data)
                                        <option value="{{ @$data->id }}" @if(@$schoolResult->board_id == @$data->id) selected @endif>{{ @$data->board_name }}</option>
                                        @endforeach
                                    </select>
                                 </div>
                              </div> --}}
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Exam <span style="color: red;">*</span></label>
                                    <select name="exam" id="">
                                       <option value="" disabled {{ old('exam') ? '' : 'selected' }}>Select</option>
                                       <option value="Half Yearly" {{ old('exam') == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                       <option value="Annual" {{ old('exam') == 'Annual' ? 'selected' : '' }}>Annual</option>
                                       <option value="Board Exam" {{ old('exam') == 'Board Exam' ? 'selected' : '' }}>Board Exam</option>
                                    </select>
                                    @error('exam')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Ranking position <span style="color: red;">*</span></small></label>
                                    <input type="number" name="ranking_position" placeholder="Enter here" min="0" value="{{ old('ranking_position') }}" />
                                    @error('ranking_position')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Region <span style="color: red;">*</span></label>
                                    <select name="region" id="">
                                       <option value="" disabled {{ old('region') ? '' : 'selected' }}>Select</option>
                                       <option value="International" {{ old('region') == 'International' ? 'selected' : '' }}>International</option>
                                       <option value="National" {{ old('region') == 'National' ? 'selected' : '' }}>National</option>
                                       <option value="Country" {{ old('region') == 'Country' ? 'selected' : '' }}>Country</option>
                                       <option value="N/A" {{ old('region') == 'N/A' ? 'selected' : '' }}>N/A</option>
                                    </select>
                                    @error('region')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Mean score points <span style="color: red;">*</span></label>
                                    <input type="text" name="mean_score_point" placeholder="Enter here" value="{{ old('mean_score_point') }}" />
                                    @error('mean_score_point')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input position-relative g-map">
                                    <label>Mean Grade <span style="color: red;">*</span></label>
                                    <input type="text" name="mean_grade" placeholder="Enter Here" value="{{ old('mean_grade') }}" />
                                    @error('mean_grade')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input position-relative g-map">
                                    <label>Number of candidates <span style="color: red;">*</span></label>
                                    <input type="text" name="no_of_candidate" placeholder="Enter Here" value="{{ old('no_of_candidate') }}" />
                                    @error('no_of_candidate')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              
                              <div class="col-12">
                                 <button class="submit-ratio mt-1" type="submit">Save</button>
                              </div>
                           </div>
                        </div>
                        @if(!empty($examPerformance))
                           <div class="ad-schl-card adscl-crd13">

                              <div class="row">

                                 <div class="col-12">
                                    <div class="step-5-added-loc">
                                       <h2>Added Results</h2>

                                       @foreach($examPerformanceRecords as $data)
                                       <div class="added-subs-box position-relative">
                                          <a href="{{ route('add.school.step7', [md5(@$schoolDetails->id), $data->id]) }}" class="edit-subs">
                                             {{-- SVG ICON --}}
                                             <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                                <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                                <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                             </svg>
                                          </a>
                                          <ul class="new_rsult_d">
                                             <li><h6>Exam</h6><p>: {{ $data['exam'] }}</p></li>
                                             <li><h6>Ranking Position</h6><p>: {{ $data['ranking_position'] }}</p></li>
                                             
                                             <li><h6>Mean Score Points</h6><p>: {{ $data['mean_score_points'] }}</p></li>
                                             <li><h6>Mean Grade</h6><p>: {{ $data['mean_grade'] }}</p></li>
                                             <li><h6>Number of Candidates</h6><p>: {{ $data['number_of_candidates'] }}</p></li>
                                          </ul>
                                       </div>
                                       @endforeach

                                    </div>
                                 </div>
                              </div>

                           </div>
                        @endif
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button class="completeBtn" data-url="{{ route('add.school.step8') }}">Save and Complete <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 <a href="{{ route('add.school.step6') }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                                 <a href="{{ route('add.school.step8') }}">
                                    Skip 
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg> 
                                 </a>
                              </div>
                              <p>Step 7 Of 9</p>
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

        $('#resultForm').validate({

             rules: {

               year: {

                  required: true,
               },
               board_id: {

                  required: true,
               },
               exam: {

                  required: true,
               },
               ranking_position: {

                  required: true,
               },
               mean_score_point: {

                  required: true,
               },
               mean_grade: {

                  required: true, 
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

        $('.addResul').click(function(e){
             e.preventDefault();
             const grade_arr = [];
             //$('#no_of_candidate').rules('add','required');
             $("input[name='grade[]']").each(function(){

                  let value = $(this).val();
                  grade_arr.push(value);
             })
             let grade = $('#grade').val();
             let no_of_candidate = $('#no_of_candidate').val();
             if(grade_arr.includes(grade)){

             }else{

               if(no_of_candidate != ''){
               let html = `<div class="col-lg-5 col-sm-6">
                   <input type="hidden" name="grade[]"  value="${grade}" placeholder="Enter here">
                   <input type="hidden" name="no_of_candidate[]" value="${no_of_candidate}" placeholder="Enter here">
                        <div class="added-fees position-relative">
                           <h5>${grade}</h5>
                           <p>Number of candidates: <b> ${no_of_candidate} </b> </p>
                           <a href="javascript:;" class="position-absolute removeResult">
                              <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path opacity="0.4" d="M13.914 6.72065C13.914 6.76881 13.5365 11.5435 13.3209 13.553C13.1859 14.7862 12.3909 15.5341 11.1984 15.5554C10.2822 15.5759 9.38525 15.583 8.50278 15.583C7.56589 15.583 6.64966 15.5759 5.7603 15.5554C4.60779 15.5278 3.81212 14.7649 3.68398 13.553C3.46216 11.5364 3.09154 6.76881 3.08465 6.72065C3.07776 6.57545 3.1246 6.43733 3.21967 6.32541C3.31336 6.222 3.44838 6.15967 3.59029 6.15967H13.4153C13.5565 6.15967 13.6846 6.222 13.7859 6.32541C13.8803 6.43733 13.9278 6.57545 13.914 6.72065Z" fill="black"></path>
                                 <path d="M14.875 4.23345C14.875 3.94233 14.6456 3.71426 14.37 3.71426H12.3047C11.8845 3.71426 11.5194 3.41535 11.4257 2.99391L11.31 2.47755C11.1481 1.85353 10.5894 1.4165 9.96252 1.4165H7.03817C6.40439 1.4165 5.85121 1.85353 5.68312 2.51155L5.57497 2.99462C5.48059 3.41535 5.11548 3.71426 4.69594 3.71426H2.63065C2.3544 3.71426 2.125 3.94233 2.125 4.23345V4.5026C2.125 4.78664 2.3544 5.02179 2.63065 5.02179H14.37C14.6456 5.02179 14.875 4.78664 14.875 4.5026V4.23345Z" fill="black"></path>
                              </svg>
                           </a>
                        </div>
                     </div>`;

                $('#result_show').append(html);
                $('#grade').val('');
                $('#no_of_candidate').val(''); 
                  
                }else{

                 alert("Please select grade and number of candidate");
                }
             }
             
                
        })


      
   })
</script>
<script>
     $('body').on('click','.removeResult',function(){

            $(this).parent().parent().remove();
        })

        $('.completeBtn').click(function(e){
             
            e.preventDefault();
             let url = $(this).data('url');

             window.location.href = url;
        })
</script>
@endsection