@extends('layouts.app')
@section('title','Profile')
@section('links')
@include('includes.links')
<link href="{{ URL::asset('public/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/croppie/croppie.min.css') }}" rel="stylesheet" />
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
                     <h3>Manage Claims</h3>
                  </div>
                    <div class="dashboard_box">
                        @include('includes.message')

                        <table class="table table-bordered" id="claimsTable">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Position</th>
                                    <th>School</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $claim)
                                    <tr>
                                        <td>{{ $claim->first_name }} {{ $claim->last_name }}</td>
                                        <td>{{ $claim->position_name ?? 'N/A' }}</td>
                                        <td>{{ $claim->school_name }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($claim->claim_status == 'pending') bg-warning 
                                                @elseif($claim->claim_status == 'approved') bg-success 
                                                @else bg-danger @endif">
                                                {{ ucfirst($claim->claim_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form action="{{ route('claims.update.status', $claim->claim_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-success"
                                                    @if($claim->claim_status == 'approved') disabled @endif>
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('claims.update.status', $claim->claim_id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    @if($claim->claim_status == 'rejected') disabled @endif>
                                                    Reject
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
               </div>
            </div>
         </div>
      </section>

      <div class="modal dash-modal" tabindex="-1" role="dialog" id="croppie-modal" style="z-index:9999;">
    <div class="modal-dialog modal-white" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="close close-crop" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="croppie-div" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               <div class="dash_submits">
                <button type="button" class="save_btns mt-0" id="crop-img">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editEmaileModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h4 class="modal-title">Edit Your Email Address</h4>
                <button type="button" class="btn-close close-crop" data-bs-dismiss="modal"></button>
            </div>
            <form id="emailForm" class="edit-frm-inr" method="POST" action="{{ route('user.update.email') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                              <div class="dash_input">
                                 <label>Email</label>
                                 <input type="text" name="email" id="temp_email" placeholder="Enter Here" value="{{ old('email') }}">
                              </div>
                              <div class="dash_input">
                                 <label>Current Password</label>
                                 <input type="password" name="current_password" id="current_password" placeholder="Enter Here" value="{{ old('current_password') }}">
                              </div>
                        </div>
                        <div class="col-12">
                        <button class="save_btns mt-0">Save Changes <img src="{{ url('public/images/arrow-righr.png') }}" alt=""> </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')

@push('scripts')
<script>
$(document).ready(function() {
    $('#claimsTable').DataTable();
});
</script>
@endpush

@endsection
