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
         <img src="{{asset('images/faq-banner.png')}}" alt="" class="innr-bnnr-img">
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
         <span class="cont-icon1 position-absolute faq-icon"><img src="{{asset('images/abt-sec1-bg.png')}}" alt=""  class="img-fit"></span>
         <span class="cont-icon2 position-absolute faq-icon"><img src="{{asset('images/mis-vis-icon.png')}}" alt="" class="img-fit"></span>
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="faq_box">
                     <div id="accordion">
                        <div class="card ">
                           <div class="card-header">
                              <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                <span>Q.</span> What is Muhula?
                              </a>
                           </div>
                           <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Muhula is a platform that simplifies access to information about learning institutions and education partners, providing an avenue for authentic reviews to help parents and students make informed decisions regarding education.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                                 <span>Q.</span> Who can use Muhula?
                              </a>
                           </div>
                           <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Muhula is designed for learning institutions, parents, students (including alumni), and education partners. Each group can use the platform to share experiences, post reviews, and find relevant information.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsethre">
                                <span>Q.</span> How can learning institutions benefit from Muhula?
                              </a>
                           </div>
                           <div id="collapsethre" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Learning institutions can showcase their unique offerings, respond to reviews, and gain insights into how to enhance their messaging and attract potential students.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsefour">
                                 <span>Q.</span> What tools does Muhula provide for parents and learners?
                              </a>
                           </div>
                           <div id="collapsefour" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Parents and learners can filter through millions of learning institution options and ratings, engage with professionals, and read authentic reviews to make confident decisions about their educational paths.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsefive">
                                <span>Q.</span> How does Muhula support education partners?
                              </a>
                           </div>
                           <div id="collapsefive" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Education partners can increase their visibility to an audience in need of their services or products. They can post reviews, promote their offerings, and engage with users directly to enhance the learning experience.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsesix">
                                 <span>Q.</span> How do I post a review on Muhula?
                              </a>
                           </div>
                           <div id="collapsesix" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    To post a review, users must register on the platform and choose a category under which they wish to comment: Learning institution, Parent, Student/Alumni, or Education Partner.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsesecen">
                                <span>Q.</span> Is there a cost associated with using Muhula?
                              </a>
                           </div>
                           <div id="collapsesecen" class="collapse " data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Muhula does not charge users for accessing information, posting reviews, or utilising the platform's features. However, specifics about advertising services for education partners may vary.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseeight">
                                 <span>Q.</span> How can I ensure my review is authentic?
                              </a>
                           </div>
                           <div id="collapseeight" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    To maintain authenticity, Muhula requires registration and categorisation of users when posting reviews. This encourages genuine sharing based on personal experiences.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsenine">
                                 <span>Q.</span> Can I connect with professionals through the platform?
                              </a>
                           </div>
                           <div id="collapsenine" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    Yes! Muhula offers opportunities to engage with education professionals, allowing users to ask questions and gain insights into learning institutions.
                                 </p>
                              </div>
                           </div>
                        </div>

                        <div class="card ">
                           <div class="card-header">
                              <a class="collapsed btn" data-bs-toggle="collapse" href="#collapsenine">
                                 <span>Q.</span> How can I get help if I encounter issues on the platform?
                              </a>
                           </div>
                           <div id="collapsenine" class="collapse" data-bs-parent="#accordion">
                              <div class="card-body">
                                 <p>
                                    If you need assistance while using Muhula, you can reach out to our support team through the contact us page on the website or consult our help centre for additional resources.
                                 </p>
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
