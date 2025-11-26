<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - SISKAR BN666</title>
    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">

    <link rel="stylesheet" href="{{ asset('fonts/poppins.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/orbitron.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link rel="stylesheet" href="{{ asset('login.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('app.js') }}" defer></script>
</head>

<body class="login-body-siskar">

    <div class="login-container-siskar">
        <div class="login-branding-side">
            <div class="circle circle-lg"></div>
            <div class="circle circle-md"></div>
            <div class="circle circle-sm"></div>

            <div class="login-branding-content">
                <a href="{{ route('welcome') }}" class="text-decoration-none text-white">
                    <div class="login-logo-container">
                        <img src="{{ asset('logo2.png') }}" alt="Logo SMK" class="login-school-logo">
                        <div class="login-logo-siskar">
                            <span class="logo-sis">SIS</span><span class="logo-kar">KAR</span>
                            <span class="logo-sub">BN 666</span>
                        </div>
                    </div>
                    <p class="login-tagline">Sistem Poin Karakter SMK Bakti Nusantara 666</p>
                </a>
            </div>
        </div>

        <div class="login-form-side">
            
            <div class="login-header">
                <h2><i class="fa-solid fa-right-to-bracket me-2"></i>Masuk ke Sistem</h2>
                <p class="login-subtitle">Silakan masuk dengan akun Anda</p>
            </div>
            
            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger alert-login" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group-icon">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nama@email.com"
                               value="{{ old('email') }}" 
                               required>
                        <i class="fa-solid fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group-icon">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Masukkan password Anda"
                               required>
                        <i class="fa-solid fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="login-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login-siskar">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>
                    MASUK
                </button>

                <div class="back-to-welcome">
                    <a href="{{ route('welcome') }}" class="btn-back-home">
                        <i class="fa-solid fa-house me-2"></i>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>