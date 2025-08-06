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
                              <li class="ongoing"><em></em>
                                 <div>
                                    <small>Step 1</small>
                                 <h6>Basic Information</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 2</small>
                                 <h6>School Details</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 3</small>
                                 <h6>Extra Info</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
                                 <div>
                                    <small>Step 4</small>
                                 <h6>School Gallery</h6>
                                 </div>
                                 
                              </li>
                              <li class=""><em></em>
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
                     <form action="{{ route('add.school.step2.save') }}" method="post" enctype="multipart/form-data" id="schoolForm">
                        @csrf
                        <div class="ad-schl-card adscl-crd2">
                           <div class="row">
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label>School Name</label>
                                    <input type="text" name="school_name" id="school_name" placeholder="Enter school name...">
                                 </div>
                              </div>
                              
                              <div class="col-12">
                                 <div class="dash_input mb-0 mt-2" id="aboutSchoolBox">
                                    <label>About the school</label>
                                    <textarea name="about_school" id="about_school" placeholder="Describe school here..."></textarea>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="ad-schl-card adscl-crd3 add-more-btn more-contact-info">
                           <a href="javascript:;" class="addMore"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add More</a>
                           <h2>Contact Information</h2>
                           <div class="row">
                              <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Contact Full Names <small>(Optional)</small></label>
                                    <input type="text" name="contact_title[]" id="contact_title1"  placeholder="Enter here..." value="{{ old('contact_email',@$schoolDetails->contact_email) }}">
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Email <small>(Optional)</small></label>
                                    <input type="text" name="contact_email[]" id="contact_email1" placeholder="Enter here..." value="{{ old('contact_email',@$schoolDetails->contact_email) }}">
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Phone <small>(Optional)</small></label>
                                    <input type="text" name="contact_phone[]" id="contact_phone1" placeholder="Enter here..." value="{{ old('contact_phone',@$schoolDetails->contact_phone) }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="ad-schl-card adscl-crd5">
                           <h2>Address Information</h2>
                           <div class="row">
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Country</label>
                                    <select name="country" id="country">
                                       <option value="">Select</option>
                                       @foreach($countries as $country)
                                          <option value="{{ $country->id }}">{{ $country->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="dash_input">
                                    <label>Town
                                       <span class="d-inlne-block ml-1 tooltip-main position-relative">
                                       <i class="fa fa-info-circle" aria-hidden="true"></i>
                                       <div class="tooltip-body position-absolute">If town is missing scroll to bottom & select other to add missing town.</div>
                                       </span>
                                    </label>
                                    <select name="county" id="county">
                                       <option value="">Select</option>
                                       @foreach($counties as $county)
                                       <option value="{{ $county->id }}">{{ @$county->name }}</option>
                                       @endforeach
                                       <option value="0">Other</option>
                                    </select>
                                 </div>
                              </div>
                              {{-- <div class="col-lg-6 col-md-6" style="display:none;" id="otherTown">
                                 <div class="dash_input">
                                    <label>Other Town</label>
                                    <input type="text" name="other_town" id="other_town" placeholder="Enter here">
                                 </div>
                              </div> --}}
                              <div class="col-12">
                                 <div class="dash_input">
                                    <label>Full Address</label>
                                    <input type="text" name="full_address" id="full_address" placeholder="Enter here..."/>
                                 </div>
                              </div>
                              <div class="col-12">
                                 <div class="dash_input position-relative g-map">
                                    <label>Google map link</label>
                                    <input type="text" name="google_location" id="google_location" placeholder="Paste link here..."/>
                                    <img src="{{ asset('images/google-map.png') }}" alt="" class="position-absolute">
                                    {{-- <input type="hidden" name="google_lat" id="lat" value="{{old('google_lat',@$schoolDetails->google_lat)}}">
                                    <input type="hidden" name="google_long" id="long" value="{{old('google_long',@$schoolDetails->google_long)}}"> --}}
                                 </div>
                              </div>
                           </div>
                        </div>
                        {{--<div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-captcha">
                           <div class="capca_box">
                                      <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                     @if($errors->has('g-recaptcha-response'))
                                     <span >
                                      <strong style="color: red !important">{{$errors->first('g-recaptcha-response')}}</strong>
                                     </span>
                                      @endif
                                       </div>
                                       
                                     <label class="captcha_error error mb-2"></label>
                              <!-- <div class="captcha">
                                 <div class="spinner">
                                     <label>
                                         <input type="checkbox" onclick="$(this).attr('disabled','disabled');">
                                         <span class="checkmark"><span>&nbsp;</span></span>
                                     </label>
                                     <div class="text">I'm not a robot</div>
                                 </div>                              
                                 <div class="logs">
                                    <img src="https://www.gstatic.com/recaptcha/api2/logo_48.png">
                                 </div>
                             </div> -->
                           </div>
                           </div>--}}
                           <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button type="submit">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 @if(@$schoolDetails != null)
                                 <a href="{{ route('add.school.step1',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                                 @else
                                 <a href="{{ route('add.school.step1') }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                                 @endif
                              </div>
                              <p>Step 2 Of 9</p>
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
{{--<script src="https://www.google.com/recaptcha/api.js" async defer></script>--}}

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

        $('#schoolForm').validate({

              rules: {

                school_logo: {

                    //required: true,
                },
                school_name: {

                    required: true,
                    name_Regex: true, 
                },
                year_of_establishment: {

                   digits: true,
                   //maxlength: 4,
                   min: 1200,
                    max: "{{ date('Y') }}",  
                },
                'school_type[]': {

                  //required: true,
                },
                board_id: {

                  required: true,
                },
                language_instruction_id: {

                    //required: true,
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
               //  constituency: {

               //    required: true,
               //  },
                full_address: {

                  required: true,
                },
                google_location: {

                   required: true,
                },
                 'contact_title[]': {
                  name_Regex: true,
                  maxlength:30,
                },
                'contact_email[]': {

                  validate_email: true,
                },
                'contact_phone[]':{

                    minlength:10,
                    maxlength:13,
                },
                about_school: {

                    required: function(){
                        if($('#aboutSchoolcheck').is(':checked'))
                         return true;
                         else
                        return false;
                    }
                },
               //  about_school_facility: {

               //    required: function(){
               //          if($('#schoolFacicheck').is(':checked'))
               //           return true;
               //           else
               //          return false;
               //      }
               //  },

              },
              ignore:[],
              messages: {

                 year_of_establishment: "Please enter valid year",
                 contact_phone: {
                  minlength: 'Please enter at least 10 digits.',
                   maxlength: 'Please enter not more than 13 digits.'
                 },
              },
              submitHandler: function(form) {
                 $('#submitBtn').prop('disabled',true);
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
{{--<script>
   google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
    var input = document.getElementById('google_location');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        $('#lat').val(place.geometry['location'].lat());
        $('#long').val(place.geometry['location'].lng());

        // $("#latitudeArea").removeClass("d-none");
        // $("#longtitudeArea").removeClass("d-none");
    });
}
</script>--}}
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

        $('.board').change(function(){

              let board = $(this).data('board_name');
              if(board == 'Others'){
                
                $('#other_board').rules('add','required');
                  
              }else{

                 $('#other_board').rules('remove','required');
                 $('#other_board').val('');
              }
        })
   })
</script>
<script>
   $(document).ready(function(){

        $('#aboutSchoolcheck').click(function(){

             if($(this).is(':checked')){

                 $('#aboutSchoolBox').css('display','block');
                 //$('#about_school').rules('add','required');
             }else{

               $('#aboutSchoolBox').css('display','none');
               //$('#about_school').rules('remove','required');
             }
        })

         $('#schoolFacicheck').click(function(){

             if($(this).is(':checked')){

                 $('#schoolFaciBox').css('display','block');
                 //$('#about_school_facility').rules('add','required');
             }else{

               $('#schoolFaciBox').css('display','none');
               //$('#about_school_facility').rules('remove','required');
             }
        })

         $('#noneAbove').click(function(){

              if($(this).is(':checked')){

                   $('#aboutSchoolcheck').prop('checked',false);
                   $('#aboutSchoolBox').css('display','none');
                   $('#schoolFacicheck').prop('checked',false);
                   $('#schoolFaciBox').css('display','none');
              }else{

                   $('#aboutSchoolcheck').prop('checked',true);
                   $('#aboutSchoolBox').css('display','block');
                   $('#schoolFacicheck').prop('checked',true);
                   $('#schoolFaciBox').css('display','block');
              }
         })
   })
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
<script>
   $(document).ready(function(){
      let count = 2;
        $('.addMore').click(function(){
             let html = ` <div class="row position-relative mr-15">
                           <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Contact Title <small>(Optional)</small></label>
                                    <input type="text" name="contact_title[]" id="contact_title_${count}" placeholder="Enter here" value="">
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Email <small>(Optional)</small></label>
                                    <input type="text" name="contact_email[]" id="contact_email_${count}" placeholder="Enter here" value="">
                                 </div>
                              </div>
                              <div class="col-lg-4 col-md-4">
                                 <div class="dash_input">
                                    <label>Phone <small>(Optional)</small></label>
                                    <input type="text" name="contact_phone[]" id="contact_phone_${count}" placeholder="Enter here" value="" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                                 </div>
                              </div>
                              <a href="javascript:;" class="del-row position-absolute"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>`;
             
                     $('.more-contact-info').append(html); 
                     count++;

        })
   })
</script>
<script>
   $("body").on('click','.del-row',function(){

         $(this).parent().hide();
   })
</script>
<script>
   $("body").on('click','.othertownInfo', function(e){
          e.preventDefault();
         Swal.fire({
         title: "This school not claim successfully, so you can not send a message",
         //text: "Someone has placed a bid so unable to edit the auction",
         icon: "info"
         });
       });
</script>
@endsection 