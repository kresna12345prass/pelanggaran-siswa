<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('wali_kelas.dashboard') }}" class="sidebar-brand-wrapper">
            <img src="{{ asset('logo SMK.png') }}" alt="Logo" class="sidebar-logo-img">
            <div class="logo-brand">
                <div class="logo-main">
                    <span class="logo-sis">SIS</span><span class="logo-kar">KAR</span>
                </div>
                <span class="logo-sub">BN 666</span>
            </div>
        </a>
    </div>

    <ul class="nav sidebar-menu flex-column">

        <li class="menu-header">
            Utama
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Pelaporan
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.laporan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.laporan.index') }}">
                <i class="fa-solid fa-file-circle-plus"></i>
                Lapor Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.riwayat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.riwayat.index') }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Riwayat Laporanku
            </a>
        </li>

        <li class="menu-header">
            Kelas Binaan
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.monitoring.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.monitoring.index') }}">
                <i class="fa-solid fa-users"></i>
                Monitoring Kelas
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.pelanggaran_kelas.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.pelanggaran_kelas.index') }}">
                <i class="fa-solid fa-exclamation-triangle"></i>
                Data Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.prestasi_kelas.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.prestasi_kelas.index') }}">
                <i class="fa-solid fa-trophy"></i>
                Data Prestasi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('wali_kelas.sanksi_kelas.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('wali_kelas.sanksi_kelas.index') }}">
                <i class="fa-solid fa-gavel"></i>
                Data Sanksi
            </a>
        </li>


    </ul>
</nav>
