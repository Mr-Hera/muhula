@extends('layouts.app')
@section('title','Manage Advert')
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
                  <div class="table-responsive">
                        <table id="advertsTable" class="table table-bordered table-striped align-middle">
                           <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Slot</th>
                                    <th>Type</th>
                                    <th>Preview</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($adverts as $advert)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                       <span class="badge bg-primary">
                                          {{ strtoupper(str_replace('_',' ', $advert->slot)) }}
                                       </span>
                                    </td>

                                    <td>{{ ucfirst($advert->type) }}</td>

                                    <td>
                                       @if ($advert->type === 'image')
                                          <img src="{{ asset($advert->media_path) }}" class="img-thumbnail" style="max-width:120px;">
                                       @else
                                          <video width="140" controls>
                                             <source src="{{ asset($advert->media_path) }}">
                                          </video>
                                       @endif
                                    </td>

                                    <td>
                                       @if($advert->link)
                                          <a href="{{ $advert->link }}" target="_blank">
                                             {{ Str::limit($advert->link, 30) }}
                                          </a>
                                       @else
                                          —
                                       @endif
                                    </td>

                                    <td>
                                       @if($advert->is_active)
                                          <span class="badge bg-success">Active</span>
                                       @else
                                          <span class="badge bg-secondary">Inactive</span>
                                       @endif
                                    </td>

                                    <td class="d-flex gap-2">
                                       <!-- Edit Button -->
                                       <button class="btn btn-sm text-white"
                                             data-bs-toggle="modal"
                                             data-bs-target="#replaceAdvertModal"
                                             data-id="{{ $advert->id }}"
                                             data-type="{{ $advert->type }}"
                                             style="
                                                   background-image: linear-gradient(
                                                      89.66deg,
                                                      rgb(146, 208, 80) -12.49%,
                                                      rgb(50, 205, 50) 113.27%
                                                   );
                                                   border: none;
                                             ">
                                          <i class="fa fa-edit"></i> Edit
                                       </button>

                                       <!-- Delete -->
                                       <form method="POST" action="{{ route('admin.adverts.destroy', $advert) }}" onsubmit="return confirm('Delete this advert?');">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-sm btn-danger">
                                             <i class="fa fa-trash"></i>
                                          </button>
                                       </form>
                                    </td>
                                 </tr>
                              @endforeach
                           </tbody>
                        </table>
                  </div>
               @else
                  <h4 class="text-center">No adverts found</h4>
               @endif
            </div>

            <!-- Advert Pop up Modal -->
            <div class="modal fade" id="replaceAdvertModal" tabindex="-1">
               <div class="modal-dialog modal-dialog-centered">
                  <form method="POST" action="{{ route('dashboard.adverts.update') }}" enctype="multipart/form-data" class="modal-content">
                     @csrf

                     <input type="hidden" name="advert_id" id="advert_id" value="{{ old('advert_id') }}">

                     <div class="modal-header">
                        <h5 class="modal-title">Update Advert Media</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>

                     <div class="modal-body">
                        {{-- Global validation errors --}}
                        @if ($errors->any())
                           <div class="alert alert-danger">
                              <ul class="mb-0">
                                 @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
                        @endif

                        <div class="mb-3">
                           <label class="form-label">Upload New Media</label>
                           <input type="file" name="advert_media" id="advert_media" class="form-control @error('advert_media') is-invalid @enderror" accept="image/*,video/*" required>

                           {{-- temp thumbnail of uploaded advert --}}
                           <div id="advertMediaPreview" style="display:none; margin-top:10px;">
                              <img id="advertMediaPreviewImg"
                                 src=""
                                 alt="Advert Preview"
                                 style="max-width:150px; max-height:150px; border:1px solid #ddd; padding:4px; border-radius:4px;">
                           </div>

                           @error('advert_media')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                           @enderror
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Advert Link (optional)</label>
                           <input type="url" name="link" value="{{ old('link') }}" class="form-control @error('link') is-invalid @enderror">

                           @error('link')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                           @enderror
                        </div>
                     </div>

                     <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Update</button>
                     </div>
                  </form>
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

{{-- Datatable --}}
<script>
    $(document).ready(function () {
        $('#advertsTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']]
        });

        $('#replaceAdvertModal').on('show.bs.modal', function (event) {
            let button = $(event.relatedTarget);
            let advertId = button.data('id');

            $('#advert_id').val(advertId);
        });
    });
</script>

{{-- Uploaded media preview --}}
<script>
   $(document).on('change', '#advert_media', function () {
      const file = this.files[0];
      const previewContainer = $('#advertMediaPreview');
      const previewImage = $('#advertMediaPreviewImg');

      if (!file) {
         previewContainer.hide();
         previewImage.attr('src', '');
         return;
      }

      // Only preview images
      if (!file.type.startsWith('image/')) {
         previewContainer.hide();
         previewImage.attr('src', '');
         return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
         previewImage.attr('src', e.target.result);
         previewContainer.show();
      };

      reader.readAsDataURL(file);
   });
</script>

{{-- Clear preview when modal closes --}}
<script>
   $('#replaceAdvertModal').on('hidden.bs.modal', function () {
      $('#advertMediaPreview').hide();
      $('#advertMediaPreviewImg').attr('src', '');
      $('#advert_media').val('');
   });
</script>

@endsection
