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
         <img src="{{ url('public/images/news_banne.png') }}" alt="" class="innr-bnnr-img ">
         <div class="in-bn-txt">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">News</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> News details</li>
                  </ol>
                </nav>
               <h1>Muhula News</h1>
            </div>         
         </div>
      </section>

      <section class="new_details_sec">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                  <div class="news_details_info">
                     <div class="news_tops">
                        <h2>{{ @$newsData->news_title }}</h2>
                        <div class="news_posted_d">
                           <div class="news_time">
                              <div class="adm_namee1">
                                  <img src="{{ url('public/images/user.png') }}" alt="">
                                 <p>Posted by, <span>
                                    @if(@$newsData->posted_by == 'U')
                                    {{ @$newsData->getUser->first_name.' '.@$newsData->getUser->last_name }}
                                    @else
                                    Admin
                                    @endif
                                   </span></p>
                              </div>
                            
                              <div class="adm_namee1">
                                 <img src="{{ url('public/images/calendars.png') }}" alt="">
                                  @if(@$newsData->posted_by == 'U')
                                  <p>{{ @$newsData->created_at?date('jS F, Y',strtotime(@$newsData->created_at)):'' }}</p>
                                  @else
                                 <p>{{ @$newsData->news_date?date('jS F, Y',strtotime(@$newsData->news_date)):'' }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="share_a">
                              <p> <img src="{{ url('public/images/share2.png') }}" alt=""> Share</p>
                              <div class="sharethis-inline-share-buttons"></div>
                              {{--<ul>
                                 <li> <a href="#"> <img src="{{ url('public/images/share1.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ url('public/images/share3.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ url('public/images/share4.png') }}" alt=""> </a> </li>
                                 <li> <a href="#"> <img src="{{ url('public/images/share5.png') }}" alt=""> </a> </li>
                              </ul>--}}
                           </div>
                        </div>
                     </div>

                     <div class="news_details_img">
                     @if(@$newsData->image != null)
                     <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ @$newsData->image }}" alt=""> 
                      @endif
                     </div>
                     <div class="news_de_text">
                        {!! nl2br(@$newsData->description) !!}
                        {{--<p>Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has been the industry's standard dummy text since the  when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the </p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. The purpose of lorem</p>
                        <p>The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.</p>
                        <h3>Some captions for news subheadings will be shown here</h3>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the focus is meant to be on design, not content.
                          The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers</p>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful when the. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. The purpose of lorem ipsum is to create a natural looking block of text (sentence, paragraph, page, etc.) that doesn't distract from the layout. A practice not without controversy, laying out pages with meaningless filler text can be very useful</p>
                        <p>The passage experienced a surge in popularity during the 1960s when Letraset used it on their dry-transfer sheets, and again during the 90s as desktop publishers bundled the text with their software. Today it's seen all around the web; on templates, websites, and stock designs. Use our generator to get your own, or read on for the authoritative history of lorem ipsum.</p>--}}
                     </div>
                  </div>
               </div>


               <div class="col-lg-4">

                  <div class="related_news">
                     <h3>Related News</h3>
                     <div class="related_nws_divs">
                        @if(@$relatedNews->isNotEmpty())
                        @foreach($relatedNews as $data)
                        <div class="news_box relate_nes">
                           <div class="news_imgs">
                              @if(@$data->posted_by == 'U')
                              <div class="spans"><p> {{ date('d',strtotime(@$data->created_at)) }} <span>{{ date('M',strtotime(@$data->created_at)) }}</span></p> </div>
                              @else 
                              <div class="spans"><p> {{ @$data->news_date?date('d',strtotime(@$data->news_date)):'' }} <span>{{ @$data->news_date?date('M',strtotime(@$data->news_date)):'' }}</span></p> </div> 
                              @endif
                              <a href="{{ route('news.details',@$data->slug) }}"> 
                              @if(@$data->image != null)
                                 <img src="{{ URL::to('storage/app/public/images/news_image') }}/{{ @$data->image }}" alt=""> 
                                 @endif
                                </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> 
                                    @if(@$newsData->posted_by == 'U')
                                    {{ @$newsData->getUser->first_name.' '.@$newsData->getUser->last_name }}
                                    @else
                                    Admin
                                    @endif
                                     </span></p>
                                 </div>
                                 <h2> <a href="{{ route('news.details',@$data->slug) }}">
                                 @if(strlen(@$data->news_title)>100)
                                 {{ substr(@$data->news_title,0,100) }}
                                 @else
                                 {{ @$data->news_title }}
                                 @endif
                                 </a> </h2>

                                 <div class="read_more_b">
                                    <a href="{{ route('news.details',@$data->slug) }}">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                        @endif

                        {{--<div class="news_box relate_nes">
                           <div class="news_imgs">
                              <div class="spans"><p> 20 <span> SEP</span></p> </div> 
                              <a href="#"> <img src="{{ url('public/images/relanews1.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Lyndah Kemunto</span></p>
                                 </div>
                                 <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="#">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="news_box relate_nes">
                           <div class="news_imgs">
                              <div class="spans"><p> 20 <span> SEP</span></p> </div> 
                              <a href="#"> <img src="{{ url('public/images/news13.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Lyndah Kemunto</span></p>
                                 </div>
                                 <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="#">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>--}}
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
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=660bc6f958eed300122e7dab&product=inline-share-buttons&source=platform" async="async"></script>
@endsection