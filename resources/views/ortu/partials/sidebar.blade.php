<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('ortu.dashboard') }}" class="sidebar-brand-wrapper">
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
        <li class="nav-item {{ request()->routeIs('ortu.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ortu.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Pantau Anak
        </li>
        <li class="nav-item {{ request()->routeIs('ortu.riwayat.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ortu.riwayat.index') }}">
                <i class="fa-solid fa-history"></i>
                Riwayat Poin
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('ortu.sanksi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ortu.sanksi.index') }}">
                <i class="fa-solid fa-exclamation-triangle"></i>
                Info Sanksi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('ortu.prestasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('ortu.prestasi.index') }}">
                <i class="fa-solid fa-trophy"></i>
                Data Prestasi
            </a>
        </li>

    </ul>
</nav>
