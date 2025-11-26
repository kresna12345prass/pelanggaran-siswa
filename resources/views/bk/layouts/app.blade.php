<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BK Dashboard') - SISKAR BN666</title>

    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">

    <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/orbitron.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('bk/layout.css') }}">

    @stack('styles')
</head>

<body>
    <div class="wrapper">
        
        @include('bk.partials.sidebar')

        <div class="main-content">
            
            @include('bk.partials.navbar')

            <main class="page-content">
                @yield('content')
            </main>

            @include('bk.partials.footer')

        </div>
    </div>
    
    <div class="sidebar-overlay"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('app.js') }}"></script>
    <script src="{{ asset('bk/layout.js') }}"></script>
    
    @stack('scripts')
</body>

</html>
