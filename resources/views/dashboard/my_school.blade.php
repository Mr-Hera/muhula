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
                     <h3>My School</h3>
                     <p>Here You can view your Claimed school(s)</p>
                  </div>
                  <div class="dashboard_box">
                  @include('includes.message')
                     @if($claimedSchools->isNotEmpty())
                     <div class="table-responsive">
                        <table id="schoolsTable" class="table table-bordered table-striped align-middle">
                           <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>School Name</th>
                                    <th>Curriculum</th>
                                    <th>Type</th>
                                    <th>Year / Curriculum / Boarding</th>
                                    <th>Actions</th>
                                 </tr>
                           </thead>
                           <tbody>
                                 @foreach($claimedSchools as $school)
                                 <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    {{-- Logo --}}
                                    <td>
                                       @php
                                          $imageUrl = $school->logo && file_exists(public_path($school->logo))
                                                ? asset($school->logo)
                                                : asset('default_images/default.jpg');
                                       @endphp

                                       <img src="{{ $imageUrl }}"
                                             alt="{{ $school->name ?? 'School Logo' }}"
                                             style="max-width:100px; border-radius:4px;">
                                    </td>

                                    {{-- Name --}}
                                    <td>
                                       <a href="{{ route('school.details', $school->slug) }}">
                                             {{ $school->name }}
                                       </a>
                                    </td>

                                    {{-- Curriculum --}}
                                    <td>{{ $school->curriculum->name }}</td>

                                    {{-- Type --}}
                                    <td>
                                       {{ optional($school->type)->name ?? 'Not Defined' }}
                                    </td>

                                    {{-- Year / Curriculum / Boarding --}}
                                    <td>
                                       @if($school->year_of_establishment)
                                             Year: {{ $school->year_of_establishment }} <br>
                                       @endif

                                       Curriculum: {{ optional($school->curriculum)->name ?? 'Not Defined' }} <br>

                                       Boarding: 
                                       @if($school->boarding_type == 'D')
                                             Day
                                       @elseif($school->boarding_type == 'B')
                                             Boarding
                                       @elseif($school->boarding_type == 'DB')
                                             Day & Boarding
                                       @else
                                             Not Defined
                                       @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="d-flex gap-2">
                                       <a class="btn btn-sm btn-warning" href="{{ route('user.edit.school', $school->id) }}">
                                             <i class="fa fa-edit"></i> Edit
                                       </a>

                                       <form action="{{ route('user.delete.school', $school->id) }}"
                                             method="POST"
                                             style="display:inline-block;"
                                             onsubmit="return confirm('Are you sure you want to permanently delete this school? This action cannot be undone.');">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Delete
                                             </button>
                                       </form>
                                    </td>
                                 </tr>
                                 @endforeach
                           </tbody>
                        </table>
                     </div>
                     @else
                        <h3 class="text-center">No Data Found</h3>
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
        $('#schoolsTable').DataTable({
            pageLength: 10,
            order: [[0, 'asc']]
        });
    });
</script>
@endsection
