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
                     <h3>Edit Profile</h3>
                  </div>
                  <div class="dashboard_box">
                  @include('includes.message')
                     <form action="{{ route('user.update.profile') }}" method="post" id="update-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           <div class="col-lg-3 col-sm-6 col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>First name</label>
                                 <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="Enter here">
                              </div>
                           </div>
                           <div class="col-lg-3 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>Last name</label>
                                 <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Enter here">
                              </div>
                           </div>
                           <div class="col-lg-6 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input mb-1">
                                 <label>Email</label>
                                 <input type="text" placeholder="Enter here" readonly  value="{{ $user->email }}">
                                 <p>Want to Change email? <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editEmaileModal">Click here</a> </p>
                              </div>
                           </div>
                           <div class="col-lg-6 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input">
                                 <label>Phone Number</label>
                                 <input type="text" name="mobile" placeholder="E.g. 254765498701..." value="{{ $user->phone }}" oninput="this.value = this.value.replace(/[^0-9]/g,'')">
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-lg-6 col-md-6 col-12 cols">
                              <div class="uplodimg edit-prof-big">
                              <input type="hidden" name="profile_picture" id="profile_picture">
                                 <div class=" img-upld">
                                    <div class="uplodimgfil">
                                       <input type="file" name="file" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected">
                                       <label for="file-1">
                                          <img src="{{ asset('images/upload.png') }}" alt="">
                                          <h3>Upload profile picture</h3>
                                          <p>png, Jpg</p>
                                       </label>
                                    </div>
                                    <div class="uplodimg_pick">
                                        @if($user->profile_image != null)
                                            @php
                                                // Prepare the storage path
                                                $profileImagePath = 'public/images/userImage/' . ltrim($user->profile_image, '/');

                                                // If the file exists in storage, use it; otherwise, fallback to default avatar
                                                $imageUrl = Storage::exists($profileImagePath)
                                                    ? Storage::url($profileImagePath)
                                                    : asset('images/avatar.png');
                                            @endphp

                                            <img src="{{ $imageUrl }}" alt="">

                                            <a href="{{ route('user.profile.image.delete') }}">
                                                <img src="{{ asset('images/x.png') }}" alt="">
                                            </a>
                                        @else
                                            <img src="{{ asset('images/avatar.png') }}" alt="">
                                        @endif
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <div class="col-sm-12 cols">
                              <div class="dash_inner_heading">
                                 <h3>Change Password</h3>
                              </div>
                           </div>

                           <div class="col-lg-4 col-sm-6  col-md-6 col-12 cols">
                              <div class="dash_input">
                                 <label class=" nob" data-content="Password">Current password </label>
                                 <div class="posit_rela">
                                    <input id="old_password"  name="old_password" type="password" placeholder="Enter here"
                                    readonly=""
                                        onfocus="this.removeAttribute('readonly');" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    <span toggle="#password-field" id="togglePassword" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>
                           </div>

                           <div class="col-lg-4  col-sm-6 col-md-6 col-12 cols">
                              <div class="dash_input">
                                 <label class=" nob" data-content="Password">New Password </label>
                                 <div class="posit_rela">
                                    <input id="new_password"  name="new_password" type="password" placeholder="Enter here"
                                    readonly=""
                                        onfocus="this.removeAttribute('readonly');" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    <span toggle="#password-field" id="togglePassword2" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>
                           </div>

                           <div class="col-lg-4  col-sm-6 col-md-6 col-12 cols">
                              <div class="dash_input">
                                 <label class=" nob" data-content="Password">Confirm Password </label>
                                 <div class="posit_rela">
                                    <input id="new_password_confirmation"  name="new_password_confirmation" type="password" placeholder="Enter here"
                                    readonly=""
                                        onfocus="this.removeAttribute('readonly');" onclick="this.removeAttribute('readonly');" onblur="this.removeAttribute('readonly');">
                                    <span toggle="#password-field" id="togglePassword3" class="fa fa-eye field-icon toggle-password"></span>
                                 </div>
                              </div>
                           </div>

                        </div>

                        <div class="row">
                           <div class="cols">
                              <div class="double_line"></div>
                              <button class="save_btns">Save all Changes <img src="{{ asset('images/arrow-righr.png') }}" alt=""> </button>
                           </div>
                        </div>


                     </form>
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
<script src="{{ URL::asset('public/croppie/croppie.js') }}"></script>

