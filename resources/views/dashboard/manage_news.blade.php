@extends('layouts.app')
@section('title','Manage News')

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
               <h3>News</h3>
               <p>See and manage your news articles here.</p>
            </div>

            <div class="my_review_btn2">
               <a href="{{ route('user.add.news') }}">Add News</a>
               <a href="{{ route('user.manage.news') }}" class="rev_active">Manage News</a>
            </div>

            <div class="dashboard_box mt-4">
               @if ($articles->count())
                  <div class="table-responsive">
                     <table id="newsTable" class="table table-bordered table-striped align-middle">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Title</th>
                              <th>Author</th>
                              <th>Cover</th>
                              <th>Status</th>
                              <th>Published</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($articles as $article)
                              <tr>
                                 <td>{{ $loop->iteration }}</td>

                                 <td>{{ Str::limit($article->title, 40) }}</td>

                                 <td>{{ $article->author->first_name . " " . $article->author->last_name ?? '—' }}</td>

                                 <td>
                                    @php
                                       // Image path stored in DB (relative to public/)
                                       // Example: images/news_covers/example.jpg
                                       $imageFile = $article->cover_image ?? 'images/news_covers/default.png';

                                       // Absolute filesystem path
                                       $imageFullPath = public_path($imageFile);

                                       // Fallback if file does not exist
                                       if (!file_exists($imageFullPath)) {
                                          $imageFile = 'images/news_covers/default.png';
                                       }

                                       // Prefix from config ('' locally, '/public' on production)
                                       $prefix = trim(config('app.public_path_prefix'), '/');

                                       // Build final public URL
                                       $imageUrl = $prefix
                                          ? url($prefix . '/' . $imageFile)
                                          : url($imageFile);
                                    @endphp

                                    <img src="{{ $imageUrl }}"
                                       class="img-thumbnail"
                                       style="max-width:100px; object-fit:cover;"
                                       alt="{{ $article->title }}">
                                 </td>

                                 <td>
                                    @if ($article->is_published)
                                       <span class="badge bg-success">Published</span>
                                    @else
                                       <span class="badge bg-secondary">Draft</span>
                                    @endif
                                 </td>

                                 <td>
                                    {{ $article->published_at ? $article->published_at : '—' }}
                                 </td>

                                 <td class="d-flex gap-2">
                                    <button
                                       class="btn btn-sm editNewsBtn"
                                       data-bs-toggle="modal"
                                       data-bs-target="#editNewsModal"
                                       data-id="{{ $article->id }}"
                                       data-title="{{ $article->title }}"
                                       data-excerpt="{{ $article->excerpt }}"
                                       data-body="{{ $article->body }}"
                                       data-status="{{ $article->is_published }}"
                                       data-cover="{{ $article->cover_image }}"
                                       style="
                                          background-image: linear-gradient(
                                             89.66deg,
                                             rgb(146, 208, 80) -12.49%,
                                             rgb(50, 205, 50) 113.27%
                                          );
                                          border: none;
                                       "
                                    >
                                       <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <form method="POST"
                                          action="{{ route('user.news.destroy', $article) }}"
                                          onsubmit="return confirm('Delete this news article?');">
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
                  <h4 class="text-center">No news articles found</h4>
               @endif
            </div>

            {{-- Edit News Modal --}}
            <div class="modal fade" id="editNewsModal" tabindex="-1">
               <div class="modal-dialog modal-lg modal-dialog-centered">
                  <form method="POST"
                        action="{{ route('user.news.update') }}"
                        enctype="multipart/form-data"
                        class="modal-content">
                     @csrf
                     @method('PUT')

                     <input type="hidden" name="news_id" id="news_id">

                     <div class="modal-header">
                        <h5 class="modal-title">Edit News</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>

                     <div class="modal-body">
                        <div class="mb-3">
                           <label>Title</label>
                           <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                           <label>Excerpt</label>
                           <textarea name="excerpt" id="edit_excerpt" class="form-control"></textarea>
                        </div>

                        <div class="mb-3">
                           <label>Body</label>
                           <textarea name="body" id="edit_body" class="form-control" rows="6" required></textarea>
                        </div>

                        <div class="mb-3">
                           <label>Cover Image (optional)</label>

                           <input type="file"
                                 name="cover_image"
                                 id="edit_cover_image"
                                 class="form-control"
                                 accept="image/*">

                           {{-- Current / Preview Image --}}
                           <div id="editCoverPreviewWrapper" class="mt-2">
                              <img id="editCoverPreview"
                                 src=""
                                 alt="Cover preview"
                                 style="max-width:150px; max-height:150px; object-fit:cover; border:1px solid #ddd; padding:4px; border-radius:4px;">
                           </div>
                        </div>

                        <div class="mb-3">
                           <label>Status</label>
                           <select name="is_published" id="edit_status" class="form-control">
                              <option value="0">Draft</option>
                              <option value="1">Published</option>
                           </select>
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
$(document).ready(function () {
   $('#newsTable').DataTable({
      pageLength: 10,
      order: [[0, 'asc']]
   });

   $('.editNewsBtn').on('click', function () {
      $('#news_id').val($(this).data('id'));
      $('#edit_title').val($(this).data('title'));
      $('#edit_excerpt').val($(this).data('excerpt'));
      $('#edit_body').val($(this).data('body'));
      $('#edit_status').val($(this).data('status'));
   });
});
</script>

{{-- Handle image preview in edit modal --}}
<script>
$(document).ready(function () {
   let originalCoverSrc = '';

   $('.editNewsBtn').on('click', function () {
      const coverPath = $(this).data('cover') || 'images/news_covers/default.png';

      // Build public URL (same logic as table)
      const prefix = "{{ trim(config('app.public_path_prefix'), '/') }}";
      const imageUrl = prefix
         ? "{{ url('/') }}/" + prefix + '/' + coverPath
         : "{{ url('/') }}/" + coverPath;

      originalCoverSrc = imageUrl;

      $('#editCoverPreview').attr('src', imageUrl).show();
      $('#edit_cover_image').val('');
   });

   // Live preview when selecting a new image
   $('#edit_cover_image').on('change', function () {
      const file = this.files[0];
      if (!file || !file.type.startsWith('image/')) return;

      const reader = new FileReader();
      reader.onload = function (e) {
         $('#editCoverPreview').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
   });

   // Reset preview if modal is closed without saving
   $('#editNewsModal').on('hidden.bs.modal', function () {
      $('#editCoverPreview').attr('src', originalCoverSrc);
      $('#edit_cover_image').val('');
   });
});
</script>

@endsection
