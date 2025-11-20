<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('siswa.dashboard') }}" class="sidebar-brand-wrapper">
            <img src="{{ asset('logo1.png') }}" alt="Logo" class="sidebar-logo-img">
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
        <li class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Data Pelanggaran
        </li>
        <li class="nav-item {{ request()->routeIs('siswa.riwayat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.riwayat.index') }}">
                <i class="fa-solid fa-history"></i>
                Riwayat Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('siswa.sanksi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.sanksi.index') }}">
                <i class="fa-solid fa-exclamation-triangle"></i>
                Status Sanksi
            </a>
        </li>

        <li class="menu-header">
            Data Prestasi
        </li>
        <li class="nav-item {{ request()->routeIs('siswa.prestasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.prestasi.index') }}">
                <i class="fa-solid fa-trophy"></i>
                Data Prestasi
            </a>
        </li>

    </ul>
</nav>
