@extends('layouts.app')

@push('css')
    <!-- select2 css -->
	<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/styles.css')}}" rel="stylesheet" type="text/css" />

@endpush
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18"> User Profile</h4>

                    <!-- <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div> -->

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <div class="d-flex flex-wrap flex-sm-nowrap ">
                        <div class="me-7 mb-4">
                            <!--Profile picture-->
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                @if($user->profile_picture)
                                <img src="{{ asset('assets/images/profile/'.$user->profile_picture) }}" alt="image" />
                                @else
                                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="image" />
                                @endif
                            </div>
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }}</a>
                                        <!-- <span class="badge badge-light-success fw-bolder fs-8 px-4 py-2" style="color: black;">Active</span> -->
                                    </div>

                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <!-- <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <span class="me-1">
                                                <i class="bx bx-user fs-7"></i>
                                            </span>
                                            {{$user->role }}
                                        </a> -->



                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <!--get rounded small email icon-->
                                            <span class="me-1">
                                                <i class="bx bx-envelope fs-7"></i>
                                            </span>
                                            {{ $user->email }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap flex-stack">
                                <span class="fw-bolder text-gray-400 me-2">
                                    Phone: {{ $user->phone }}
                                </span>
                            </div>
                        </div>
                        

                    </div>
                    <ul class="nav nav-tabs nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold" id="myTab" role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link text-active-primary ms-0 me-10 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile Overview</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link text-active-primary ms-0 me-10"  id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Edit Profile </a>
                        </li>


                        <li class="nav-item mb-2">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Change Password </a>
                        </li>

                    </ul>
                    <div class="tab-content mt-10" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="card mb-5 mb-xl-10">
                                <div class="card-header cursor-pointer">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bold m-0"style="font-size: 16px;">Profile Details</h3>
                                    
                                    </div>
                                   
                                    
                                </div>
                                <div class="card-body p-9">
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                                        <div class="col-lg-8">                    
                                            <span class="fw-bold fs-6 text-gray-800">{{ $user->name }}</span>          
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">Email</label>
                                        <div class="col-lg-8">                    
                                                <span class="fw-bold fs-6 text-gray-800">{{ $user->email }}</span>          
                                        </div>
                                    </div>

                                    <div class="row mb-7">
                                        <label class="col-lg-4 fw-semibold text-muted">Phone Number</label>
                                        <div class="col-lg-8">                    
                                            <span class="fw-bold fs-6 text-gray-800">{{ $user->phone }}</span>          
                                        </div>
                                    </div>

                                </div>                       

                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bold m-0">Edit Profile</h3>
                                    </div>
                                </div>
                                <form  method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Profile Picture</label>
                                            <div class="col-lg-8">
                                                <input type="file" name="profile_picture" class="form-control form-control-lg form-control-solid" />
                                               <!-- style="background-image: url('https:preview.keenthemes.com/keen/themes/metronic8/demo6/assets/media/svg/avatars/300-1.jpg')" -->
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control form-control-lg form-control-solid" type="text" name="name" value="{{ $user->name }}" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                                            <div class="col-lg-8">
                                                <input class="form-control form-control-lg form-control-solid" type="email" name="email" value="{{ $user->email }}" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Phone</label>
                                            <div class="col-lg-8">
                                                <input class="form-control form-control-lg form-control-solid" type="text" name="phone" value="{{ $user->phone }}" />
                                            </div>
                                        </div>             
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit" id="changePasswordBtn">Update Profile</button>
                                        <!-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancel</button>                              -->
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="tab-pane fade " id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bold m-0">Change Password</h3>
                                    </div>
                                </div>
                                <form id="changePassword" class="form" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Current Password</label>
                                            <div class="col-lg-8">
                                                <div class="input-group" id="show_hide_password">
                                                    <input class="form-control form-control-lg form-control-solid" type="password" name="current_password" id="current_password"  placeholder="Enter current password" />
                                                    <!-- <input type="password" required class="form-control" name="password" placeholder="Enter password" > -->
                                                    <div class="input-group-append">
                                                        <span class="input-group-text toggle-password" id="basic-addon2" style="cursor: pointer;min-height: calc(1.9em + 1rem + 2px);"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">New Password</label>
                                            <div class="col-lg-8">
                                                <div class="input-group" id="show_hide_password">
                                                <input class="form-control form-control-lg form-control-solid" type="password" name="new_password" id="new_password" placeholder="Enter new password" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text toggle-password" id="basic-addon2" style="cursor: pointer;min-height: calc(1.9em + 1rem + 2px);"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-lg-4 col-form-label required fw-bold fs-6">Confirm Password</label>
                                            <div class="col-lg-8">
                                                <div class="input-group" id="show_hide_password">
                                                <input class="form-control form-control-lg form-control-solid" type="password" name="confirm_password" id="confirm_password" placeholder="Enter confirm password" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text toggle-password" id="basic-addon2" style="cursor: pointer;min-height: calc(1.9em + 1rem + 2px);"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button type="submit" class="btn btn-primary" id="changePasswordBtn">Save Changes</button>
                                        <button type="reset" class="btn btn-light btn-active-light-primary me-2">Cancel</button>                             
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>


        </div>
    </div> 
</div>

@endsection


@push('js')
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    // submit the change password form
    $('#changePassword').submit(function(e) {
        e.preventDefault();
        //get the form data values
        var currentPassword = $('#current_password').val();
        // console.log(currentPassword);
        var newPassword = $('#new_password').val();
        // console.log(newPassword);   
        var confirmPassword = $('#confirm_password').val();
        // console.log(confirmPassword);
        // check that current password, new password and confirm password are not empty
        if (currentPassword == '' || newPassword == '' || confirmPassword == '') {
            // console.log('Please fill all fields');
            toastr.error('All fields are required!');
        } 
        // check that new password and confirm password are equal
        else if (newPassword != confirmPassword) {
            console.log('Passwords do not match');
            toastr.error('Passwords do not match!');
            // use toast from t
            // Swal.fire({
            //     icon: 'error',
            //     title: 'Oops...',
            //     text: 'Passwords do not match!',
            // })
        }
            else {
                console.log('All good');
                // check that current password is correct
                //include the token
                var token = $('input[name=_token]').val();
                
                $.ajax({
                    url: "{{ route('change.password') }}", // url where to submit the request                 
                    type: 'POST',

                    data: {
                        old_password: currentPassword,
                        new_password: newPassword,
                        confirm_password: confirmPassword,
                        _token: token,
                    }, // data to submit
                   //dataType: 'json', // what type of data do we expect back from the server

                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            console.log(data.success);
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Success',
                            //     text: 'Password changed successfully!',
                            // })
                            // toast({
                            //     type: 'success',
                            //     title: 'Password Changed Successfully'
                            // })
                            toastr.success("Password changed successfully");
                             $('#changePassword').trigger("reset");
                            
                        }
                        else {
                            console.log(data.error);
                            toastr.error(data.error);
                            // Swal.fire({
                            //     icon: 'error',
                            //     title: 'Oops...',
                            //     text: 'Current password is incorrect!',
                            // })
                        }
                    },

                    error: function(reject) {
                        console.log(reject);
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: 'Oops...',
                        //     text: 'Something went wrong!',
                        // })
                        toastr.error('Something went wrong!');
                    }
                });             
            }
        }
       
    );

    //call function submitForm() when the submit button is clicked
    $('#changePasswordBtn').click(function(e) {
        e.preventDefault();
        //call the function to change the password
        $('#changePassword').submit();
    });

</script>
<script>
$(document).ready(function(){
    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });

    $(".toggle-password").click(function () {
        event.preventDefault();
        console.log('clicked');
        $("#show_hide_password i").toggleClass("fa-eye fa-eye-slash");
        if($("#show_hide_password input").attr("type") == "text"){
            $("#show_hide_password input").attr("type", "password");
        }else if($("#show_hide_password input").attr("type") == "password"){
            $("#show_hide_password input").attr("type", "text");
        }
    });
});
</script>
<!-- <script>
    $(".select2").select2();
</script> -->
<!-- <script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script> -->
</script><script src="{{ asset('assets/js/scripts.js') }}"></script>
@endpush