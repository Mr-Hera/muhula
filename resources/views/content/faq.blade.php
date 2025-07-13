@extends('layouts.app')
@section('title','Muhula')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="inner_banner">
         <img src="{{ url('public/images/faq-banner.png') }}" alt="" class="innr-bnnr-img ">
         <div class="in-bn-txt">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Faq</li>
                  </ol>
                </nav>
               <h1>Frequently Asked Questions</h1>
            </div>         
         </div>
      </section>

      <section class="faq_sec position-relative">
         <span class="cont-icon1 position-absolute faq-icon"><img src="{{ url('public/images/abt-sec1-bg.png') }}" alt="" class="img-fit"></span>
         <span class="cont-icon2 position-absolute faq-icon"><img src="{{ url('public/images/mis-vis-icon.png') }}" alt="" class="img-fit"></span>
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="faq_box">
                     <div id="accordion">
                        <div class="card ">
                           <div class="card-header">
                              <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                <span>Q.</span> Text of the printing and typesetting industry Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                                 <span>Q.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsethre">
                                <span>Q.</span> Dummy text of the printing and typesetting industry
                              </a>
                           </div>
                           <div id="collapsethre" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsefour">
                                 <span>Q.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapsefour" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsefive">
                                <span>Q.</span> Text of the printing and typesetting industry Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapsefive" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsesix">
                                 <span>Q.</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapsesix" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsesecen">
                                <span>Q.</span> Dummy text of the printing?
                              </a>
                           </div>
                           <div id="collapsesecen" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseeight">
                                 <span>Q.</span> Text of the printing and typesetting industry Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapseeight" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsenine">
                                 <span>Q.</span> Typesetting industry Lorem Ipsum has been the standard?
                              </a>
                           </div>
                           <div id="collapsenine" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>Since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the standard dummy text ever since when an unknown is has been the standard dummy text ever since the an unknown. Lorem Ipsum is simply dummy text of the lorem Ipsum is simply dummy text of the</p>
                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="faq_contact">
                        <p>Can't find your answer? <a href="{{ route('contact.us') }}">Contact Us</a> </p>
                     </div>
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
