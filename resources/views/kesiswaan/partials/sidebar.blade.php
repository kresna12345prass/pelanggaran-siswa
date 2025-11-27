<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('kesiswaan.dashboard.index') }}" class="sidebar-brand-wrapper">
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
        <li class="menu-header">Utama</li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.dashboard.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.dashboard.index') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">Verifikasi & Input</li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.verifikasi.index') || request()->routeIs('kesiswaan.verifikasi.show') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.verifikasi.index') }}">
                <i class="fa-solid fa-clipboard-check"></i>
                Verifikasi Laporan
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.verifikasi.riwayat') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.verifikasi.riwayat') }}">
                <i class="fa-solid fa-history"></i>
                Riwayat Verifikasi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.pelanggaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.pelanggaran.index') }}">
                <i class="fa-solid fa-exclamation-triangle"></i>
                Data Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.prestasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.prestasi.index') }}">
                <i class="fa-solid fa-trophy"></i>
                Data Prestasi
            </a>
        </li>

        <li class="menu-header">Sanksi & Monitoring</li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.sanksi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.sanksi.index') }}">
                <i class="fa-solid fa-gavel"></i>
                Data Sanksi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.pelaksanaan.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.pelaksanaan.index') }}">
                <i class="fa-solid fa-clipboard-check"></i>
                Update Pelaksanaan
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kesiswaan.pelaksanaan.riwayat') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kesiswaan.pelaksanaan.riwayat') }}">
                <i class="fa-solid fa-history"></i>
                Riwayat Pelaksanaan
            </a>
        </li>
    </ul>
</nav>
