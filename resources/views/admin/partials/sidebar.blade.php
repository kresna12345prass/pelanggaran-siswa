<nav class="sidebar">
    <!-- Logo -->
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-wrapper">
            <img src="{{ asset('logo SMK.png') }}" alt="Logo" class="sidebar-logo-img">
            <div class="logo-brand">
                <div class="logo-main">
                    <span class="logo-sis">SIS</span><span class="logo-kar">KAR</span>
                </div>
                <span class="logo-sub">BN 666</span>
            </div>
        </a>
    </div>

    <!-- Menu -->
    <ul class="nav sidebar-menu flex-column">

        <li class="menu-header">
            Utama
        </li>
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i>
                Dashboard
            </a>
        </li>

        <li class="menu-header">
            Master Aturan
        </li>
        <li class="nav-item {{ request()->routeIs('admin.kategori_pelanggaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.kategori_pelanggaran.index') }}">
                <i class="fa-solid fa-list"></i>
                Kategori Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.aturan_pelanggaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.aturan_pelanggaran.index') }}">
                <i class="fa-solid fa-gavel"></i>
                Aturan Pelanggaran
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.aturan_sanksi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.aturan_sanksi.index') }}">
                <i class="fa-solid fa-scale-balanced"></i>
                Aturan Sanksi
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.tata_tertib.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.tata_tertib.index') }}">
                <i class="fa-solid fa-book-open"></i>
                Editor Tata Tertib
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.jenis_prestasi.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.jenis_prestasi.index') }}">
                <i class="fa-solid fa-trophy"></i>
                Jenis Prestasi
            </a>
        </li>

        <li class="menu-header">
            Manajemen Pengguna
        </li>
        <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fa-solid fa-users-cog"></i>
                Pengguna Sistem
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.siswa.index') }}">
                <i class="fa-solid fa-address-card"></i>
                Data Siswa
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.guru.index') }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                Data Guru
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.orangtua.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.orangtua.index') }}">
                <i class="fa-solid fa-user-group"></i>
                Data Orang Tua
            </a>
        </li>

        <li class="menu-header">
            Manajemen Akademik
        </li>
        <li class="nav-item {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.jurusan.index') }}">
                <i class="fa-solid fa-graduation-cap"></i>
                Data Jurusan
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.kelas.index') }}">
                <i class="fa-solid fa-school"></i>
                Data Kelas
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.wali_kelas.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.wali_kelas.index') }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                Data Wali Kelas
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.tahun_ajaran.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.tahun_ajaran.index') }}">
                <i class="fa-solid fa-calendar-alt"></i>
                Tahun Ajaran
            </a>
        </li>

        <li class="menu-header">
            Backup Data
        </li>

        <li class="nav-item {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.backup.index') }}">
                <i class="fa-solid fa-database"></i>
                Backup Database
            </a>
        </li>

    </ul>
</nav>
