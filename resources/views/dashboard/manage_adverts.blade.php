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
                  	<a href="{{ route('dashboard.adverts.index') }}" class="">Add advert</a>
                     <a href="{{ route('dashboard.manage.adverts') }}" class="rev_active">Manage adverts</a>
                  </div>

                  <div class="dashboard_box mt-4">
                     @if ($adverts->count() > 0)
                        @foreach($adverts as $advert)
                           <div class="d-flex align-items-center mb-2">
                              <strong>{{ strtoupper($advert->slot) }}</strong>

                              <form method="POST"
                                    action="{{ route('admin.adverts.destroy', $advert) }}"
                                    class="ms-3"
                                    onsubmit="return confirm('Delete this advert?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                       <i class="fa fa-trash"></i>
                                    </button>
                              </form>
                           </div>
                        @endforeach
                     @else
                        <h3><center>No Data Found</center></h3>
                     @endif
                  </div>

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
     $("#advert_media").change(function () {
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
                    $("#advert_media").val('');
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
