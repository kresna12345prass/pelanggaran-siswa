<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('kepsek.dashboard') }}" class="sidebar-brand-wrapper">
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
            Dashboard Eksekutif
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.dashboard') }}">
                <i class="fa-solid fa-chart-line"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Monitoring & Evaluasi
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.monitoring.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.monitoring.index') }}">
                <i class="fa-solid fa-clipboard-check"></i>
                Monitoring Kasus Berat
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.siswa_bermasalah.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.siswa_bermasalah.index') }}">
                <i class="fa-solid fa-user-slash"></i>
                Siswa Bermasalah
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.verifikasi_monitoring.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.verifikasi_monitoring.index') }}">
                <i class="fa-solid fa-tasks"></i>
                Monitoring Verifikasi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.monitoring_sanksi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.monitoring_sanksi.index') }}">
                <i class="fa-solid fa-gavel"></i>
                Monitoring Sanksi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('kepsek.laporan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kepsek.laporan.index') }}">
                <i class="fa-solid fa-file-alt"></i>
                Laporan Menyeluruh
            </a>
        </li>

    </ul>
</nav>
