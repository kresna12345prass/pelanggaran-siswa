<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('guru.dashboard') }}" class="sidebar-brand-wrapper">
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
        <li class="nav-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Pelaporan
        </li>
        <li class="nav-item {{ request()->routeIs('guru.laporan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.laporan.index') }}">
                <i class="fa-solid fa-file-circle-plus"></i>
                Lapor Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('guru.riwayat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.riwayat.index') }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Riwayat Laporanku
            </a>
        </li>

    </ul>
</nav>
