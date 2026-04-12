<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Dashboard</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}?v={{ filemtime(public_path('css/dashboard.css')) }}" rel="stylesheet">
</head>
<body class="bg-light text-dark">
<nav class="navbar navbar-expand-lg bg-white bg-opacity-75 border-bottom sticky-top navbar-blur">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/dashboard') }}">
            <img src="{{ asset('asset/Logo.png') }}" alt="DoCExpire logo" width="40" height="40" class="object-fit-contain">
            <span class="fw-bold text-primary fs-4">DoCExpire</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                <li class="nav-item"><a class="nav-link" href="#documents">Dokumen</a></li>
                <li class="nav-item"><a class="nav-link" href="#how">Cara Kerja</a></li>
                <li class="nav-item">
                    <a href="{{ url('/login') }}" class="btn btn-primary px-4 rounded-pill">Masuk</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-bg grid-pattern hero-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <h1 class="display-5 fw-bold mb-4">
                    Pemantauan
                    <span class="text-primary">Masa Berlaku Dokumen</span>
                </h1>
                <p class="lead text-secondary mb-4">
                    Sistem web untuk mengelola dokumen dan memantau tanggal kadaluarsa agar catatan penting tetap terkontrol.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg px-4">Masuk ke Sistem</a>
                    <a href="#about" class="btn btn-outline-primary btn-lg px-4">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-lg-6 fade-up position-relative">
                <div class="glass rounded-4 shadow-lg p-4 float">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-semibold">Dashboard</span>
                        <span class="text-muted small">Pratinjau</span>
                    </div>
                    <div class="row g-2 mb-4 text-center">
                        <div class="col-4"><div class="bg-success bg-opacity-10 rounded-3 py-2 small">Aktif</div></div>
                        <div class="col-4"><div class="bg-warning bg-opacity-10 rounded-3 py-2 small">Akan Habis</div></div>
                        <div class="col-4"><div class="bg-danger bg-opacity-10 rounded-3 py-2 small">Kadaluarsa</div></div>
                    </div>
                    <div class="d-grid gap-2">
                        <div class="bg-secondary bg-opacity-10 rounded" style="height: 12px;"></div>
                        <div class="bg-secondary bg-opacity-10 rounded" style="height: 12px; width: 80%;"></div>
                        <div class="bg-secondary bg-opacity-10 rounded" style="height: 12px; width: 70%;"></div>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 translate-middle-y glass rounded-4 p-3 shadow float">
                    <p class="text-muted small mb-1">Pengingat</p>
                    <p class="fw-semibold mb-0">Dokumen akan habis masa berlaku</p>
                </div>
                <div class="position-absolute bottom-0 start-0 translate-middle-x glass rounded-4 p-3 shadow float">
                    <p class="text-muted small mb-1">Monitoring</p>
                    <p class="fw-semibold mb-0">Pelacakan otomatis</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <h2 class="fw-bold mb-4">Kenapa Monitoring Dokumen Itu Penting</h2>
                <p class="text-secondary mb-4">
                    Banyak dokumen resmi memiliki masa berlaku. Jika terlewat, bisa menimbulkan keterlambatan atau kendala administrasi. Sistem monitoring membantu menjaga catatan tetap rapi dan mudah dipantau.
                </p>
                <p class="text-secondary">
                    DoCExpire membantu memusatkan informasi dokumen dan memberi gambaran jelas soal masa berlaku.
                </p>
            </div>
            <div class="col-lg-6 fade-up">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 card-hover h-100">
                            <h3 class="h6 fw-semibold mb-2">Terpusat</h3>
                            <p class="text-secondary small mb-0">Simpan banyak dokumen dalam satu tempat yang rapi.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 card-hover h-100">
                            <h3 class="h6 fw-semibold mb-2">Mudah Dipantau</h3>
                            <p class="text-secondary small mb-0">Lihat tanggal habis masa berlaku dengan jelas.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 card-hover h-100">
                            <h3 class="h6 fw-semibold mb-2">Tertata</h3>
                            <p class="text-secondary small mb-0">Kategorikan dan kelola dokumen dengan efisien.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 card-hover h-100">
                            <h3 class="h6 fw-semibold mb-2">Siap Perpanjangan</h3>
                            <p class="text-secondary small mb-0">Siapkan perpanjangan sebelum tenggat.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="documents" class="section-padding bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-5 fade-up">Dokumen yang Didukung</h2>
        <div class="row g-4">
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">SIM</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">STNK</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">Paspor</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">Kontrak Kerja</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">Kontrak Sewa</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">Garansi Produk</div></div>
            <div class="col-6 col-md-3"><div class="bg-white p-4 rounded-4 shadow-sm text-center card-hover fade-up">Asuransi Kendaraan</div></div>
        </div>
    </div>
</section>

<section id="how" class="section-padding bg-white">
    <div class="container">
        <h2 class="fw-bold text-center mb-5 fade-up">Cara Kerja</h2>
        <div class="row text-center g-4">
            <div class="col-md-4 fade-up">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle fw-semibold mb-3" style="width: 56px; height: 56px;">1</div>
                <h3 class="h6 fw-semibold mb-2">Tambah Dokumen</h3>
                <p class="text-secondary">Masukkan detail dokumen dan tanggal kadaluarsa.</p>
            </div>
            <div class="col-md-4 fade-up">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle fw-semibold mb-3" style="width: 56px; height: 56px;">2</div>
                <h3 class="h6 fw-semibold mb-2">Monitoring Sistem</h3>
                <p class="text-secondary">Sistem memantau masa berlaku secara otomatis.</p>
            </div>
            <div class="col-md-4 fade-up">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle fw-semibold mb-3" style="width: 56px; height: 56px;">3</div>
                <h3 class="h6 fw-semibold mb-2">Terima Pengingat</h3>
                <p class="text-secondary">Pengguna mendapat notifikasi sebelum kadaluarsa.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-primary text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Mulai Pantau Dokumenmu</h2>
        <p class="mx-auto mb-4" style="max-width: 560px;">Atur dan pantau masa berlaku dokumen dalam satu tempat.</p>
        <a href="{{ url('/login') }}" class="btn btn-light btn-lg text-primary fw-semibold px-4">Masuk ke Sistem</a>
    </div>
</section>

<footer class="text-center py-4 text-secondary bg-light">DoCExpire @ 2026</footer>

<script>
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
