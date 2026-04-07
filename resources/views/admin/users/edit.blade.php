<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Edit User</title>
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
            <a class="nav-pill active" href="{{ route('admin.users.index') }}">Admin</a>
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
        <div class="topbar px-4 px-lg-5 py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h1 class="h5 fw-semibold mb-1">Edit User</h1>
                <p class="text-secondary small mb-0">Ubah nama user. Nomor WhatsApp tetap tersimpan.</p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-soft">Kembali</a>
            </div>
        </div>

        <div class="p-4 px-lg-5 py-4">
            <div class="soft-card p-4" style="max-width: 560px;">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $user->name) }}"
                            class="form-control @error('name') is-invalid @enderror"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nomor WhatsApp</label>
                        @php
                            $rawPhone = (string) $user->phone;
                            $left = substr($rawPhone, 0, 5);
                            $right = strlen($rawPhone) > 3 ? substr($rawPhone, -3) : '';
                            $masked = $rawPhone ? ($left . '****' . $right) : '-';
                        @endphp
                        <div class="form-control bg-light">{{ $masked }}</div>
                        <div class="form-text text-secondary">Nomor WhatsApp tidak diubah lewat halaman ini.</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-soft">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
