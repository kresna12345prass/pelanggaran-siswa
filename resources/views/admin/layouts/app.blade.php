<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Judul Halaman Dinamis -->
    <title>@yield('title', 'Admin Dashboard') - SISKAR BN666</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">

    <!-- Google Fonts (Lokal) -->
    <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/orbitron.css') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- CSS Global & Layout -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/layout.css') }}">

    <!-- Stack untuk CSS per halaman (misal: dashboard.css) -->
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        
        <!-- === Sidebar === -->
        @include('admin.partials.sidebar')

        <!-- === Konten Utama (Navbar + Halaman) === -->
        <div class="main-content">
            
            <!-- === Navbar === -->
            @include('admin.partials.navbar')

            <!-- === Isi Halaman (dinamis) === -->
            <main class="page-content">
                @yield('content')
            </main>

            <!-- === Footer === -->
            @include('admin.partials.footer')

        </div>
    </div>
    
    <!-- Overlay untuk sidebar mobile -->
    <div class="sidebar-overlay"></div>

    <!-- jQuery (harus pertama) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- JS Global & Layout -->
    <script src="{{ asset('app.js') }}"></script>
    <script src="{{ asset('admin/layout.js') }}"></script>
    
    <!-- Duplicate Validation Script -->
    <script src="{{ asset('admin/duplicate-validation.js') }}"></script>
    
    <!-- Stack untuk JS per halaman (misal: dashboard.js & chart.js) -->
    @stack('scripts')
</body>

</html>