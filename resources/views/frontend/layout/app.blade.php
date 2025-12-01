<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        @yield('title', 'BookSaw - Library')
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/style.css') }}">

    @stack('styles')

</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

    @include('frontend.layout.header')

    <main class="container">
        @yield('content')
    </main>

    @include('frontend.layout.footer')

    <script src="{{ asset('assets/frontend/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="{{ asset('assets/frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/script.js') }}"></script>

    @stack('scripts')
</body>

</html>
