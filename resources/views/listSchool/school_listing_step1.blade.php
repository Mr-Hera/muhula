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
                     </ul>
                  </div>
               </div>

               
               @if ($errors->any())
                  <div class="alert alert-danger mb-3">
                     <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                     </ul>
                  </div>
               @endif
               @if ($errors->has('error'))
                  <div class="alert alert-danger">
                     {{ $errors->first('error') }}
                  </div>
               @endif

               <form action="{{ route('school.listing.step1.save') }}" method="post" enctype="multipart/form-data" id="schoolForm">
                  @csrf
                  <div class="ad-schl-card adscl-crd2">
                     <div class="row">
                           <div class="col-12">
                              <div class="dash_input">
                                 <label>School Name <span style="color: red;">*</span></label>
                                 <input type="text" name="school_name" id="school_name" 
                                    placeholder="Enter school name..." 
                                    value="{{ old('school_name') }}"
                                 >
                                 @error('school_name')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-12">
                              <div class="dash_input mb-0 mt-2">
                                 <label>About the school <span style="color: red;">*</span></label>
                                 <textarea placeholder="Describe school here..." name="about_school" id="about_school">{{ old('about_school') }}</textarea>
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
                                 <label>Contact Full Names <span style="color: red;">*</span></label>
                                 <input type="text" name="contact_title[]" id="contact_title1" placeholder="E.g. John Mwangi..." 
                                          value="{{ old('contact_title.0') }}"
                                 >
                                 @error('contact_title.0')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-lg-4 col-md-4">
                              <div class="dash_input">
                                 <label>Email <span style="color: red;">*</span></label>
                                 <input type="text" name="contact_email[]" id="contact_email1" 
                                          placeholder="Enter here..." 
                                          value="{{ old('contact_email.0') }}">
                                 @error('contact_email.0')
                                       <small class="text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>

                           <div class="col-lg-4 col-md-4">
                              <div class="dash_input">
                                 <label>Phone <span style="color: red;">*</span></label>
                                 <input type="text" name="contact_phone[]" id="contact_phone1" 
                                          placeholder="E.g. 0712345678..." 
                                          value="{{ old('contact_phone.0') }}">
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
                              <label>Country <span style="color: red;">*</span></label>
                              <select name="country" id="country">
                                 <option value="" disabled selected hidden>Select</option>
                                 @foreach($countries as $country)
                                    @if ($country->name == "Kenya")
                                       <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>
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
                              <label>Town <span style="color: red;">*</span></label>
                              <select name="county" id="county" onchange="toggleNewCountyInput(this)">
                                 <option value="" selected disabled>Select</option>
                                 @foreach($counties as $county)
                                    <option value="{{ $county->id }}" 
                                       {{ old('county') == $county->id ? 'selected' : '' }}>
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
                                       placeholder="Enter here..." value="{{ old('full_address') }}">
                              @error('full_address')
                                    <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>

                        <div class="col-12">
                           <div class="dash_input position-relative g-map">
                              <label>Google map link (Optional)</label>
                              <input type="text" name="google_location" id="google_location" 
                                 placeholder="Paste link here..." 
                                 value="{{ old('google_location') }}">
                              <img src="{{ asset('images/google-map.png') }}" alt="" class="position-absolute">
                              @error('google_location')
                                    <small class="text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        {{-- 🔹 School Logo --}}
                        <div class="col-12">
                           <div class="dash_input">
                              <label for="school_logo">School Logo (Optional)</label>

                              <div class="row align-items-center">
                                 <div class="col-lg-6 col-sm-6">
                                    <div class="uplodimgfil2">
                                       <input
                                          type="file"
                                          name="school_logo"
                                          id="school_logo"
                                          class="inputfile2 inputfile-1"
                                          accept="image/*"
                                       >
                                       <label for="school_logo">
                                          <h3>Click here to upload</h3>
                                          <img src="{{ asset('images/upload1.png') }}" alt="">
                                       </label>
                                    </div>

                                    @error('school_logo')
                                       <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                 </div>
                              </div>

                              {{-- 🔹 Thumbnail Preview --}}
                              <div class="mt-3" id="logoPreviewWrapper" style="display:none;">
                                 <img
                                    id="logoPreview"
                                    src=""
                                    alt="School Logo Preview"
                                    style="max-width: 150px; max-height: 150px; border-radius: 6px; border: 1px solid #ddd;"
                                 >
                              </div>
                           </div>
                        </div>

                        {{-- 🔹 School Ownership --}}
                        <div class="col-lg-6 col-md-6">
                              <label><b>School Ownership <span style="color: red;">*</span></b></label>
                              <div class="check_gender adscl-type">
                                 <ul>
                                    <li>
                                          <input type="radio" name="ownership_type" value="Public">
                                          <label><p>Public</p></label>
                                    </li>
                                    <li>
                                          <input type="radio" name="ownership_type" value="Private">
                                          <label><p>Private</p></label>
                                    </li>
                                 </ul>
                              </div>
                              @error('ownership_type')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 Year of Establishment --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>Year of Establishment <span style="color: red;">*</span></label>
                                 <input type="text" name="year_of_establishment" id="year_of_establishment" placeholder="Enter here"
                                    value="{{ old('year_of_establishment') }}"
                                    oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                              </div>
                              @error('year_of_establishment')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 Curricula --}}
                        <div class="col-12">
                              <div class="dash_input">
                                 <label>Curriculum <span style="color: red;">*</span></label>
                                 <ul class="category-ul agree d-flex flex-wrap row-gap-2">
                                    @foreach($school_curricula as $curriculum)
                                          <li>
                                             <div class="radiobx">
                                                <label>{{ $curriculum->name }}
                                                      <input type="checkbox" name="curricula[]" value="{{ $curriculum->name }}"
                                                         @checked(is_array(old('curricula')) && in_array($curriculum->name, old('curricula'))) />
                                                      <span class="checkbox"></span>
                                                </label>
                                             </div>
                                          </li>
                                    @endforeach
                                 </ul>
                              </div>
                              @error('curricula')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 School Levels --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>School Levels <span style="color: red;">*</span></label>
                                 <select multiple name="school_level_id[]" id="school_level" class="filter-multi-select">
                                    @foreach($school_levels as $level)
                                       @if ($level->name != "General")
                                          <option value="{{ $level->id }}" @selected(collect(old('school_level_id'))->contains($level->id))>
                                             {{ $level->name }}
                                          </option>
                                       @endif
                                    @endforeach
                                 </select>
                              </div>
                              @error('school_level_id')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 Gender --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input mb-1">
                                 <label>Gender <span style="color: red;">*</span></label>
                              </div>
                              <div class="check_gender adscl-type">
                                 <ul>
                                    <li><input type="radio" name="gender" value="Male" @checked(old('gender') == 'Male')> <label><p>Male</p></label></li>
                                    <li><input type="radio" name="gender" value="Female" @checked(old('gender') == 'Female')> <label><p>Female</p></label></li>
                                    <li><input type="radio" name="gender" value="Mixed" @checked(old('gender') == 'Mixed')> <label><p>Both</p></label></li>
                                 </ul>
                              </div>
                              @error('gender')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 School Type --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input mb-1">
                                 <label>Type <span style="color: red;">*</span></label>
                              </div>
                              <div class="check_gender adscl-type adscl-tp2">
                                 <ul>
                                    <li><input type="radio" name="school_type_id" value="{{ $school_types_day->id }}" @checked(old('school_type_id') == $school_types_day->id)> <label><p>Day</p></label></li>
                                    <li><input type="radio" name="school_type_id" value="{{ $school_types_boarding->id }}" @checked(old('school_type_id') == $school_types_boarding->id)> <label><p>Boarding</p></label></li>
                                    <li><input type="radio" name="school_type_id" value="{{ $school_types_day_n_boarding->id }}" @checked(old('school_type_id') == $school_types_day_n_boarding->id)> <label><p>Day & Boarding</p></label></li>
                                 </ul>
                              </div>
                              @error('school_type_id')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 Relationship --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>What is your Relationship with this School? <span style="color: red;">*</span></label>
                                 <select name="contact_relationship_id" id="contact_relationship_id">
                                    <option value="">Select</option>
                                    @foreach($school_contact_positions as $position)
                                          <option value="{{ $position->id }}" @selected(old('contact_relationship_id') == $position->id)>
                                             {{ $position->name }}
                                          </option>
                                    @endforeach
                                 </select>
                              </div>
                              @error('contact_relationship_id')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
                        </div>

                        {{-- 🔹 Religion --}}
                        <div class="col-lg-6 col-md-6">
                              <div class="dash_input">
                                 <label>Religion <span style="color: red;">*</span></label>
                                 <select name="religion_id" id="religion_id">
                                    <option value="">Select</option>
                                    @foreach($school_religion as $religion)
                                          <option value="{{ $religion->id }}" @selected(old('religion_id') == $religion->id)>
                                             {{ $religion->name }}
                                          </option>
                                    @endforeach
                                 </select>
                              </div>
                              @error('religion_id')
                                 <small class="text-danger">{{ $message }}</small>
                              @enderror
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
                           <p>Step 1 of 3</p>
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

<script>
   document.addEventListener('DOMContentLoaded', function () {
      const logoInput = document.getElementById('school_logo');
      const previewWrapper = document.getElementById('logoPreviewWrapper');
      const previewImage = document.getElementById('logoPreview');

      logoInput.addEventListener('change', function () {
         const file = this.files[0];

         if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
               previewImage.src = e.target.result;
               previewWrapper.style.display = 'block';
            };

            reader.readAsDataURL(file);
         } else {
            previewImage.src = '';
            previewWrapper.style.display = 'none';
         }
      });
   });
</script>

@endsection
