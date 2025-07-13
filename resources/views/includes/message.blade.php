@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" style="text-align: center;">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="list-style: none;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible" style="text-align: center;">
        <span>{!! session()->get('success') !!}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible" style="text-align: center;">
        <span>{{ session()->get('error') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif