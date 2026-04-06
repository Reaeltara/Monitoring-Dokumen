<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Panduan Penggunaan</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f7f4ff; }
        .app-shell { min-height: 100vh; }
        .sidebar {
            width: 260px;
            min-width: 260px;
            flex: 0 0 260px;
            background: #ffffff;
            border-right: 1px solid #e9d5ff;
        }
        .sidebar-brand {
            font-weight: 700;
            color: #7c3aed;
        }
        .nav-pill {
            display: block;
            padding: 0.6rem 0.9rem;
            border-radius: 12px;
            color: #0f172a;
            text-decoration: none;
        }
        .nav-pill.active {
            background: #ede9fe;
            color: #7c3aed;
            font-weight: 600;
        }
        .nav-pill:hover { background: #f3e8ff; }
        .topbar { border-bottom: 1px solid #e9d5ff; background: #ffffff; }
        .soft-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 18px 40px rgba(76, 29, 149, 0.08);
        }
        .btn-soft { border-radius: 12px; }
        .text-primary { color: #7c3aed !important; }
        .text-secondary { color: #5b4e8c !important; }
    </style>
</head>
<body>
<div class="app-shell d-flex">
    <aside class="sidebar d-none d-lg-flex flex-column">
        <div class="p-4 border-bottom">
            <div class="sidebar-brand fs-4">DoCExpire</div>
        </div>
        <nav class="p-3 d-grid gap-2">
            <a class="nav-pill active" href="{{ route('home') }}">Panduan Penggunaan</a>
            <a class="nav-pill" href="{{ route('documents.index') }}">Dokumen</a>
            @if (auth()->user()?->is_admin)
                <a class="nav-pill" href="{{ route('admin.users.index') }}">Admin</a>
            @endif
        </nav>
        <div class="mt-auto p-3 border-top">
            <div class="small text-secondary mb-2">Login sebagai: <strong>{{ auth()->user()->name }}</strong></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-soft w-100">Logout</button>
            </form>
        </div>
    </aside>

    <main class="flex-fill">
        <div class="p-4 px-lg-5 py-4">
            <div class="soft-card p-4">
                <h1 class="h5 fw-semibold mb-2">Panduan Penggunaan DoCExpire</h1>
                <p class="text-secondary mb-0">
                    Ikuti langkah berikut agar dokumenmu selalu terpantau dan pengingat otomatis terkirim tepat waktu.
                </p>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-12 col-lg-6">
                    <div class="soft-card p-4 h-100">
                        <h2 class="h6 fw-semibold mb-3">Langkah 1: Lengkapi Profil</h2>
                        <ul class="text-secondary mb-0">
                            <li>Pastikan nomor WhatsApp kamu benar.</li>
                            <li>Gunakan format <strong>62xxxxxxxxxxx</strong> agar pengingat bisa terkirim.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="soft-card p-4 h-100">
                        <h2 class="h6 fw-semibold mb-3">Langkah 2: Tambah Dokumen</h2>
                        <ul class="text-secondary mb-0">
                            <li>Buka menu <strong>Dokumen</strong>.</li>
                            <li>Klik <strong>Tambah Dokumen</strong>, isi nama dokumen.</li>
                            <li>Set <strong>Tanggal Kadaluarsa</strong> dengan benar.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="soft-card p-4 h-100">
                        <h2 class="h6 fw-semibold mb-3">Langkah 3: Cek Jadwal Reminder</h2>
                        <ul class="text-secondary mb-0">
                            <li>Reminder akan dikirim pada H‑30, H‑7, H‑3, dan H‑1.</li>
                            <li>Isi tanggal kadaluarsa dengan benar supaya jadwalnya akurat.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="soft-card p-4 h-100">
                        <h2 class="h6 fw-semibold mb-3">Langkah 4: Kelola Dokumenmu</h2>
                        <ul class="text-secondary mb-0">
                            <li>Edit dokumen kapan saja jika ada perubahan tanggal.</li>
                            <li>Hapus dokumen yang sudah tidak berlaku.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="soft-card p-4 mt-4">
                <h2 class="h6 fw-semibold mb-2">Contoh Alur</h2>
                <p class="text-secondary mb-0">
                    Tambah dokumen → sistem hitung H‑30/H‑7/H‑3/H‑1 → reminder otomatis masuk ke WhatsApp kamu.
                </p>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
