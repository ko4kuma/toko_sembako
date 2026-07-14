<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS Toko Sembako - @yield('title')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Custom JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    @include('layouts.navbar')
    {{-- wrapper sidebar --}}
    <div class="d-flex" id="appWrapper">
        @include('layouts.sidebar')

        <div class="flex-grow-1" id="mainContent">
            <div class="container-fluid p-3">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>