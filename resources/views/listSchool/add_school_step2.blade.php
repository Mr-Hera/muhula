@extends('layouts.app')
@section('title','Muhula')

@section('links')
@include('includes.links')
<style>
  .error {
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
                        <li class="ongoing"><em></em>
                           <div>
                              <small>Step 1</small>
                              <h6>Basic Information</h6>
                           </div>
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 2</small>
                              <h6>School Details</h6>
                           </div>
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 3</small>
                              <h6>Extra Info</h6>
                           </div>
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 4</small>
                              <h6>School Gallery</h6>
                           </div>
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 5</small>
                              <h6>Subject/ Courses</h6>
                           </div>
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 6</small>
                              <h6>Result</h6>
                           </div>                                 
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 7</small>
                              <h6>Branches</h6>
                           </div>                                 
                        </li>
                        <li><em></em>
                           <div>
                              <small>Step 8</small>
                              <h6>School Fees</h6>
                           </div>                                 
                        </li>
                     </ul>
                  </div>
               </div>

               <form action="{{ route('add.school.step2.save') }}" method="post" enctype="multipart/form-data" id="schoolForm">
                  @csrf
                  <div class="ad-schl-card adscl-crd2">
                     <div class="row">
                           <div class="col-12">
                              <div class="dash_input">
                                 <label>School Name <span style="color: red;">*</span></label>
                                 <input type="text" name="school_name" id="school_name" 
                                    placeholder="Enter school name..." 
                                    value="{{ old('school_name', optional($schoolDetails)->school_name) }}"
                                 >
                                 @error('school_name')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="dash_input mb-0 mt-2">
                                 <label>About the school <span style="color: red;">*</span></label>
                                 <textarea name="about_school" id="about_school" placeholder="Describe school here...">
                                    {{ old('about_school', optional($schoolDetails)->about_school) }}
                                 </textarea>
                                 @error('about_school')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                     </div>
                  </div>

                  <div class="ad-schl-card adscl-crd3 add-more-btn more-contact-info">
                     <a href="javascript:;" class="addMore"><i class="fa fa-plus-circle"></i> Add More</a>
                     <h2>Contact Information <span style="color: red;">*</span></h2>
                     <div class="row">
                           <div class="col-lg-4 col-md-4">
                              <div class="dash_input">
                                 <label>Contact Full Names</label>
                                 <input type="text" name="contact_title[]" id="contact_title1" placeholder="Enter here..." 
                                          value="{{ old('contact_title.0', optional($schoolDetails)->contact_title) }}"
                                 >
                                 @error('contact_title.0')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-lg-4 col-md-4">
                              <div class="dash_input">
                                 <label>Email</label>
                                 <input type="text" name="contact_email[]" id="contact_email1" 
                                          placeholder="Enter here..." 
                                          value="{{ old('contact_email.0', optional($schoolDetails)->contact_title) }}">
                                 @error('contact_email.0')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-lg-4 col-md-4">
                              <div class="dash_input">
                                 <label>Phone</label>
                                 <input type="text" name="contact_phone[]" id="contact_phone1" 
                                          placeholder="Enter here..." 
                                          value="{{ old('contact_phone.0', optional($schoolDetails)->contact_title) }}">
                                 @error('contact_phone.0')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                     </div>
                  </div>

                  <div class="ad-schl-card adscl-crd5">
                     <h2>Address Information <span style="color: red;">*</span></h2>
                     <div class="row">
                           <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>Country</label>
                                 <select name="country" id="country">
                                    <option value="" disabled selected hidden>Select</option>
                                    @foreach($countries as $country)
                                       @if ($country->name == "Kenya")
                                          <option value="{{ $country->id }}" {{ old('country', optional($schoolDetails)->country_id) == $country->id ? 'selected' : '' }}>
                                             {{ $country->name }}
                                          </option>
                                       @endif
                                    @endforeach
                                 </select>
                                 @error('country')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>Town</label>
                                 <select name="county" id="county" onchange="toggleNewCountyInput(this)">
                                    <option value="" selected disabled>Select</option>
                                    @foreach($counties as $county)
                                       <option value="{{ $county->id }}" 
                                          {{ old('county', optional($schoolDetails)->county_id) == $county->id ? 'selected' : '' }}>
                                          {{ $county->name }}
                                       </option>
                                    @endforeach
                                    <option value="0" {{ old('county') ? 'selected' : '' }}>Other</option>
                                 </select>
                                 @error('county')
                                    <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>

                              {{-- Hidden input that appears only if “Other” is selected --}}
                              <div class="dash_input mt-2" id="newCountyInput" style="display: none;">
                                 <label>Enter New Town</label>
                                 <input type="text" name="new_county_name" placeholder="Enter town name" value="{{ old('new_county_name') }}">
                                 @error('new_county_name')
                                    <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="dash_input">
                                 <label>Full Address <span style="color: red;">*</span></label>
                                 <input type="text" name="full_address" id="full_address" 
                                          placeholder="Enter here..." value="{{ old('full_address', optional($schoolDetails)->full_address) }}">
                                 @error('full_address')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="dash_input position-relative g-map">
                                 <label>Google map link</label>
                                 <input type="text" name="google_location" id="google_location" 
                                    placeholder="Paste link here..." 
                                    value="{{ old('google_location', optional($schoolDetails)->google_location) }}">
                                 <img src="{{ asset('images/google-map.png') }}" alt="" class="position-absolute">
                                 @error('google_location')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                     </div>
                  </div>

                  <div class="ad-schl-card adscl-crd4">
                     <div class="ad-schl-sub-go mt-0">
                           <div class="ad-sch-pag-sec d-flex justify-content-start align-items-center">
                              <button type="submit">Save and Continue</button>
                              {{-- @if($schoolDetails != null)
                                 <a href="{{ route('add.school.step1') }}">Back</a>
                              @else
                                 <a href="{{ route('add.school.step1') }}">Back</a>
                              @endif --}}
                           </div>
                           <p>Step 2 Of 9</p>
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
@endsection

<script>
   function toggleNewCountyInput(select) {
      const newCountyInput = document.getElementById('newCountyInput');
      if (select.value == '0') {
         newCountyInput.style.display = 'block';
      } else {
         newCountyInput.style.display = 'none';
         // Clear field if user switches back
         newCountyInput.querySelector('input').value = '';
      }
   }

   // On page load (e.g. validation fail + old input)
   document.addEventListener('DOMContentLoaded', function() {
      const countySelect = document.getElementById('county');
      if (countySelect.value == '0') {
         document.getElementById('newCountyInput').style.display = 'block';
      }
   });
</script>
