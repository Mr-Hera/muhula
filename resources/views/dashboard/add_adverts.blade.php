@extends('layouts.app')
@section('title','Add Advert')
@section('links')
@include('includes.links')
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
               <h3>Advertisements</h3>
               <p>See and Manage all your advertisements here.</p>
            </div>

            <div class="my_review_btn2">
               <a href="{{ route('dashboard.adverts.index') }}" class="rev_active">Add advert</a>
               <a href="{{ route('dashboard.manage.adverts') }}" class="">Manage adverts</a>
            </div>

            <div class="dashboard_box mt-4">
               <form action="{{ route('admin.adverts.store') }}" method="post" id="advertsForm" enctype="multipart/form-data">
                  @csrf

                  <div class="row">
                     <div class="col-sm-12 cols">
                           <div class="dash_inner_heading mt-1 position-relative">
                              <h3>Add Advert</h3>
                           </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Where to place your advert:</label>
                              <select name="slot" required>
                                 <option value="">Select Slot</option>
                                 <option value="two_left">Two Column – Left</option>
                                 <option value="two_right">Two Column – Right</option>
                                 <option value="single">Single Wide</option>
                              </select>
                           </div>
                        </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Type of content you want to place:</label>
                              <select name="type" required>
                                 <option value="">Media Type</option>
                                 <option value="image">Image</option>
                                 <option value="video">Video</option>
                              </select>
                           </div>
                        </div>

                        <div class="col-lg-6 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                           <div class="dash_input mb-1">
                              <label>Upload media:</label>
                              <div class="uplodimgfil2">
                                 <input type="file" name="advert_media" id="advert_media" class="inputfile2 inputfile-1" required>
                                 <label for="advert_media">
                                    <h3>Click here to upload </h3>
                                    <img src="{{ asset('images/upload1.png') }}" alt="">
                                 </label>
                              </div>
                           </div>
                           <label id="image_error" for="" class="error" style="display:none;"></label>
                        </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Media URL(Optional):</label>
                              <input type="url" name="link" placeholder="Optional redirect URL">
                           </div>
                        </div>


                     </div>

                  </div>
                  <div class="save_sec">
                     <button class="save_btns mt-3" type="submit">Save Advert</button>
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
@endsection
