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
         <img src="{{ asset('images/news_banne.png') }}" alt="" class="innr-bnnr-img ">
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
                        <h2>{{ $article->title }}</h2>
                        <div class="news_posted_d">
                           <div class="news_time">
                              <div class="adm_namee1">
                                  <img src="{{ asset('images/user.png') }}" alt="">
                                 <p>Posted by, <span>
                                    @if($article->author_id == auth()->id())
                                       {{ optional($article->author)->first_name }} {{ optional($article->author)->last_name }}
                                    @else
                                       Admin
                                    @endif
                                   </span></p>
                              </div>
                            
                              <div class="adm_namee1">
                                 <img src="{{ asset('images/calendars.png') }}" alt="">
                                 @if($article->author_id == auth()->id())
                                    <p>{{ $article->created_at?date('jS F, Y',strtotime($article->created_at)):'' }}</p>
                                 @else
                                    <p>{{ $article->updated_at?date('jS F, Y',strtotime($article->updated_at)):'' }}</p>
                                 @endif
                              </div>
                           </div>
                           <div class="share_a">
                              <p> <img src="{{ asset('images/share2.png') }}" alt=""> Share</p>
                              <div class="sharethis-inline-share-buttons"></div>
                           </div>
                        </div>
                     </div>

                     <div class="news_details_img">
                        @if($article->cover_image)
                           @php
                              // Image path stored in DB (already relative to public/)
                              // Example: images/news_covers/example.jpg
                              $imageFile = ltrim($article->cover_image, '/');

                              // Absolute filesystem path for existence check
                              $imageFullPath = public_path($imageFile);

                              // Fallback if missing
                              if (!file_exists($imageFullPath)) {
                                    $imageFile = 'default_images/default.jpg';
                              }

                              // Prefix from config ('' locally, '/public' on production)
                              $prefix = trim(config('app.public_path_prefix'), '/');

                              // Build final public URL
                              $imageUrl = $prefix
                                    ? url($prefix . '/' . $imageFile)
                                    : url($imageFile);
                           @endphp

                           <img src="{{ $imageUrl }}" alt="{{ $data->title ?? 'News Image' }}">
                        @endif
                     </div>
                     <div class="news_de_text">
                        {!! nl2br($article->body) !!}
                     </div>
                  </div>
               </div>


               {{-- <div class="col-lg-4">

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
                     </div>
                  </div>

               </div> --}}
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