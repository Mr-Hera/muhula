@extends('layouts.app')
@section('title','Messages')
@section('links')
@include('includes.links')
@endsection
@section('headers')
@include('includes.header')
@endsection
@section('content')
<section class="after_login_body">
         <div class="container-fluid top-container">
            <div class="row">
            @include('includes.sidebar')
               <div class="dashboard_right_panel">
                  <div class="dashboard_right_heading d-flex justify-content-between align-items-start">
                     <!-- Left side -->
                     <div>
                        <h3 class="mb-1">My Messages</h3>
                        <p class="mb-0">See all your messages here.</p>
                     </div>

                     <!-- Right side -->
                     <button class="save_btns mt-0" type="button" data-bs-toggle="modal" data-bs-target="#newsModal">
                        Send Message 
                        <img src="{{ asset('images/click_s.png') }}" alt="" class="ml-2">
                     </button>
                  </div>

                  <!-- Modal -->
                  <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                           
                           <div class="modal-header">
                           <h5 class="modal-title" id="newsModalLabel">Send a message to a school</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>

                           <div class="modal-body">
                              <form action="{{ route('user.send.message') }}" method="post" id="newsForm" enctype="multipart/form-data">
                                    @csrf
                                    {{--<input type="hidden" name="school_id" id="" value="{{ @$schoolDetails->id }}"> 
                                    <input type="hidden" name="news_id" id="" value="{{ @$newsData->id }}">--}}

                                    <div class="row">
                                       <div class="col-sm-12 cols">
                                          <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                                             <div class="dash_input mb-3">
                                                <label for="school_id">School:</label>
                                                <select name="school_id" id="school_id" class="form-control">
                                                      <option value="">-- Select School --</option>
                                                      @foreach($schools as $school)
                                                         <option value="{{ $school->id }}">
                                                            {{ $school->name }} - {{ $school->schoolLevel->name ?? 'N/A' }}
                                                         </option>
                                                      @endforeach
                                                </select>
                                             </div>
                                          </div>

                                          <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12">
                                                <div class="dash_input">
                                                   <label>Message:</label>
                                                   <textarea placeholder="Enter message" name="message"></textarea>
                                                </div>
                                          </div>

                                          <div class="col-lg-6 col-xl-4 col-sm-6 col-md-6 col-12 cols">
                                                <div class="dash_input mb-1">
                                                   <label>Attach Image</label>
                                                   <div class="uplodimgfil2">
                                                      <input type="file" name="attached_message_image" id="attached_message_image" class="inputfile2 inputfile-1">
                                                      <label for="attached_message_image">                                          
                                                            <h3>Click here to upload </h3>
                                                            <img src="{{ asset('images/upload1.png') }}" alt="">
                                                      </label>
                                                   </div>
                                                </div>
                                                <label id="image_error" for="" class="error" style="display:none;"></label>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="save_sec">
                                       <button
                                          class="btn mt-3"
                                          style="background: var(--lime-linear); border: none; color: #fff; padding: 10px 20px; border-radius: 8px;"
                                          type="submit"
                                       >
                                          Send
                                          <img src="{{ asset('images/click_s.png') }}" alt="" class="ml-2">
                                       </button>
                                    </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- End of modal -->

                  <div class="dashboard_box">
                     @if($messages->isNotEmpty())
                     <?php $sub_array = []; ?>
                        <div id="message-container" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                        @foreach($messages as $data)
                           <div class="message-list-box">
                              <div class="message_owner">
                                 <div class="measge_name">
                                    <a href="{{ route('user.message.detail',[$data->id]) }}">
                                       @if($data->sender->profile_image != null)
                                          <img src="{{ URL::to('storage/app/public/images/userImage') }}/{{ $data->sender->profile_image }}" alt="">
                                       @else
                                          <img src="{{ asset('images/avatar.png') }}" alt="">
                                       @endif
                                       <h3>{{ $data->conversation?->title }}</h3>
                                    </a>
                                 </div>
                                 <div class="message_date">
                                    <p>
                                       <img src="{{ asset('images/clock.png') }}" alt="">{{ date('d/m/Y',strtotime($data->date)) }}, {{ date('h:i A',strtotime($data->date)) }}
                                    </p>
                                    <a href="{{ route('user.message.detail',[$data->id]) }}">
                                       <img src="{{ asset('images/repeat.png') }}"> Reply
                                    </a>
                                 </div>
                              </div>
                                 <div class="message_body">
                                    <p>{{ $data->content }}</p>
                                 </div>
                           </div>
                        <?php array_push($sub_array,$data->sender_id); ?>
                        @endforeach
                        </div>
                        <div id="loading" class="text-center mt-2" style="display: none;">
                           <p>Loading...</p>
                        </div>
                        @else
                        <h3><center>No Data Found</center></h3>
                     @endif

                     <div class="dashboard_pagination">
                        <div class="pagination_box">
                           {{-- {{@$messageData->appends(request()->except(['page', '_token']))->links('pagination')}} --}}
                        </div>
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
<script>
let currentPage = 1;
let loading = false;
let hasMore = true;

function loadMessages(page = 1) {
    if (loading || !hasMore) return;

    loading = true;
    document.getElementById('loading').style.display = 'block';

    fetch(`{{ route('messages.load') }}?page=${page}`)
        .then(res => res.json())
        .then(res => {
            let container = document.getElementById('message-container');

            res.data.forEach(msg => {
                let box = document.createElement('div');
                box.classList.add('message-list-box', 'mb-3');
                box.innerHTML = `
                    <div class="message_owner">
                        <div class="measge_name">
                            <a href="/user/messages/${msg.id}">
                                <img src="${msg.sender?.profile_image 
                                    ? '/storage/app/public/images/userImage/' + msg.sender.profile_image 
                                    : '{{ asset('images/avatar.png') }}'}" alt="">
                                <h3>${msg.conversation?.title ?? 'No Title'}</h3>
                            </a>
                        </div>
                        <div class="message_date">
                            <p>
                                <img src="{{ asset('images/clock.png') }}" alt="">
                                ${new Date(msg.date).toLocaleDateString()} 
                                ${new Date(msg.date).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </p>
                            <a href="/user/messages/${msg.id}">
                                <img src="{{ asset('images/repeat.png') }}"> Reply
                            </a>
                        </div>
                    </div>
                    <div class="message_body">
                        <p>${msg.content}</p>
                    </div>
                `;
                container.appendChild(box);
            });

            hasMore = res.next_page !== null;
            if (hasMore) currentPage = res.next_page;
        })
        .finally(() => {
            loading = false;
            document.getElementById('loading').style.display = 'none';
        });
}

// initial load
loadMessages();

// listen to scroll
document.getElementById('message-container').addEventListener('scroll', function() {
    if (this.scrollTop + this.clientHeight >= this.scrollHeight - 50) {
        loadMessages(currentPage);
    }
});
</script>
