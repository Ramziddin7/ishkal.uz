<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WorldUz') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('laravelUi.js') }} " defer></script> --}}
    {{-- <script src="asset('laravelUi.js') }}" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="{{ asset('fontawesome.js') }}" crossorigin="anonymous"></script>

    <link href="{{ asset('font.css')}}" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('laravelUi.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous"> --}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm ">
            <div class="container">

                @auth
                    {{auth()->user()->name}}
                    <div class="text-end">
                    <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Logout</a>
                    </div>
                @endauth

                @guest
                    <div class="text-end">
                    <a href="{{ route('login.show') }}" class="nav-link">Login</a>
                    </div>
                @endguest

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    @auth
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('country.web.index') }}">{{ __('Davlat') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('university.web.index') }}">{{ __('Universitet') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('field.web.index') }}">{{ __('Field(Faculty)') }}</a>
                            </li>
                    </ul>
                    @endauth
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="{{asset('bootstrap.css')}}"></script>
</body>
</html>
