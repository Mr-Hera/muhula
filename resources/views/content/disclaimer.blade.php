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
                    <li class="breadcrumb-item active" aria-current="page">Disclaimer</li>
                  </ol>
                </nav>
               <h1 class="text-center">Disclaimer</h1>
            </div>         
         </div>
         <div class="container">
            <div class="privacy-body-text">
               <div class="prvbdy-box">
                  {{--<h2 class="text-center">Disclaimer</h2>--}}
                  <p>muhula.com endeavours to produce a comprehensive, informative website, however muhula.com warns Users of this website that it cannot, and therefore does not, guarantee the accuracy, completeness or currency of all information and material on this website. Muhula.com strongly recommends that Users of the website exercise their own skills and care with respect to the information on this website.</p>
                  <p>Users should not rely on information on this website in making important decisions, and to use other sources to confirm the quality, relevance, timeliness and accuracy of the information. muhula.com warns that: Some information on this website could be inaccurate, incomplete or not current; a  proportion of schools in Kenya may not be on this website, and a small proportion that appear may no longer be operational; the Search functionality may not always produce accurate results; the information on school listings is limited to the number of schools that provide information for each listing.
                  </p>
                  <p>Further, that information posted by schools on this website is at their discretion, and muhula.com cannot always be in control of the content and is also not able to guarantee the accuracy of the information. Information provided by third parties does not necessarily reflect the views of muhula.com, or indicate a commitment to a particular course of action. When this website refers to a person or organisation this in no way implies any form of endorsement by muhula.com of the products or services provided by that person or organisation.</p>
                  <p>muhula.com advises Users that content and information on muhula.com is not a substitute for professional advice and users should obtain any appropriate professional advice relevant to their particular circumstances.</p>
                  <p>Links to websites are provided for Users convenience. muhula.com is not responsible for their content and no endorsement or association is implied. Users visiting those websites are subject to the Terms and Conditions of those websites. We make reasonable efforts to ensure that muhula.com is available for Users when required. However we cannot guarantee to provide continuously available or uninterrupted access to the site or the material available through the site.</p>
                  <p>muhula.com does not accept any responsibility for the accuracy or completeness of any material contained in this site. Additionally, muhula.com disclaims all liability to any person relying wholly or partially upon any information presented in this site in respect of anything, and the consequences of anything, done or omitted to be done. Be advised that muhula.com effectively disclaims all liability to the extent permitted by law, is not liable for any loss or damage however caused resulting from the use of the Website or the Content; or any incidental, special or consequential damages of any nature arising from the use of or inability to use the Website or the Content.
                  </p>
                  <p>The terms and conditions of use may change from time to time, so please re-visit every so often. Note that we are not required by law to contact you to inform you of changes.</p>
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