<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Admin Users</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f7f4ff; }
        .app-shell { min-height: 100vh; }
        .sidebar {
            width: 260px;
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
                <h1 class="h5 fw-semibold mb-1">Data User</h1>
                <p class="text-secondary small mb-0">Lihat nama dan nomor WhatsApp pengguna.</p>
            </div>
        </div>

        <div class="p-4 px-lg-5 py-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="soft-card p-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="text-secondary text-uppercase small">
                            <tr>
                                <th>Nama</th>
                                <th>Nomor WhatsApp</th>
                                <th>Terdaftar</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                    <td>
                                        @if (! $user->phone)
                                            -
                                        @else
                                            @php
                                                $rawPhone = (string) $user->phone;
                                                $left = substr($rawPhone, 0, 5);
                                                $right = strlen($rawPhone) > 3 ? substr($rawPhone, -3) : '';
                                                $masked = $left . '****' . $right;
                                            @endphp
                                            {{ $masked }}
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-decoration-none text-primary me-3">Edit</a>
                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin mau hapus user ini? Semua dokumen user akan ikut terhapus.')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-danger text-decoration-none">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