<script>
$(document).ready(function() {
  $.validator.addMethod("validate_email", function(value, element) {
        return this.optional(element) || /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,5}$/i.test(value);
    }, "Please enter valid email address");

    $.validator.addMethod("name_Regex", function(value, element) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter only letters");

    $.validator.addMethod("address_Regex", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z\s]+$/.test(value);
    }, "Please enter only letters and numbers");

    $.validator.addMethod("phone_Regex", function(value, element) {
        return this.optional(element) || /^[0-9a\+]+$/.test(value);
    }, "Please enter only numbers");

    $.validator.addMethod("pincode_Regex", function(value, element) {
        return this.optional(element) || /^[0-9]+$/.test(value);
    }, "Please enter only number");

    $.validator.addMethod("ifsc_Regex", function(value, element) {
        return this.optional(element) || /^[0-9a-zA-Z]+$/.test(value);
    }, "Please enter only letters and numbers");

    // validate the comment form when it is submitted
    $("#update-form").validate({
        rules: {
            first_name: {
                name_Regex: true,
                required: true,
                maxlength: 30
            },
            last_name: {
                name_Regex: true,
                required: true,
                maxlength: 30
            },
            mobile: {
                //required: true,
                minlength: 10,
                maxlength: 13,
                //digits: true,
                phone_Regex: true,
               //  remote: {
               //      url: '{{ route("mobile.check") }}',
               //      type: "post",
               //      data: {
               //          mobile: function() {
               //              return $("#mobile").val();
               //          },
               //          _token: '{{ csrf_token() }}'
               //      }
               //  }

            },
            old_password: {
					required: function(){
						let new_pass = $('#new_password').val();
						let old_pass_confirm = $('#password_confirmation').val();
						if(new_pass!='' || old_pass_confirm !=''){
							return true
						}else{
							return false
						}
					},
				},
				new_password: {
					required: function(){
                        let old_pass = $('#old_password').val();
                        console.log(old_pass);
                        let old_pass_confirm = $('#password_confirmation').val();
                        if((old_pass!=''|| old_pass_confirm !='') && old_pass != undefined){
                            return true
                        }else{
                            return false
                        }
                    },
                    minlength: 8
				},
				password_confirmation: {

					required: function(){
                        let old_pass = $('#old_password').val();
                        let new_pass = $('#new_password').val();
                        if((old_pass!='' || new_pass!='') && old_pass != undefined){
                            return true
                        }else{
                            return false
                        }
                    },
                    equalTo: "#new_password"
				},

        },
        messages: {
            first_name: {
                maxlength: 'Please enter not more than 30 characters',
                name_Regex: 'First Name must contain only letters'
            },
            last_name: {
                maxlength: 'Please enter not more than 30 characters',
                name_Regex: 'Last Name must contain only letters'
            },
            email: {
                remote: 'This email has already been taken',
            },
            mobile: {
                remote: 'This mobile number has already been taken',
                minlength: 'Please enter valid number',
                maxlength: 'Please enter valid number',
            },
            account_number: {
                maxlength: 'Please enter not more than 20 characters',
            },
            ifsc_code: {
                maxlength: 'Please enter not more than 20 characters',
            },
            pincode: {
                minlength: 'Please enter minimum 6 digits',
            },
            confirm_account_number: {

               equalTo: "Re-enter account number not match ",
            },
        },

        submitHandler: function(form) {

            form.submit();
        },

    });


     $('.close').click(function(){

           $('#croppie-modal').modal('hide');
     })

});
</script>


<script>
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }
    var uploadCrop;
    $(document).ready(function(){
        $('#croppie-modal').on('hidden.bs.modal', function() {
            uploadCrop.croppie('destroy');
        });

        $('#crop-img').click(function() {
            uploadCrop.croppie('result', {
                type: 'base64',
                format: 'png'
            }).then(function(base64Str) {
                $("#croppie-modal").modal("hide");
               //  $('.lds-spinner').show();
               let file = dataURLtoFile('data:text/plain;'+base64Str+',aGVsbG8gd29ybGQ=','hello.png');
                  console.log(file.mozFullPath);
                  console.log(base64Str);
                  $('#profile_picture').val(base64Str);
               // $.each(file, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uplodimg_pick').append('<img  src="' + e.target.result + '">');
                    };
                    reader.readAsDataURL(file);

               //  });
                $('.uplodimg_pick').show();

            });
        });
    });
    $("#file-1").change(function () {
            $('.uplodimg_pick').html('');
            let files = this.files;
            console.log(files);
            let img  = new Image();
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
                    $("#file-1").val('');
                    return false;
                }
                // img.src = window.URL.createObjectURL(event.target.files[0])
                // img.onload = function () {
                //     if(this.width > 250 || this.height >160) {
                //         flag=0;
                //         alert('Please upload proper image size less then : 250px x 160px');
                //         $("#file").val('');
                //         $('.uploadImg').hide();
                //         return false;
                //     }
                // };
                $("#croppie-modal").modal("show");
                uploadCrop = $('.croppie-div').croppie({
                    viewport: { width: 256, height: 256, type: 'square' },
                    boundary: { width: $(".croppie-div").width(), height: 400 }
                });
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    // console.log(e.target.result)
                    uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
               //  $('.uploadImg').append('<img width="100"  src="' + reader.readAsDataURL(this.files[0]) + '">');
               //  $.each(files, function(i, f) {
               //      var reader = new FileReader();
               //      reader.onload = function(e){
               //          $('.uploadImg').append('<img width="100"  src="' + e.target.result + '">');
               //      };
               //      reader.readAsDataURL(f);
               //  });
               //  $('.uploadImg').show();
            }

        });
</script>

<script>
$(document).ready(function() {

    $("#emailForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 100,
                //remote: {
                //    url: '{{ route("email.check") }}',
                //    type: "post",
                //    data: {
                //        email: function() {
                //            return $("#temp_email").val();
                //        },
                //        _token: '{{ csrf_token() }}'
                //    }
                //}

            },
            current_password: {

                required: true,
                // remote: {
                //     url: '{{ route("password.check") }}',
                //     type: "post",
                //     data: {
                //         current_password: function() {
                //             return $("#current_password").val();
                //         },
                //         _token: '{{ csrf_token() }}'
                //     }
                // }

            },

        },
        messages: {
            email: {
                remote: 'This email has already been taken',
                maxlength: 'Please enter not more than 100 characters'
            },
            current_password: {

                remote: 'Current password is wrong',
            }
        },

        submitHandler: function(form) {
            form.submit();
        },

    });
});
</script>
@endsection