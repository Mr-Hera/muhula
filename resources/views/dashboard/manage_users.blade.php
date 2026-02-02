@extends('layouts.app')
@section('title','Manage School(s)')
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
                     <h3>Users</h3>
                     <p>Here You can view and sort all user(s)</p>
                  </div>
                  <div class="dashboard_box">
                  @include('includes.message')
                     @if($users->isNotEmpty())
                        <div class="table-responsive">
                           <table id="usersTable" class="table table-bordered table-striped align-middle">
                              <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Profile</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Phone</th>
                                       <th>Type</th>
                                       <th>Verified</th>
                                       <th>Actions</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                       <td>{{ $loop->iteration }}</td>

                                       {{-- Profile Image --}}
                                       <td>
                                          @php
                                             // Image path stored in DB (relative to public/)
                                             // Example stored value: images/users/avatar.jpg
                                             $imageFile = $user->profile_image ?? 'images/avatar.png';

                                             // Absolute filesystem path
                                             $imageFullPath = public_path($imageFile);

                                             // Fallback if file missing
                                             if (!file_exists($imageFullPath)) {
                                                   $imageFile = 'images/avatar.png';
                                             }

                                             // Prefix from config ('' locally, '/public' on production)
                                             $prefix = trim(config('app.public_path_prefix'), '/');

                                             // Build final public URL
                                             $imageUrl = $prefix
                                                   ? url($prefix . '/' . $imageFile)
                                                   : url($imageFile);
                                          @endphp

                                          <img src="{{ $imageUrl }}" alt="{{ $user->first_name }} profile" style="max-width:40px; border-radius:50%;">
                                       </td>

                                       {{-- Name --}}
                                       <td>
                                          {{ $user->first_name }} {{ $user->last_name }}
                                          @if ($user->is_admin)
                                             <span class="text-success ms-1"
                                                   style="opacity:.85"
                                                   title="Verified account">
                                                <i class="fa fa-shield"></i>
                                             </span>
                                          @endif
                                       </td>

                                       {{-- Email --}}
                                       <td>
                                          {{ $user->email }}
                                       </td>

                                       {{-- Phone --}}
                                       <td>
                                          <small>{{ $user->phone ?? '—' }}</small>
                                       </td>

                                       {{-- Type --}}
                                       <td>
                                          {{ $user->is_admin ? 'Admin' : 'Regular' }}
                                       </td>

                                       {{-- Verified --}}
                                       <td>
                                          @if($user->is_email_verified)
                                             <span class="badge bg-success">
                                                   <i class="fa fa-check-circle"></i> Verified
                                             </span>
                                             <br>
                                             <small class="text-muted">
                                                   {{ $user->email_verified_at->format('d M Y, H:i') }}
                                             </small>
                                          @else
                                             <span class="badge bg-secondary">
                                                   <i class="fa fa-clock"></i> Not Verified
                                             </span>
                                          @endif
                                       </td>

                                       {{-- Actions --}}
                                       <td class="d-flex gap-2">
                                          <button class="btn btn-sm text-white"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal-{{ $user->id }}"
                                                style="
                                                      background-image: linear-gradient(89.66deg, rgb(146, 208, 80) -12.49%, rgb(50, 205, 50) 113.27%);
                                                      border:none;
                                                ">
                                             <i class="fa fa-edit"></i> Edit
                                          </button>

                                          <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this user permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                   <i class="fa fa-trash"></i> Delete
                                                </button>
                                          </form>
                                       </td>
                                    </tr>

                                    <!-- Edit User Modal -->
                                    <div class="modal fade"
                                       id="editUserModal-{{ $user->id }}"
                                       tabindex="-1"
                                       aria-labelledby="editUserModalLabel-{{ $user->id }}"
                                       aria-hidden="true">

                                       <div class="modal-dialog modal-lg modal-dialog-centered">
                                          <div class="modal-content">

                                             {{-- Modal Header --}}
                                             <div class="modal-header d-flex align-items-center gap-3 flex-wrap">
                                                <div class="d-flex align-items-center gap-3">

                                                   {{-- Modal Title --}}
                                                   <div>
                                                         <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">
                                                            Edit User
                                                         </h5>

                                                         {{-- Profile Image + Name --}}
                                                         <div class="d-flex align-items-center gap-2 mt-2">
                                                            @php
                                                               // Image path stored in DB (relative to public/)
                                                               // Example stored value: images/users/avatar.jpg
                                                               $imageFile = $user->profile_image ?? 'images/avatar.png';

                                                               // Absolute filesystem path
                                                               $imageFullPath = public_path($imageFile);

                                                               // Fallback if file missing
                                                               if (!file_exists($imageFullPath)) {
                                                                  $imageFile = 'images/avatar.png';
                                                               }

                                                               // Prefix from config ('' locally, '/public' on production)
                                                               $prefix = trim(config('app.public_path_prefix'), '/');

                                                               // Build final public URL
                                                               $imageUrl = $prefix
                                                                  ? url($prefix . '/' . $imageFile)
                                                                  : url($imageFile);
                                                            @endphp

                                                            <img src="{{ $imageUrl }}"
                                                               alt="{{ $user->first_name }} {{ $user->last_name }}"
                                                               style="width:50px; height:50px; border-radius:50%; object-fit:cover;">

                                                            <div class="d-flex flex-column" style="line-height:1.1;">
                                                               <span class="fw-bold mb-0">
                                                                  {{ $user->first_name }} {{ $user->last_name }}
                                                                  @if ($user->is_admin)
                                                                     <span class="text-success ms-1"
                                                                           style="opacity:.85"
                                                                           title="Verified account">
                                                                        <i class="fa fa-shield"></i>
                                                                     </span>
                                                                  @endif
                                                               </span>
                                                               <small class="text-muted mb-0">{{ $user->email }}</small>
                                                            </div>
                                                         </div>
                                                   </div>
                                                </div>

                                                {{-- Close Button --}}
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                             </div>

                                             {{-- Modal Body --}}
                                             <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">
                                                   <div class="row g-3">

                                                      {{-- Account Type --}}
                                                      <div class="col-md-6">
                                                         <label class="form-label">Update Account Type</label>
                                                         <div class="position-relative">
                                                            <select name="is_admin" class="form-select pe-4"> {{-- pe-4 adds space for the arrow --}}
                                                                  <option value="0" @selected(!$user->is_admin)>
                                                                     Regular User
                                                                  </option>
                                                                  <option value="1" @selected($user->is_admin)>
                                                                     Administrator
                                                                  </option>
                                                            </select>
                                                         </div>
                                                      </div>

                                                      {{-- Email Verification --}}
                                                      <div class="col-md-12">
                                                         <label class="form-label">Email Verification</label>

                                                         @if($user->is_email_verified)
                                                            <span class="badge bg-success">
                                                                  <i class="fa fa-check-circle"></i>
                                                                  Verified on {{ $user->email_verified_at->format('d M Y') }}
                                                            </span>
                                                         @else
                                                            <div>
                                                                  <span class="badge bg-secondary">
                                                                     <i class="fa fa-clock"></i>
                                                                     Not Verified
                                                                  </span>

                                                                  {{-- Buttons always below the badge --}}
                                                                  <div class="mt-2 d-flex flex-wrap gap-2">
                                                                     <a href="{{ route('admin.users.verify', $user->id) }}"
                                                                        class="btn btn-sm text-white"
                                                                        style="
                                                                           background-image: linear-gradient(89.66deg, rgb(146, 208, 80) -12.49%, rgb(50, 205, 50) 113.27%);
                                                                           border:none;
                                                                        ">
                                                                        Verify Now
                                                                     </a>

                                                                     <a href="{{ route('admin.users.resend.verification', $user->id) }}"
                                                                        class="btn btn-sm btn-outline-primary">
                                                                        Resend Verification Email
                                                                     </a>
                                                                  </div>
                                                            </div>
                                                         @endif
                                                      </div>

                                                   </div>
                                                </div>

                                                {{-- Modal Footer --}}
                                                <div class="modal-footer">
                                                   <button type="button"
                                                            class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">
                                                         Cancel
                                                   </button>

                                                   <button type="submit"
                                                            class="btn text-white"
                                                            style="
                                                               background-image: linear-gradient(89.66deg, rgb(146, 208, 80) -12.49%, rgb(50, 205, 50) 113.27%);
                                                               border:none;
                                                            ">
                                                         <i class="fa fa-save"></i> Save Changes
                                                   </button>
                                                </div>

                                             </form>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                              </tbody>
                           </table>
                        </div>
                     @else
                        <h3 class="text-center">No users found</h3>
                     @endif



                  {{-- <div class="dashboard_pagination">
                     <div class="pagination_box">
                        {{$claimedSchools->appends(request()->except(['page', '_token']))->links('pagination')}}
                     </div>
                  </div> --}}

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

{{-- Datatable script --}}
@parent
<script>
    $(document).ready(function () {
        $('#usersTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>
@endsection
