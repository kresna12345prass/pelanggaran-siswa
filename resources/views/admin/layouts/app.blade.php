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

    <!-- Vite (CSS Global & Layout) -->
    @vite(['resources/css/app.css', 'resources/css/admin/layout.css'])

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

    <!-- Vite (JS Global & Layout) -->
    @vite(['resources/js/app.js', 'resources/js/admin/layout.js'])
    
    <!-- Duplicate Validation Script -->
    @vite(['resources/js/admin/duplicate-validation.js'])
    
    <!-- Stack untuk JS per halaman (misal: dashboard.js & chart.js) -->
    @stack('scripts')
</body>

</html>