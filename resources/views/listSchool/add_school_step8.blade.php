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
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 5</small>
                                 <h6>Subject/ Courses</h6>
                                 </div>
                                 
                              </li>
                              <li class="done"><em></em>
                                 <div>
                                    <small>Step 6</small>
                                    <h6>Result</h6>
                                 </div>                                 
                              </li>
                              <li class="ongoing"><em></em>
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
                     <form action="{{ route('add.school.step8.save') }}" method="post" enctype="multipart/form-data" id="branchForm">
                        @csrf
                        
                        <div class="ad-schl-card adscl-crd12">
                           <label>If no branches are available click 
                              <a href="{{ route('add.school.step9') }}"><span style="color: red;"><b>"Here"</b></span></a>
                           </label><br>
                           <label></label><br>
                           <div class="row">
                              <div class="col-12">
                                 {{-- <ul class="add-grade agree schl-same">
                                    <li>
                                       <div class="radiobx">
                                          <label for="">Same School Name
                                             <input type="checkbox" name="school_master_name" id="school_master_name" value="{{ $school_branches->name ?? "Not Set" }}" class="checkme">
                                             <span class="checkbox"></span>
                                          </label>
                                       </div>
                                    </li>                              
                                 </ul> --}}
                                 <div class="dash_input">
                                    <label>School Name <span style="color: red;">*</span></label>
                                    <input type="text" name="school_name" id="school_name" placeholder="Enter here" value="{{ old('school_name', optional($schoolBranchDetails)->school_name) }}">
                                    @error('school_name')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>School Type <span style="color: red;">*</span></label>
                                    <select multiple name="school_type[]" id="school_type" class="filter-multi-select">
                                       @foreach($school_levels as $level)
                                          <option value="{{ $level->id }}" {{ in_array($level->id, old('school_type', [])) ? 'selected' : '' }}>{{ $level->name }}</option>
                                       @endforeach
                                    </select>
                                    @error('school_type')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                                 
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Country <span style="color: red;">*</span></label>
                                    <select name="country" id="country">
                                       <option value="">Select</option>
                                       @foreach($countries as $country)
                                       <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                       @endforeach
                                    </select>
                                    @error('country')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              {{--<div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>constituency</label>
                                    <input type="text" name="constituency" id="constituency" placeholder="Enter here" value="{{ @$schoolBranchDetails->constituency }}">
                                 </div>
                              </div>--}}
                              <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                    <label>Town
                                       <span class="d-inlne-block ml-1 tooltip-main position-relative">
                                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                                          <div class="tooltip-body position-absolute">If town is missing scroll to bottom & select other to add missing town.</div>
                                       </span>
                                       <span style="color: red;">*</span>
                                    </label>
                                    <select name="town" id="town">
                                       <option value="">Select</option>
                                          @foreach($counties as $county)
                                             <option value="{{ $county->id }}" {{ old('town') == $county->id ? 'selected' : '' }}>{{ $county->name }}</option>
                                          @endforeach
                                       <option value="0" {{ old('town') == "0" ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('town')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6" style="display:none;" id="otherTown">
                                 <div class="dash_input">
                                    <label>Other Town</label>
                                    <input type="text" name="other_town" id="other_town" placeholder="Enter here" value="{{ old('other_town') }}" />
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label>Full Address <span style="color: red;">*</span></label>
                                    <input type="text" name="full_address" id="full_address" placeholder="Enter here" value="{{ old('full_address') }}" />
                                    @error('full_address')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="dash_input position-relative g-map">
                                    <label>Google map location</label>
                                    <input type="text" name="google_location" id="google_location" placeholder="Enter / paste link here" value="{{ old('google_location') }}">
                                    <img src="{{ asset('images/google-map.png') }}" alt="" class="position-absolute">
                                    <input type="hidden" name="google_lat" id="lat" value="{{ old('google_lat', optional($schoolBranchDetails)->google_lat) }}">
                                    <input type="hidden" name="google_long" id="long" value="{{ old('google_lat', optional($schoolBranchDetails)->google_lat) }}">
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Email  <span style="color: red;">*</span></label>
                                    <input type="text" name="email" id="email" placeholder="Enter here" value="{{ old('email') }}" />
                                    @error('email')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Phone  <span style="color: red;">*</span></label>
                                    <input type="text" name="phone" id="phone" placeholder="Enter here" value="{{ old('phone') }}" />
                                    @error('phone')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="step5-imgupld">
                                    <div class="uplodimgfil upld-schl-images">
                                       <input type="file" name="school_image[]" id="school_image" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="">
                                       <label for="school_image">
                                          <img src="{{ asset('images/upload.png') }}" alt="">
                                          <h3>Upload School Images</h3>
                                       </label>
                                    </div>
                                    @error('school_image')
                                       <label class="error">{{ $message }}</label>
                                    @enderror
                                    <div class="upldd-scl-imgs">
                                       {{-- @if(@$schoolBranchImage)
                                       @foreach($schoolBranchImage as $data)
                                       <em class="schl-img-nw">
                                          @if(@$data->image != null)
                                          <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$data->image }}" alt="">
                                          @endif
                                          <a href="{{ route('school.branch.image.delete',@$data->id) }}">
                                             <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.25 2.75L2.75 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2.75 2.75L8.25 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                       
                                          </a>
                                       </em>
                                       @endforeach
                                       @endif --}}
                                    </div>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <button class="submit-ratio mt-1" type="submit"><span>+</span> &nbsp;Add</button>
                              </div>
                           </div>
                        </div>
                        
                        @if(@$school_branches->isNotEmpty())
                        <div class="ad-schl-card adscl-crd13">
                           <div class="row">
                              <div class="col-12">
                                 <div class="step-5-added-loc">
                                    
                                    <h2>Added Branches</h2>
                                    @foreach($school_branches as $branch)
                                    <div class="added-subs-box position-relative">
                                       <a href="{{ route('add.school.step8',[md5(@$schoolDetails->id),$branch->id]) }}" class="edit-subs">
                                          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path opacity="0.4" d="M15.827 15.0049H11.319C10.8792 15.0049 10.5215 15.3683 10.5215 15.8151C10.5215 16.2627 10.8792 16.6252 11.319 16.6252H15.827C16.2668 16.6252 16.6245 16.2627 16.6245 15.8151C16.6245 15.3683 16.2668 15.0049 15.827 15.0049Z" fill="black"/>
                                             <path d="M8.16131 5.4654L12.433 8.91713C12.5361 8.99968 12.5537 9.15117 12.4732 9.25669L7.409 15.8555C7.09066 16.2631 6.62151 16.4938 6.11886 16.5023L3.35426 16.5363C3.20682 16.538 3.0778 16.4359 3.04429 16.2895L2.41597 13.5577C2.30706 13.0556 2.41597 12.5365 2.73432 12.1365L7.82369 5.50625C7.90579 5.39987 8.05743 5.38115 8.16131 5.4654Z" fill="black"/>
                                             <path opacity="0.4" d="M14.3455 6.86014L13.522 7.88817C13.4391 7.99285 13.2899 8.00987 13.1869 7.92647C12.1858 7.1163 9.62224 5.03725 8.91099 4.46111C8.80711 4.37601 8.79286 4.22453 8.87664 4.119L9.67083 3.13267C10.3913 2.20506 11.6479 2.11996 12.6616 2.92843L13.8261 3.85604C14.3036 4.23049 14.622 4.72408 14.7309 5.2432C14.8566 5.81423 14.7225 6.37506 14.3455 6.86014Z" fill="black"/>
                                          </svg>                                             
                                       </a>
                                       <ul>
                                          <li>
                                             <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_3330_670)">
                                                <path d="M13.6355 6.25C13.6355 10.625 7.79188 14.375 7.79188 14.375C7.79188 14.375 1.94824 10.625 1.94824 6.25C1.94824 4.75816 2.56391 3.32742 3.6598 2.27252C4.7557 1.21763 6.24205 0.625 7.79188 0.625C9.34171 0.625 10.8281 1.21763 11.924 2.27252C13.0199 3.32742 13.6355 4.75816 13.6355 6.25Z" stroke="#32CD32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M7.79208 8.125C8.86811 8.125 9.7404 7.28553 9.7404 6.25C9.7404 5.21447 8.86811 4.375 7.79208 4.375C6.71605 4.375 5.84375 5.21447 5.84375 6.25C5.84375 7.28553 6.71605 8.125 7.79208 8.125Z" stroke="#32CD32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                             </svg>                                                
                                             <h5>{{ $branch->full_address }}</h5>
                                          </li>
                                          <li>
                                             <h6>School Name&nbsp;</h6>
                                             <p>:&nbsp; {{ $branch->school_name }}</p>
                                          </li>
                                          @if($branch->school_types)
                                          <li>
                                             <h6>School Type&nbsp;</h6>
                                             <p>:&nbsp; 
                                                @if($branch->school_types)
                                                @foreach(@$branch->school_types as $key=>$type)
                                                {{ $key > 0 ?',':'' }} {{ $type->school_type }}
                                                @endforeach
                                                @endif
                                             </p>
                                          </li>
                                          @endif
                                          <li>
                                             <h6>Country &nbsp;</h6>
                                             <p>:&nbsp; {{ $branch->getCountry->name }}</p>
                                          </li>
                                          {{--<li>
                                             <h6>Constituency&nbsp;</h6>
                                             <p>:&nbsp; {{ @$branch->constituency }}</p>
                                          </li>--}}
                                          @if($branch->town != null)
                                          <li>
                                             <h6>Town&nbsp;</h6>
                                             <p>:&nbsp; {{ $branch->getTown->city }}</p>
                                          </li>
                                          @endif
                                          @if($branch->contact_email != null)
                                          <li>
                                             <h6>Email&nbsp;</h6>
                                             <p>:&nbsp; {{ $branch->contact_email }}</p>
                                          </li>
                                          @endif
                                          @if($branch->contact_phone != null)
                                          <li>
                                             <h6>Phone&nbsp;</h6>
                                             <p>:&nbsp; {{ $branch->contact_phone }}</p>
                                          </li>
                                          @endif
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
                                 <button type="submit">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 <a href="{{ route('add.school.step7') }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                                 <a href="{{ route('add.school.step9') }}" width="50px;">
                                    No Affiliate  
                                 </a>
                              </div>
                              <p>Step 8 Of 9</p>
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
<script src="" async defer></script>
<script>
   $(document).ready(function(){

      $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
    }, "Please enter only letters");

    $.validator.addMethod("town_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s\-]+$/.test(value);
    }, "Please enter only letters");

        $('#branchForm').validate({

              rules: {
                school_name: {

                    required: true,
                    name_Regex: true, 
                },
                'school_type[]': {

                  required: true,
                },
                country: {

                  required: true,
                },
                town: {

                  required: true,
                },
                 other_town: {

                  town_Regex: true,
                },
                constituency: {

                  required: true,
                },
                full_address: {

                  required: true,
                },
                google_location: {

                  required: true,
                },
                email: {

                  validate_email: true,
                },
                phone: {

                    digits: true,
                    maxlength: 10,
                    minlength: 10,
                },
                 'school_image[]': {
         
                  required: function(){

                       var image = $('#exist_image').val();
                       if(image == 0)
                       return true;
                       else
                       return false;
                  }
               },

              },
              ignore: [],
              submitHandler: function(form) {
           
                  form.submit();
              },
        })
   })
