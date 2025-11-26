<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISKAR BN666 - Sistem Poin Karakter SMK Bakti Nusantara 666</title>

    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('app.js') }}" defer></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('logo2.png') }}" alt="Logo SMK" height="40" class="me-2">
                    <div class="logo-brand">
                        <span class="logo-sis">SIS</span><span class="logo-kar">KAR</span>
                        <span class="logo-sub">BN 666</span>
                    </div>
                </div>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>
                            Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Selamat Datang di SISKAR BN666</h1>
            <p class="lead">
                Sistem Pencatatan Pelanggaran digital SMK Bakti Nusantara 666.<br>
                Mencatat poin <strong>Pelanggaran</strong> secara adil, transparan,<br class="d-none d-md-block">
                dan terintegrasi untuk membentuk karakter siswa yang disiplin.
            </p>

            <a href="{{ route('login') }}" class="btn btn-lg btn-hero-login">
            <i class="fa-solid fa-right-to-bracket me-2"></i>
                Masuk ke Sistem
            </a>
        </div>
    </header>

    <section class="content-section bg-white">
        <div class="container">
            <h2 class="section-title">Tentang Sistem Ini</h2>
            <div class="about-card">
                <h3 class="fw-bold mb-4">Sistem Pencatatan Pelanggaran Siswa</h3>
                <p class="text-muted mb-4">
                    SISKAR BN666 adalah sistem pencatatan pelanggaran siswa yang dirancang untuk menegakkan kedisiplinan dan tata tertib sekolah secara adil dan transparan.
                </p>
                <ul class="list-unstyled">
                    <li>
                        <i class="fa-solid fa-shield-halved text-danger me-2"></i>
                        <strong>Pencatatan Pelanggaran:</strong> Mencatat setiap pelanggaran tata tertib siswa dengan sistem poin yang jelas dan terukur.
                    </li>
                    <li>
                        <i class="fa-solid fa-gavel text-danger me-2"></i>
                        <strong>Penerapan Sanksi:</strong> Memberikan sanksi yang konsisten dan adil berdasarkan akumulasi poin pelanggaran.
                    </li>
                    <li>
                        <i class="fa-solid fa-chart-line text-danger me-2"></i>
                        <strong>Monitoring Real-time:</strong> Memantau perkembangan kedisiplinan siswa secara digital dan terintegrasi.
                    </li>
                </ul>
                <p class="text-muted mt-4">
                    Sistem ini memastikan bahwa setiap pelanggaran tercatat dengan baik dan sanksi diterapkan secara konsisten untuk membentuk karakter siswa yang disiplin dan bertanggung jawab.
                </p>
            </div>
        </div>
    </section>

    <section class="content-section">
        <div class="container">
            <h2 class="section-title">Tata Tertib & Peraturan Sekolah</h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <p class="text-center text-muted mb-5">
                        Peraturan ini diambil langsung dari database tata tertib sekolah.
                    </p>
                    <div class="accordion tata-tertib-accordion" id="accordionTataTertib">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPasal6">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePasal6" aria-expanded="true" aria-controls="collapsePasal6">
                                    <i class="fa-solid fa-list-check me-2 text-primary"></i>
                                    BAB III - Pasal 6: KEWAJIBAN
                                </button>
                            </h2>
                            <div id="collapsePasal6" class="accordion-collapse collapse show" aria-labelledby="headingPasal6">
                                <div class="accordion-body">
                                    <ul class="tata-tertib-list">
                                        @php $poin_counter = 0; @endphp
                                        @foreach($dataPasal6 as $item)
                                            @if($item->tipe == 'induk')
                                                <p class="fw-bold text-dark">{{ $item->konten_teks }}</p>
                                            
                                            @elseif($item->tipe == 'poin')
                                                @php $poin_counter++; @endphp
                                                <li class="poin">
                                                    <span class="poin-nomor">{{ $poin_counter }}.</span>
                                                    <span class="poin-teks">{{ $item->konten_teks }}</span>
                                                </li>
                                                @php $subpoin_counter = 'a'; @endphp
                                            
                                            @elseif($item->tipe == 'subpoin')
                                                <li class="subpoin">
                                                    <span class="subpoin-nomor">{{ $subpoin_counter++ }}.</span>
                                                    <span class="poin-teks">{{ $item->konten_teks }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPasal7">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePasal7" aria-expanded="false" aria-controls="collapsePasal7">
                                    <i class="fa-solid fa-ban me-2 text-danger"></i>
                                    BAB III - Pasal 7: LARANGAN
                                </button>
                            </h2>
                            <div id="collapsePasal7" class="accordion-collapse collapse" aria-labelledby="headingPasal7">
                                <div class="accordion-body">
                                    <ul class="tata-tertib-list">
                                        @php $poin_counter = 0; @endphp
                                        @foreach($dataPasal7 as $item)
                                            @if($item->tipe == 'induk')
                                                <p class="fw-bold text-dark">{{ $item->konten_teks }}</p>
                                            
                                            @elseif($item->tipe == 'poin')
                                                @php $poin_counter++; @endphp
                                                <li class="poin">
                                                    <span class="poin-nomor">{{ $poin_counter }}.</span>
                                                    <span class="poin-teks">{{ $item->konten_teks }}</span>
                                                </li>
                                                @php $subpoin_counter = 'a'; @endphp
                                            
                                            @elseif($item->tipe == 'subpoin')
                                                <li class="subpoin">
                                                    <span class="subpoin-nomor">{{ $subpoin_counter++ }}.</span>
                                                    <span class="poin-teks">{{ $item->konten_teks }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <div class="footer-logo">
                        <img src="{{ asset('logo1.png') }}" alt="Logo Footer" height="50">
                    </div>
                    <div class="footer-text">
                        <h5>SMK Bakti Nusantara 666</h5>
                        <p>Sistem Poin Karakter (SISKAR BN666)</p>
                    </div>
                </div>
                <div class="footer-right">
                    <p>© {{ date('Y') }} SMK Bakti Nusantara 666</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>