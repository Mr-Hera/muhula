@extends('layouts.app')
@section('title','News')
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
<section class="after_login_body">
         <div class="container-fluid top-container">
            <div class="row">
            @include('includes.sidebar')
               <div class="dashboard_right_panel">
                  <div class="dashboard_right_heading">
                     <h3>News</h3>
                     <p>Share the latest news about your favourite school or topic.</p>
                  </div>
                  @include('includes.message')

                  <div class="dashboard_box mt-4">
                     <form action="{{ route('user.create.news.save') }}" method="post" id="newsForm" enctype="multipart/form-data">
                       @csrf
                       {{--<input type="hidden" name="school_id" id="" value="{{ @$schoolDetails->id }}"> 
                       <input type="hidden" name="news_id" id="" value="{{ @$newsData->id }}">--}}
                     <div class="row">
                     <div class="col-sm-12 cols">
                              <div class="dash_inner_heading mt-1 position-relative">
                                 <h3>Add News</h3>
                              </div>
                           </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                 <div class="dash_input">
                                    <label>School </label>
                                    <select name="school_id" id="school_id">
                                       <option value="">Select</option>
                                       @foreach($claimedSchools as $school)
                                          <option value="{{ $school->id }}">{{ $school->name }}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>

                           <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                              <div class="dash_input mb-3">
                                 <label>News Title</label>
                                 <input type="text" name="news_title" placeholder="Enter here">
                              </div>
                           </div>

                           <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                             <div class="dash_input">
                              <label>Description</label>
                               <textarea placeholder="Enter description" name="description"></textarea>
                             </div>
                           </div>

                           <div class="col-lg-6 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>News Image</label>
                                 <div class="uplodimgfil2">
                                       <input type="file" name="news_image" id="news_image" class="inputfile2 inputfile-1">
                                       <label for="news_image">                                          
                                          <h3>Click here to upload </h3>
                                          <img src="{{ asset('images/upload1.png') }}" alt="">
                                       </label>
                                 </div>
                              </div>
                              <label id="image_error" for="" class="error" style="display:none;"></label>
                           </div>
                           <div class="col-lg-4 col-xl-3 col-sm-6  col-md-3 col-12 cols cols_img">
                          <div class="sch_show_img uploadImage">
                        </div>
                       </div>

                     </div>
                     <div class="save_sec">
                        <button class="save_btns mt-3" type="submit">Save</button>
                     </div>
                     </form>
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

        $('#newsForm').validate({

             rules: {

                school_id:{

                    required: true,
                },
               news_title: {

                   required: true,
               },
               description: {

                    required: true,
               },
               news_image: {

                  required: true,
               },

             },
             submitHandler: function(form){

               let filename = $('#news_image').val();
                console.log(filename);
                if(filename == ''){

                    $('#image_error').html('Please upload a news image');
                    $('#image_error').css('display','block');
                    return false;
                }else{

                  form.submit();
                }
             },
        })
   })
</script>

<script>
     $("#news_image").change(function () {
            $('.uploadImage').html('');
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
                    $("#news_image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uploadImage').append('<img src="'+e.target.result+'" alt="">');
                    };
                    reader.readAsDataURL(f);
                });
            }
            
        });
</script>

@endsection 