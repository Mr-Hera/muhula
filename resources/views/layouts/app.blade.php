<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('images/fal_icon.png') }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

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
</body>
</html>