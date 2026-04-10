<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Document</title>
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
        .card-hover { transition: all .25s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .status-pill {
            padding: 0.3rem 0.7rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        .status-success { background: rgba(34,197,94,0.15); color: #15803d; }
        .status-warning { background: rgba(234,179,8,0.18); color: #b45309; }
        .status-danger { background: rgba(239,68,68,0.15); color: #b91c1c; }
        .status-secondary { background: rgba(100,116,139,0.12); color: #475569; }
        .table thead th { border-bottom: 0; }
        .table tbody tr:hover { background: #f6f1ff; }
        .table th, .table td { padding: 0.6rem 0.75rem; font-size: 0.9rem; }
        .btn-soft { border-radius: 12px; }
        .search-input { border-radius: 12px; }
        .text-primary { color: #7c3aed !important; }
        .text-secondary { color: #5b4e8c !important; }

        .btn-primary {
            background-color: #7c3aed;
            border-color: #7c3aed;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #6d28d9;
            border-color: #6d28d9;
        }

        .btn-outline-primary {
            color: #7c3aed;
            border-color: #7c3aed;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:focus {
            background-color: #7c3aed;
            border-color: #7c3aed;
            color: #ffffff;
        }

        .btn-outline-secondary {
            color: #6b6b9a;
            border-color: #d4c6ff;
        }

        .btn-outline-secondary:hover,
        .btn-outline-secondary:focus {
            background-color: #ede9fe;
            border-color: #c4b5fd;
            color: #4c1d95;
        }

        .compact-topbar { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
        .compact-section { padding-top: 1.25rem !important; padding-bottom: 1.25rem !important; }
        .compact-cards .soft-card { padding: 0.85rem 1rem !important; }
        .compact-cards .h3 { font-size: 1.35rem; }
        .compact-cards .small { font-size: 0.8rem; }
        .compact-title { font-size: 1rem; }
        .compact-subtitle { font-size: 0.85rem; }
        .compact-actions .btn { padding: 0.35rem 0.65rem; font-size: 0.85rem; }
        .compact-search .form-control { padding-top: 0.35rem; padding-bottom: 0.35rem; font-size: 0.85rem; }
        .compact-search .form-select { padding-top: 0.35rem; padding-bottom: 0.35rem; font-size: 0.85rem; }
    </style>
</head>
<body>
@php
    $today = now()->startOfDay();
    $totalDocs = $allDocuments->count();
    $activeCount = 0;
    $expiringCount = 0;
    $expiredCount = 0;

    $documentLabelMap = [
        'SIM' => 'SIM',
        'STNK' => 'STNK',
        'PASPOR' => 'Paspor',
        'ASURANSI_KENDARAAN' => 'Asuransi Kendaraan',
        'KONTRAK_KERJA' => 'Kontrak Kerja',
        'KONTRAK_SEWA' => 'Kontrak Sewa',
        'GARANSI_PRODUK' => 'Garansi Produk',
    ];

    foreach ($allDocuments as $docItem) {
        if (! $docItem->tanggal_kadaluarsa) {
            continue;
        }

        $expiry = \Carbon\Carbon::parse($docItem->tanggal_kadaluarsa)->startOfDay();
        $daysLeft = $today->diffInDays($expiry, false);

        if ($daysLeft < 0) {
            $expiredCount++;
        } elseif ($daysLeft <= 60) {
            $expiringCount++;
        } else {
            $activeCount++;
        }
    }
@endphp

<div class="app-shell d-flex">
    <aside class="sidebar d-none d-lg-flex flex-column">
        <div class="p-4 border-bottom">
            <div class="sidebar-brand fs-4">DoCExpire</div>
        </div>
        <nav class="p-3 d-grid gap-2">
            <a class="nav-pill" href="{{ route('home') }}">Panduan Penggunaan</a>
            <a class="nav-pill active" href="{{ route('documents.index') }}">Dokumen</a>
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
        <div class="topbar compact-topbar px-4 px-lg-5 py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h1 class="h5 fw-semibold mb-1 compact-title">Dashboard Dokumen</h1>
                <p class="text-secondary small mb-0 compact-subtitle">Pantau dokumen dan masa berlaku di satu tempat.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 compact-actions compact-search">
                <form action="{{ route('documents.index') }}" method="GET" class="d-flex gap-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control search-input"
                        placeholder="Cari dokumen..."
                        value="{{ $search }}"
                    >
                    <input type="hidden" name="status" value="{{ $status }}">
                    <button type="submit" class="btn btn-outline-primary btn-soft">Cari</button>
                    @if ($search !== '' || $status !== '')
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-soft">Reset</a>
                    @endif
                </form>
                <a href="{{ route('documents.export') }}" class="btn btn-outline-primary btn-soft">Export Rekap PDF</a>
                <a href="{{ route('documents.create') }}" class="btn btn-primary btn-soft">+ Tambah Dokumen</a>
            </div>
        </div>

        <div class="p-4 px-lg-5 py-4 compact-section">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-3 mb-3 compact-cards">
                <div class="col-6 col-lg-3">
                    <div class="soft-card p-4 card-hover">
                        <p class="text-secondary small mb-1">Total Dokumen</p>
                        <p class="h3 fw-semibold mb-0">{{ $totalDocs }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="soft-card p-4 card-hover">
                        <p class="text-secondary small mb-1">Aktif</p>
                        <p class="h3 fw-semibold text-success mb-0">{{ $activeCount }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="soft-card p-4 card-hover">
                        <p class="text-secondary small mb-1">Akan Habis</p>
                        <p class="h3 fw-semibold text-warning mb-0">{{ $expiringCount }}</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="soft-card p-4 card-hover">
                        <p class="text-secondary small mb-1">Kadaluarsa</p>
                        <p class="h3 fw-semibold text-danger mb-0">{{ $expiredCount }}</p>
                    </div>
                </div>
            </div>

            <div class="soft-card p-3 card-hover">
                <div class="d-flex justify-content-between align-items-center mb-2 compact-search">
                    <h2 class="h6 fw-semibold mb-0 compact-title">Daftar Dokumen</h2>
                    <form action="{{ route('documents.index') }}" method="GET">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <select name="status" class="form-select form-select-sm" style="max-width: 160px;" onchange="this.form.submit()">
                            <option value="" @selected($status === '')>Semua</option>
                            <option value="active" @selected($status === 'active')>Aktif</option>
                            <option value="expiring" @selected($status === 'expiring')>Akan Habis</option>
                            <option value="expired" @selected($status === 'expired')>Kadaluarsa</option>
                        </select>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-secondary text-uppercase small">
                            <tr>
                                <th>Dokumen</th>
                                <th>Nomor</th>
                                <th>Kadaluarsa</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($documents as $doc)
                                @php
                                    $statusLabel = '-';
                                    $statusClass = 'secondary';
                                    $daysLeft = null;

                                    if ($doc->tanggal_kadaluarsa) {
                                        $expiry = \Carbon\Carbon::parse($doc->tanggal_kadaluarsa)->startOfDay();
                                        $daysLeft = $today->diffInDays($expiry, false);

                                        if ($daysLeft < 0) {
                                            $statusLabel = 'Kadaluarsa';
                                            $statusClass = 'danger';
                                        } elseif ($daysLeft <= 60) {
                                            $statusLabel = 'Akan Habis';
                                            $statusClass = 'warning';
                                        } else {
                                            $statusLabel = 'Aktif';
                                            $statusClass = 'success';
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $documentLabelMap[$doc->nama_dokumen] ?? str_replace('_', ' ', $doc->nama_dokumen) }}</td>
                                    <td>{{ $doc->nomor_dokumen ?: '-' }}</td>
                                    <td>{{ $doc->tanggal_kadaluarsa ?: '-' }}</td>
                                    <td>
                                        <span class="status-pill status-{{ $statusClass }}">{{ $statusLabel }}</span>
                                        @if (! is_null($daysLeft) && $daysLeft >= 0)
                                            <div class="small text-muted mt-1">Sisa {{ $daysLeft }} hari</div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('documents.show', $doc) }}" class="text-decoration-none text-primary me-3">Detail</a>
                                        <a href="{{ route('documents.edit', $doc) }}" class="text-decoration-none text-indigo me-3">Edit</a>
                                        <form
                                            action="{{ route('documents.destroy', $doc) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin mau hapus data ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        {{ $search !== '' ? 'Dokumen tidak ditemukan untuk pencarian tersebut.' : 'Belum ada dokumen.' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $documents->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
