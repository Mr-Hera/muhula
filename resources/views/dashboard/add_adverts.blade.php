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

                  {{-- Global validation errors --}}
                  @if ($errors->any())
                     <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                  @endif

                  <div class="row">
                     <div class="col-sm-12 cols">
                           <div class="dash_inner_heading mt-1 position-relative">
                              <h3>Add Advert</h3>
                           </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Where to place your advert:</label>
                              <select name="slot" class="@error('slot') is-invalid @enderror" required>
                                 <option value="">Select Slot</option>

                                 <option value="two_left" {{ old('slot') === 'two_left' ? 'selected' : '' }}>Two Column – Left</option>
                                 <option value="two_right" {{ old('slot') === 'two_right' ? 'selected' : '' }}>Two Column – Right</option>
                                 <option value="single" {{ old('slot') === 'single' ? 'selected' : '' }}>Single Wide</option>
                              </select>

                              @error('slot')
                                 <div class="invalid-feedback d-block">
                                    {{ $message }}
                                 </div>
                              @enderror
                           </div>
                        </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Type of content you want to place:</label>
                              <select name="type" class="@error('type') is-invalid @enderror" required>
                                 <option value="">Media Type</option>

                                 <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Image</option>
                                 <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                              </select>

                              @error('type')
                                 <div class="invalid-feedback d-block">
                                    {{ $message }}
                                 </div>
                              @enderror
                           </div>
                        </div>

                        <div class="col-lg-6 col-xl-4 col-sm-6  col-md-6 col-12 cols">
                           <div class="dash_input mb-1">
                              <label>Upload media:</label>
                              <div class="uplodimgfil2">
                                 <input type="file" name="advert_media" id="advert_media" class="inputfile2 inputfile-1 @error('advert_media') is-invalid @enderror" required>
                                 <label for="advert_media">
                                    <h3>Click here to upload </h3>
                                    <img src="{{ asset('images/upload1.png') }}" alt="">
                                 </label>
                              </div>
                           </div>

                           {{-- temp thumbnail of uploaded advert --}}
                           <div id="advertMediaPreview" style="display:none; margin-top:10px;">
                              <img id="advertMediaPreviewImg"
                                 src=""
                                 alt="Advert Preview"
                                 style="max-width:150px; max-height:150px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                           </div>

                           @error('advert_media')
                              <label class="error d-block text-danger">
                                 {{ $message }}
                              </label>
                           @enderror
                        </div>

                        <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                           <div class="dash_input mb-3">
                              <label>Media URL(Optional):</label>
                              <input type="url" name="link" value="{{ old('link') }}" class="@error('link') is-invalid @enderror" placeholder="Optional redirect URL">

                              @error('link')
                                 <div class="invalid-feedback d-block">
                                    {{ $message }}
                                 </div>
                              @enderror
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

<script>
   document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('advert_media');
      const previewContainer = document.getElementById('advertMediaPreview');
      const previewImage = document.getElementById('advertMediaPreviewImg');

      if (!input) return;

      input.addEventListener('change', function () {
         const file = this.files[0];

         if (!file) {
            previewContainer.style.display = 'none';
            previewImage.src = '';
            return;
         }

         // Only preview images
         if (!file.type.startsWith('image/')) {
            previewContainer.style.display = 'none';
            previewImage.src = '';
            return;
         }

         const reader = new FileReader();

         reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
         };

         reader.readAsDataURL(file);
      });
   });
</script>

@endsection
