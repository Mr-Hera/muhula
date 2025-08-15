<footer @if(Route::is('about.us')) class="mt-0" @endif>
         <div class="footer_inner">
            <div class="container">
               <div class="row">
               <div class="footer-top">
           
                  <div class="foot-lft">
                      <a href="{{ route('home') }}" class="fot-logo"> <img src="{{ asset('images/ft-logo.png') }}" alt=""></a>
                      <p>Muhula simplifies the search and access to information about learning institutions and education partners for parents and students, regardless of their educational journey. It also allows for authentic reviews that helps improve decision making when it comes to education.</p>
                      <a href="{{ route('about.us') }}">Read more </a>
                  </div>
                  <div class="foot-mid">
                      <h3>Quick Links</h3>
                      <div class="foot-mid-inr">
                          <ul>
                              <li><a href="{{ route('home') }}">Home</a></li>
                               @guest
                              <li><a href="{{ route('login') }}">Login</a></li>
                              <li><a href="{{ route('user.register') }}">Sign up</a></li>
                              @endguest
                              <li><a href="{{ route('contact.us') }}">Contact</a></li>
                              <li><a href="{{ route('news.list') }}">News</a></li>
                             
                          </ul>
                          <ul>
                             @php
                              $school_typee = App\Models\SchoolType::orderBy('id','asc')->get();
                             @endphp
                              @if(@$school_typee)
                              @foreach($school_typee as $type)
                               <li><a href="javascript:;" class="school_type" data-school_type="{{ @$type->id }}">{{ @$type->school_type }}</a></li>
                               @endforeach
                                @endif
                              <li><a href="{{ route('about.us') }}">About Us </a></li>
                              
                          </ul>
                      </div>
                  </div>
                  <div class="foot-right">
                      <h3>Contact Info</h3>
                      <ul>
                          {{--<li> <span>Address :</span> <p>NHIF Building Ragati Road P.O Box 34670 - 00100. Nairobi - Kenya</p></li>
                          <li> <span>Call :</span> <a href="#">(254 20) 253 38 69 </a> / <a href="#">(254 713) 761 758</a> </li>--}}
                          <li> <span>Email :</span> <a href="#">contact. mahula@gmail.com</a></li>
                      </ul>
                  </div>
               </div>

               <div class="footer-btms">
                  <div class="copy_text">
                     <p>Copyright © {{ date('Y') }} <a href="{{ route('home') }}">muhula.com</a>    |  All Rights Reserved</p>
                  </div>
                  <div class="right_links">
                     <ul>
                        <li> <a href="{{ route('faq') }}"> Faq </a> </li>
                        <li> <a href="{{ route('privacy.policy') }}"> Privacy Policy </a> </li>
                        <li> <a href="{{ route('disclaimer') }}"> Disclaimer </a> </li>
                     </ul>
                  </div>
               </div>

               <div class="socaila_links">
                  <p>Connect on Social</p>
                  <ul>
                     {{-- Facebook --}}
                     <li> <a href="https://www.facebook.com/share/1A23qfNztD/" target="_blank"> <img src="{{ asset('images/sc1.png') }}" alt=""> </a> </li>
                     {{-- LinkedIn --}}
                     <li> <a href="https://x.com/Muhulahub?t=xZyZyr9TfqqlYuqdWTIGoA&s=09" target="_blank"> <img src="{{ asset('images/sc2.png') }}" alt=""> </a> </li>
                     {{-- Twitter --}}
                     <li> <a href="https://x.com/Muhulahub?t=1H26wqGvec_N3Vs1ru9DYA&s=09" target="_blank"> <img src="{{ asset('images/sc3.png') }}" alt=""> </a> </li>
                     {{-- Youtube --}}
                     <li> <a href="#" target="_blank"> <img src="{{ asset('images/sc4.png') }}" alt=""> </a> </li>
                     {{-- Pinterest --}}
                     <li> <a href="#" target="_blank"> <img src="{{ asset('images/sc5.png') }}" alt=""> </a> </li>
                     {{-- Instagram --}}
                     <li> <a href="#" target="_blank"> <img src="{{ asset('images/sc6.png') }}" alt=""> </a> </li>
                  </ul>
               </div>

              </div>
            </div>

         </div>

      </footer>

      <button id="scrollToTopBtn" class="scrollTop">
         <img src="{{ asset('images/corner-left-up.png') }}" alt="">
      </button>