<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Rincian Dokumen</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f7f4ff; }

        .page-shell {
            background: linear-gradient(180deg, #f2eaff 0%, #ffffff 48%, #f6f1ff 100%);
            min-height: 100vh;
            padding: 3.5rem 0 4rem;
        }

        .detail-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 2rem 2.5rem;
            box-shadow: 0 20px 60px rgba(76, 29, 149, 0.12);
        }

        .status-pill {
            padding: 0.35rem 0.7rem;
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

        .header-actions {
            gap: 0.35rem;
            margin-top: 6px;
        }

        .header-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            min-width: 96px;
            padding: 0 16px;
            font-size: 0.88rem;
            line-height: 1;
            border-radius: 10px;
        }

        .meta-block dt { color: #6b6b9a; font-weight: 600; }

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
    </style>
</head>
<body>
<div class="page-shell">
    <div class="container">
        <div class="detail-card">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <div>
                    <h1 class="fw-bold mb-1">Rincian Dokumen</h1>
                    <p class="text-secondary mb-0">Lihat informasi dan status terkini dokumen.</p>
                </div>
                <div class="d-flex gap-2 header-actions">
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
                    <a href="{{ route('documents.edit', $document) }}" class="btn btn-primary btn-sm">Edit</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    @if ($document->pdf_name)
                        <div class="ratio ratio-4x3 border rounded-4 overflow-hidden">
                            <iframe src="{{ route('documents.preview', $document) }}" title="Preview Dokumen"></iframe>
                        </div>
                    @else
                        <div class="border rounded-4 p-4 text-muted text-center">
                            Belum ada file PDF untuk dipreview.
                        </div>
                    @endif
                </div>

                <div class="col-lg-5">
                    @php
                        $statusLabel = '-';
                        $statusClass = 'secondary';
                        $daysLeft = null;

                        if ($document->tanggal_kadaluarsa) {
                            $today = now()->startOfDay();
                            $expiry = \Carbon\Carbon::parse($document->tanggal_kadaluarsa)->startOfDay();
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

                    @php
                        $documentLabelMap = [
                            'SIM' => 'SIM',
                            'STNK' => 'STNK',
                            'PASPOR' => 'Paspor',
                            'ASURANSI_KENDARAAN' => 'Asuransi Kendaraan',
                            'KONTRAK_KERJA' => 'Kontrak Kerja',
                            'KONTRAK_SEWA' => 'Kontrak Sewa',
                            'GARANSI_PRODUK' => 'Garansi Produk',
                        ];
                    @endphp

                    <dl class="row mb-4 meta-block">
                        <dt class="col-sm-5">Nama Dokumen</dt>
                        <dd class="col-sm-7">{{ $documentLabelMap[$document->nama_dokumen] ?? str_replace('_', ' ', $document->nama_dokumen) }}</dd>

                        <dt class="col-sm-5">Nomor Dokumen</dt>
                        <dd class="col-sm-7">{{ $document->nomor_dokumen ?: '-' }}</dd>

                        <dt class="col-sm-5">Tanggal Terbit</dt>
                        <dd class="col-sm-7">{{ $document->tanggal_terbit ?: '-' }}</dd>

                        <dt class="col-sm-5">Tanggal Kadaluarsa</dt>
                        <dd class="col-sm-7">{{ $document->tanggal_kadaluarsa ?: '-' }}</dd>

                        <dt class="col-sm-5">Status</dt>
                        <dd class="col-sm-7">
                            <span class="status-pill status-{{ $statusClass }}">{{ $statusLabel }}</span>
                            @if (! is_null($daysLeft) && $daysLeft >= 0)
                                <div class="small text-muted mt-1">Sisa {{ $daysLeft }} hari</div>
                            @endif
                        </dd>

                        <dt class="col-sm-5">File Dokumen</dt>
                        <dd class="col-sm-7">{{ $document->pdf_name ?: 'Belum ada file PDF' }}</dd>
                    </dl>

                    @if ($document->pdf_name)
                        <a href="{{ route('documents.download', $document) }}" class="btn btn-outline-primary btn-pill">
                            Download PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