</script>



<script>
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('google_location');

        var options = {
          types: ['establishment']
        };

        var input = document.getElementById('google_location');
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place)
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#lat').val(place.geometry.location.lat());
            $('#long').val(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            $('.exct_btn').show();

            initMap();
        });
        initMap();
    }
</script>

<script>

    function initMap() {
        geocoder = new google.maps.Geocoder();
        var lat = $('#lat').val();
        var lng = $('#long').val();
        var myLatLng = new google.maps.LatLng(lat, lng);
        // console.log(myLatLng);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Choose hotel location',
          draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt,status){
        $('#lat').val(evt.latLng.lat());
        $('#long').val(evt.latLng.lng());
        var lat_1 = evt.latLng.lat();
        var lng_1 = evt.latLng.lng();
        var latlng = new google.maps.LatLng(lat_1, lng_1);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#google_location').val(results[0].formatted_address);
                }
            });


        });
    }
    </script>
<script>
$(document).ready(function(){

      $('.checkme').click(function(){

            if($('.checkme').is(':checked')){

                 let school_name = $('#school_master_name').val();
                 $('#school_name').val(school_name);
            }else{

               $('#school_name').val('');
            }
      })

      $('.continueBtn').click(function(e){

           e.preventDefault();
           let url = $(this).data('url');

           window.location.href = url;

      })
})
</script>
<script>
     $("#school_image").change(function () {
            //$('.images-sec').html('');
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
                    $("#school_image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        let html = `<em class="schl-img-nw">
                                          <img src="${e.target.result}" alt="">
                                          <a href="javascript:void(0);" class="delete_image">
                                             <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.25 2.75L2.75 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M2.75 2.75L8.25 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>                                      
                                          </a>
                                       </em>`;
                        $('.upldd-scl-imgs').append(html);
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>
<script>
   $(document).on('click','.delete_image',function(){

// var image = document.getElementById('file-3').files;

 $(this).parent('.schl-img-nw').remove();

 // var html='';
 // for (i = 0; i < document.getElementById('file-3').files.length; ++i) {
 //     console.log(i)
 //     var ii=document.getElementById('file-3').files[i];
 //     var b=URL.createObjectURL(ii);
 //     html = html+`<li><div class="upimg"><img src="`+b+`"><a href="javascript:;" class="delete_image"><img src="{{ URL::to('public/frontend/images/w-cross.png')}}"></a></div></li>`;
 // }
 // $('#file-3-ul').html(html);
 // console.log(html)
});
</script>
<script>
   $(document).ready(function(){

       $('#town').change(function(){

           let value = $(this).val();
           if(value == '0'){
               
              $('#otherTown').css('display','block');
              $('#other_town').rules('add','required');
               
           }else{

              $('#otherTown').css('display','none');
              $('#other_town').rules('remove','required');
              $('#other_town').val('');
           }
       })
   })
</script>
<script>
   $('#country').change(function(){
            var reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                'country'    : $(this).val()
                }
            };
            $.ajax(
            {
                url: '{{ route('get.city') }}',
                dataType: 'json',
                data: reqData,
                type: 'post',
                success: function(response)
                {
                  $('#class_level').html('');
                    console.log(response)
                    html='<option value="">Select</option>';
                         response.result.city.forEach(function(item, index){
                             html+='<option value="'+item.id+'">'+item.city+'</option>';
                         });
                         html+='<option value="0">Other</option>';
                         $('#town').html(html);

                },
                error:function(error)
                {
                    console.log(error.responseText);
                }
            });

            $('#otherTown').css('display','none');
              $('#other_town').rules('remove','required');
              $('#other_town').val('');
        });
</script>
@endsection