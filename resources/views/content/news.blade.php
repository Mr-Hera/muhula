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
         <img src="{{ url('images/news_banne.png') }}" alt="" class="innr-bnnr-img ">
         <div class="in-bn-txt">
            <div class="container ">
               <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"> News </li>
                  </ol>
                </nav>
               <h1>Find News Here</h1>
            </div>         
         </div>
      </section>

      <section class="search_countown">
         <div class="container">
         <form action="{{ route('news.list') }}" method="post">
            @csrf
            <div class="row ">
               <div class="col-lg-5 col-xl-4 col-md-6 col-9">
                  <div class="search_in m-0 new_searc">
                           <label>Search by Keyword</label>
                           <input type="text" name="keyword" placeholder="Enter here" value="{{ @$key['keyword'] }}">
                        </div>
               </div>
               <div class="new_se_btns">
                  <button type="submit" class="bnr-btn">Search</button>
               </div>
               
            </div>
            </form>
         </div>
      </section>

      <section class="news_listing">
         <div class="container">
            <div class="row">
               <div class="result_div">
                  <h3>Result: {{ $allNews->count() }} news Found </h3>
                  
               </div>

            </div>

            <div class="total_news">
               <div class="row">
                  @if(@$allNews->isNotEmpty())
                     @foreach($allNews as $data)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                           <div class="news_box">
                              <div class="news_imgs">
                                 @if($data->author_id == auth()->id())
                                    <div class="spans"><p> {{ date('d',strtotime($data->created_at)) }} <span>{{ date('M',strtotime($data->created_at)) }}</span></p> </div>
                                 @else 
                                    <div class="spans"><p> {{ $data->created_at?date('d',strtotime($data->created_at)):'' }} <span>{{$data->created_at?date('M',strtotime($data->created_at)):'' }}</span></p> </div> 
                                 @endif
                                 <a href="{{ route('news.details',$data->slug) }}"> 
                                    @if($data->cover_image)
                                       @php
                                          // Image path stored in DB (already relative to public/)
                                          // Example: images/news_covers/example.jpg
                                          $imageFile = ltrim($data->cover_image, '/');

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
                                 </a>
                              </div>
                              <div class="news_text">
                                 <div class="news_info">
                                    <div class="adm_namee"> 
                                    <img src="{{ asset('images/user.png') }}" alt="">
                                       <p>Posted by, <span>
                                          @if($data->author_id == auth()->id())
                                             {{-- {{ @$data->getUser->first_name.' '.@$data->getUser->last_name }} --}}User Full Name
                                          @else
                                             Admin
                                          @endif
                                          </span>
                                       </p>
                                    </div>
                                 
                                    <h2>
                                       <a href="{{ route('news.details',$data->slug) }}">
                                          @if(strlen($data->title)>100)
                                             {{ substr($data->title,0,100) }}
                                          @else
                                             {{ $data->title }}
                                          @endif
                                       </a>
                                    </h2>

                                    <div class="read_more_b">
                                       <a href="{{ route('news.details',$data->slug) }}">Read More <img src="{{ asset('images/chevrone.png') }}" alt=""> </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     @else
                        <h2><center>No Data Found</center></h2>
                     @endif

                  {{--<div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="#"> <img src="{{ url('public/images/news2.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="#">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="#">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 17 <span> JAN</span></p> </div> 
                              <a href="#"> <img src="{{ url('public/images/news3.png') }}" alt=""> </a>
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
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news6.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 17 <span> JAN</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news7.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Lyndah Kemunto</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news8.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                              <div class="news_imgs">
                                 <div class="spans"><p> 20 <span> SEP</span></p> </div> 
                                 <a href="news-details.html"> <img src="{{ url('public/images/news5.png') }}" alt=""> </a>
                              </div>
                              <div class="news_text">
                                 <div class="news_info">
                                    <div class="adm_namee">
                                       <img src="{{ url('public/images/user.png') }}" alt="">
                                       <p>Posted by, <span> Elizabeth Gitau</span></p>
                                    </div>
                                    <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                    <div class="read_more_b">
                                       <a href="#">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                    </div>
                                 </div>
                              </div>
                     </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news9.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 17 <span> JAN</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news10.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Lyndah Kemunto</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news11.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 05 <span> FEB</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news12.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Dianaisaly Marionaul</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>

                  <div class="col-lg-4 col-md-6 col-sm-6">
                     <div class="news_box">
                           <div class="news_imgs">
                              <div class="spans"><p> 17 <span> JAN</span></p> </div> 
                              <a href="news-details.html"> <img src="{{ url('public/images/news13.png') }}" alt=""> </a>
                           </div>
                           <div class="news_text">
                              <div class="news_info">
                                 <div class="adm_namee">
                                    <img src="{{ url('public/images/user.png') }}" alt="">
                                    <p>Posted by, <span> Lyndah Kemunto</span></p>
                                 </div>
                                 <h2> <a href="news-details.html">DMS-Department of in Management The quality a role of the elementary teacher in education</a> </h2>

                                 <div class="read_more_b">
                                    <a href="news-details.html">Read More <img src="{{ url('public/images/chevrone.png') }}" alt=""> </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>--}}


                  <div class="pagination_box">
                  {{-- {{$allNews->appends(request()->except(['page', '_token']))->links('pagination')}} --}}


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
