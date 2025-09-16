@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
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
<section class="add-school-container">
    <div class="container">
        <div class="row">
            @include('includes.message')
            <div class="col-lg-8">
                <div class="add-schl-lft">
                    <div class="ad-schl-card adscl-crd1 d-flex flex-column align-items-center text-center justify-content-center py-5">

                        <h1>Congratulations! 🎉</h1>
                        <p>Your school has been successfully listed on our platform.</p>

                        <div class="completion-summary">
                            <p>All the relevant details — from basic information and extra info, to gallery, subjects, branches, and school fees — have been saved successfully.</p>
                            <p>You're now ready to start connecting with learners, parents, and educators from across the country.</p>
                        </div>

                        <div class="action-buttons mt-4 d-flex gap-3 justify-content-center">
                            <a class="text-black btn btn-link" href="{{ route('school.details', $school_slug ?? '') }}">
                                <u>View Your School</u>
                            </a>
                            <a href="{{ route('user.dashboard') }}" class="text-black btn btn-link"><u>Back to Dashboard</u></a>
                        </div>

                        <div class="ad-schl-sub-go mt-4">
                            <div class="ad-sch-pag-sec d-flex justify-content-center align-items-center">
                                <button type="button" class="completeBtn" data-url="{{ route('add.school.step2') }}">
                                    Add New School
                                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 4L9.08625 7.97499L5 11.95" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="add-schl-r8">
                    <div class="ad-schl-rtcrd">                        
                    <em><span class="cardimg-line-top"></span><img src="{{ asset('images/ad-schl-rt.png') }}" alt=""><span class="cardimg-line-bottom"></span></em>   
                    <span class="line-img-btm"></span>        
                    <h2>Listing your School will help others make informed choices on their educational journey</h2> 
                    <!-- <ul>
                        <li>In publishing and graphic design, Lorem ipsum is a placeholder sample caption</li>
                        <li>Lorem Ipsum is simply dummy text</li>
                        <li>In publishing and graphic design lorem ipsum is a placeholder</li>
                    </ul>             -->
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
    document.addEventListener('DOMContentLoaded', function () {
        $('.completeBtn').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            if (url) {
                window.location.href = url;
            }
        });
    });
</script>
@endsection
