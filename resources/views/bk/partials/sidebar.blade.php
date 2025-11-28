<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('bk.dashboard') }}" class="sidebar-brand-wrapper">
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
        <li class="nav-item {{ request()->routeIs('bk.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bk.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Manajemen Konseling
        </li>
        <li class="nav-item {{ request()->routeIs('bk.watchlist.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bk.watchlist.index') }}">
                <i class="fa-solid fa-eye"></i>
                Watchlist Siswa
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('bk.konseling.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bk.konseling.index') }}">
                <i class="fa-solid fa-comments"></i>
                Data Konseling
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('bk.tindak_lanjut.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bk.tindak_lanjut.index') }}">
                <i class="fa-solid fa-clipboard-check"></i>
                Tindak Lanjut
            </a>
        </li>

    </ul>
</nav>
