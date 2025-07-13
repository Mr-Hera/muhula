@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<!-- <section class="inner_banner">
         <img src="{{ url('public/images/faq-banner.png') }}" alt="" class="innr-bnnr-img ">
         <div class="in-bn-txt">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Faq</li>
                  </ol>
                </nav>
               <h1>Privacy </h1>
            </div>         
         </div>
      </section> -->
      <div class="privacy-body position-relative">
         <span class="privacy-bnr-bg position-absolute w-100 d-block"></span>
         <div class="privacy-body-inr">
         <div class="in-bn-txt mb-4 pt-5">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-center mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                  </ol>
                </nav>
               <h1 class="text-center">Privacy Policy</h1>
            </div>         
         </div>
         <div class="container">
            <div class="privacy-body-text">
               <div class="prvbdy-box">
                  <p>muhula.com will not provide any Third Party with the names or email addresses or any other details or correspondence of users of this website.</p>
                  <p>muhula.com will not provide any Third Party with any information submitted by schools to this website or to muhula.com, or any email addresses or any other contact details provided or any correspondence. Information submitted by schools its associates or by individuals/entities to muhula.com is available for viewing by Users of the site, but will not be actively passed on to a Third Party.</p>
                  <p>However we reserve the right to pass on to a Third Party if required, commonly available data, which we have compiled, such as a school name, address, phone and type of school amongst other publicly available information.</p>
                  <p>Although every reasonable care is taken to protect information, we cannot be liable if there is an unlawful act beyond our control, and all parties must be aware of this when providing information.</p>
               </div>
            </div>
         </div>
         </div>
      </div>
              
         </div>
      </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.scripts')
@endsection