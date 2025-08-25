<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/fal_icon.png') }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    {{-- datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <title>@yield('title')</title>

    @yield('links')
    
</head>
<body>
    

    <div id="app">
        <example-component></example-component>
    </div>
   
    @yield('headers')
    @yield('sidebar')
    @yield('content')
    @yield('footer')
    @yield('script')

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>