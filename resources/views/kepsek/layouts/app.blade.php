<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <title>@yield('title', 'Dashboard Kepala Sekolah') - SISKAR BN666</title>

    <link rel="icon" type="image/png" href="{{ asset('logo SMK.png') }}">

    <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/orbitron.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('kepsek/layout.css') }}">

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        
        @include('kepsek.partials.sidebar')

        <div class="main-content">
            
            @include('kepsek.partials.navbar')

            <main class="page-content">
                @yield('content')
            </main>

            @include('kepsek.partials.footer')

        </div>
    </div>
    
    <div class="sidebar-overlay"></div>

    <!-- Dark Mode Toggle Button -->
    <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
        <i class="fa-solid fa-moon"></i>
    </button>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('app.js') }}"></script>
    <script src="{{ asset('kepsek/layout.js') }}"></script>
    
    @stack('scripts')
</body>

</html>
