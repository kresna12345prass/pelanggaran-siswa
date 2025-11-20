<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Orang Tua') - SISKAR BN666</title>

    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">

    <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/orbitron.css') }}">

    @vite(['resources/css/app.css', 'resources/css/ortu/layout.css'])

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        
        @include('ortu.partials.sidebar')

        <div class="main-content">
            
            @include('ortu.partials.navbar')

            <main class="page-content">
                @yield('content')
            </main>

            @include('ortu.partials.footer')

        </div>
    </div>
    
    <div class="sidebar-overlay"></div>

    @vite(['resources/js/app.js', 'resources/js/ortu/layout.js'])
    
    @stack('scripts')
</body>

</html>
