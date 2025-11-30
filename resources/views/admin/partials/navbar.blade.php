<nav class="navbar navbar-expand-lg admin-navbar sticky-top">
    
    <!-- Tombol Toggle Sidebar -->
    <button class="navbar-toggler-admin" type="button" id="sidebarToggle">
        <i class="fa-solid fa-bars"></i>
    </button>
    
    <!-- Search Bar (Placeholder) -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Cari siswa atau guru..." />
            <button class="btn btn-primary" type="button"><i class="fa-solid fa-search"></i></button>
        </div>
    </form>
    
    <!-- Menu Kanan (Theme Toggle + User) -->
    <ul class="navbar-nav ms-auto ms-md-0">
        <li class="nav-item">
            <button class="theme-toggle-navbar" id="themeToggleBtn">
                <i class="fas fa-moon"></i>
            </button>
        </li>
        <li class="nav-item dropdown user-dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-none d-md-inline me-2 user-name">{{ Auth::user()->nama_lengkap ?? Auth::user()->email }}</span>
                <!-- Placeholder avatar, ganti dengan foto user jika ada -->
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama_lengkap ?? 'A') }}&background=0d6efd&color=fff" alt="Avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa-solid fa-user me-2"></i>Profil Saya</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <!-- Form Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
