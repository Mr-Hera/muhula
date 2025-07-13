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
                    <li class="breadcrumb-item active" aria-current="page">Terms and Conditions</li>
                  </ol>
                </nav>
               <h1 class="text-center">Terms and Conditions</h1>
            </div>         
         </div>
         <div class="container">
            <div class="privacy-body-text">
               <div class="prvbdy-box">
                  <h2 class="text-center">Disclaimer</h2>
                  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Illo libero dolore cumque minima perspiciatis animi laboriosam deleniti alias ipsa rerum nulla id, velit ullam mollitia neque, dolorum delectus, quasi cum fuga repellat fugiat. Suscipit, in consectetur? Impedit quis iure magnam ullam praesentium distinctio, doloribus odio aliquam dolores ducimus dolorum, officiis rem quibusdam obcaecati. Commodi quae, fugiat voluptatibus hic nam explicabo blanditiis suscipit maiores ipsum aliquam inventore officia fuga, consequuntur animi velit rerum quaerat eligendi tempora nemo minima voluptas itaque! Voluptatibus architecto deserunt, hic laborum deleniti praesentium? Maiores repellendus obcaecati molestiae! Voluptatibus quo commodi est aliquid repudiandae recusandae maiores quidem quisquam odio. Et amet, reprehenderit reiciendis magnam nobis dolorem animi nemo fugiat alias neque fugit totam ullam exercitationem minima soluta itaque asperiores laudantium molestiae facilis earum! Magnam, fugit eveniet. Rerum, mollitia beatae. Error quo, temporibus est quibusdam perferendis assumenda rerum beatae?</p>
                  <ul class="mb-0">
                     <li>Lorem ipsum dolor sit.</li>
                     <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                     <li>Lorem ipsum dolor sit amet consectetur.</li>
                  </ul>
               </div>
               <div class="prvbdy-box">
               <h2>Simply dummy heading</h2>
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                 <h2>Simply dummy heading</h2>
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                 <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                 <ul>
                    <li>Printing and typesetting industry lorem Ipsum</li>
                    <li>Typesetting industry lorem Ipsum</li>
                    <li>Printing and typesetting industry lorem Ipsum</li>
                 </ul>
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