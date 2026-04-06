<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Masuk</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f7f4ff; }

        .hero-bg {
            background: linear-gradient(120deg, #f2eaff, #ffffff, #f6f1ff, #ede9fe);
            background-size: 300% 300%;
            animation: gradientMove 14s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(124, 58, 237, 0.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(124, 58, 237, 0.08) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

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
    </style>
</head>
<body class="hero-bg grid-pattern min-vh-100">
<div class="min-vh-100 d-flex align-items-center justify-content-center px-4 py-5">
    <div class="glass w-100" style="max-width: 420px; border-radius: 24px; box-shadow: 0 20px 60px rgba(0,0,0,.08); padding: 2rem;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <img src="{{ asset('asset/Logo.png') }}" alt="DoCExpire logo" width="40" height="40" class="object-fit-contain">
            <div>
                <h1 class="h4 fw-bold text-primary mb-1">DoCExpire</h1>
                <p class="text-secondary small mb-0">Masuk ke akunmu</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success small">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}" class="d-grid gap-3">
            @csrf
            <div>
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="form-control form-control-lg">
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" required
                       class="form-control form-control-lg">
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Masuk</button>
        </form>

        <div class="d-grid gap-2 mt-3">
            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary btn-lg">Kembali</a>
        </div>

        <p class="mt-4 text-secondary small">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary fw-semibold">Daftar sekarang</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
