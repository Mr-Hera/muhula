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
                              <li class="ongoing"><em></em>
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
                     <form action="{{ route('add.school.step5.save') }}" method="post" enctype="multipart/form-data" id="imageForm">
                        @csrf
                        <input type="hidden" name="school_master_id" id="" value="{{ @$schoolDetails->id }}">
                         {{-- <input type="hidden" name="" id="exist_image" value="{{ @$school_gallery->count() }}"> --}}
                         
                        <div class="ad-schl-card adscl-crd11">
                              {{---<div class="dash_input">
                                    <label for="">School profile header image (Recommended Dimension 1600px*500px)</label>
                                    <div class="row align-items-start">
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uplodimgfil2">
                                             <input type="file" name="header_image" id="header_image" class="inputfile2 inputfile-1" data-multiple-caption="{count} files selected">
                                             <label for="header_image">                                          
                                                <h3>Click here to upload </h3>
                                                <img src="{{ url('public/images/upload1.png') }}" alt="">
                                             </label>
                                          </div>
                                       </div>
                                       <div class="col-lg-6 col-sm-6">
                                          <div class="uploaded-img position-relative uplded-banner">
                                              @if(@$schoolDetails->header_image != null)
                                              <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$schoolDetails->header_image }}" alt="">
                                              @endif
                                             
                                          </div>
                                       </div>
                                    </div>                                
                                 </div>
                                 <div class="dash_input">
                                    <label>Youtube Link</label>
                                    <input type="text" name="youtube_link" id="youtube_link" placeholder="Enter here" @if(@$schoolDetails->youtube_link) value="https://www.youtube.com/watch?v={{@$schoolDetails->youtube_link}}" @endif>
                                    <label class="intro_video_error error error1" style="color: red"></label>
                                 </div>--}}
                           <div class="uplodimgfil upld-schl-images">
                              <input type="file" name="school_image[]" id="school_image" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple="">
                              <label for="school_image">
                                 <img src="{{ asset('images/upload.png') }}" alt="">
                                 <h3>Upload School Images</h3>
                              </label>
                           </div>
                           <label id="school_image-error" class="error" for="school_image" style="display:none;">This field is required.</label>
                           <p class="img-copy">
                              <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <g clip-path="url(#clip0_3329_453)">
                                 <path d="M9.49967 17.4168C13.8719 17.4168 17.4163 13.8724 17.4163 9.50016C17.4163 5.12791 13.8719 1.5835 9.49967 1.5835C5.12742 1.5835 1.58301 5.12791 1.58301 9.50016C1.58301 13.8724 5.12742 17.4168 9.49967 17.4168Z" stroke="#5B5A5A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M9.5 12.6667V9.5" stroke="#5B5A5A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M9.5 6.3335H9.51" stroke="#5B5A5A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </g>
                              </svg>
                              <span>The photos added don't have copyright infringement and that Muhula will not liable for any infringement on copyrights.</span>                              
                           </p>
                           
                           <div class="upldd-scl-imgs">
                              @if(@$school_gallery)
                               @foreach($school_gallery as $data)
                              <em class="schl-img-nw">
                                 @if(@$data->image != null)
                                 <img src="{{ URL::to('storage/app/public/images/school_image') }}/{{ @$data->image }}" alt="">
                                 @endif
                                 <a href="{{ route('school.image.delete',@$data->id) }}">
                                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.25 2.75L2.75 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                       <path d="M2.75 2.75L8.25 8.25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>                                       
                                 </a>
                              </em>
                              @endforeach
                              @endif
                           </div>
                        </div>
                        <div class="ad-schl-card adscl-crd4">
                           <div class="ad-schl-sub-go mt-0">
                              <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                                 <button type="submit">Save and Continue <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </button>
                                 <a href="{{ route('add.school.step4',[md5(@$schoolDetails->id)]) }}">
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M8.99805 4L4.9118 7.97499L8.99805 11.95" stroke="#414750" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Back   
                                 </a>
                              </div>
                              <p>Step 5 Of 9</p>
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

        $('#imageForm').validate({

             rules: {
               'school_image[]': {
         
                  required: function(){

                       var image = $('#exist_image').val();
                       if(image == 0)
                       return true;
                       else
                       return false;
                  }
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
        function ytVidId(url) {
        var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }

    $('#youtube_link').bind("change", function() {

        var url = $(this).val();
        if(url != ''){

            if (ytVidId(url) !== false) {
            $('.intro_video_error').html('');
            } else {
            $(".intro_video_error").html('Youtube Link invalid');
            $('#youtube_link').val('');
            }

        }
        
    });
</script>
<script>
     $("#header_image").change(function () {
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
                    $("#header_image").val('');
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
@endsection 