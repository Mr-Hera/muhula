@extends('layouts.app')

@section('title','Admin Login')

@section('links')
@include('includes.links')
<style>
    .error { color:red !important; }

    .admin-badge {
        display: inline-block;
        padding: 6px 14px;
        background: #0d6efd;
        color: #fff;
        font-size: 12px;
        letter-spacing: 1px;
        border-radius: 30px;
        margin-bottom: 15px;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<section class="loagin_body">
    <div class="container-fluid top-container">
        <div class="row">
            <div class="col-12">
                <div class="logo_login text-center">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/login-logo.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid top-container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-10">
                <div class="login_from_body">
                    @include('includes.message')

                    <div class="inner_logn_b">
                        <div class="login_heading text-center">
                            <span class="admin-badge">Admin Access</span>
                            <h2>Sign in to <span>Admin Panel</span></h2>
                            <p class="text-muted mt-2">Authorized personnel only</p>
                        </div>

                        <div class="login_froms">
                            <form action="{{ route('admin.login.submit') }}" method="POST" id="AdminSigninForm">
                                @csrf

                                <div class="login_input">
                                    <label>Email</label>
                                    <input
                                        type="text"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        placeholder="Enter Email"
                                    >
                                </div>

                                <div class="login_input">
                                    <label>Password</label>
                                    <div class="posit_rela">
                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            placeholder="Enter password"
                                        >
                                        <span id="togglePassword" class="fa fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>

                                <div class="remember d-flex justify-content-between align-items-center">
                                    <div class="check_re">
                                        <label>
                                            Remember Me
                                            <input type="checkbox" name="remember">
                                            <span class="checkbox"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="login_btns">
                                    <button type="submit">
                                        Login to Admin
                                        <img src="{{ asset('images/arrow-righr.png') }}" alt="">
                                    </button>
                                </div>

                                <div class="login_gma text-center mt-3">
                                    <p class="text-muted">
                                        This area is restricted to administrators.
                                    </p>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
@include('includes.scripts')
<script>
$(document).ready(function () {

    $('#AdminSigninForm').validate({
        rules: {
            email: { required: true },
            password: { required: true }
        }
    });

    $('#togglePassword').on('click', function () {
        let input = $('#password');
        let type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });

    $('#email').keyup(function () {
        $(this).val($(this).val().toLowerCase());
    });

});
</script>
@endsection
