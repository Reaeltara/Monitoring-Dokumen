<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Dokumen - DoCExpire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        * { color: #1f2937 !important; }
        body { 
            font-family: Poppins, -apple-system, sans-serif; 
            background: #ede9fe; 
            line-height: 1.6;
        }
        /* Gradient topbar sama persis kayak index */
        .topbar {
            background: linear-gradient(90deg, #6b2bff 0%, #4c1d95 100%) !important;
            color: #ffffff !important;
            padding: 1rem 1.5rem !important;
            box-shadow: 0 2px 10px rgba(107,43,255,0.25);
        }
        .btn-soft { 
            color: #ffffff !important; 
            border-color: rgba(255,255,255,0.5) !important; 
            background: transparent !important;
            border-radius: 999px !important;
            padding: 0.5rem 1.25rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            transition: all 0.2s !important;
        }
        .btn-soft:hover { 
            background: rgba(255,255,255,0.15) !important; 
            border-color: rgba(255,255,255,0.8) !important;
        }
        .main-content { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
        .card { 
            background: #ffffff; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(99,102,241,0.12); 
            border: none;
        }
        .pdf-content { 
            font-family: "DejaVu Sans", Arial, sans-serif; 
            color: #1f2937 !important;
        }
        .pdf-content * { color: #1f2937 !important; }
        .title { font-size: 22px; font-weight: 700; color: #1f2937 !important; margin-bottom: 1rem; }
        .subtitle { color: #6b7280 !important; font-size: 14px; margin-bottom: 2rem; }
        /* Summary HORIZONTAL 4 kolom */
        .summary {
            display: flex !important;
            width: 100% !important; 
            border-collapse: collapse !important;
            margin: 2rem 0 !important; 
            gap: 0 !important;
        }
        .summary-cell { 
            flex: 1 !important;
            padding: 1.5rem 1rem !important; 
            border: 2px solid #e5e7eb !important; 
            text-align: center !important; 
            background: #f8fafc !important;
        }
        .summary-value { font-size: 20px; font-weight: 700; color: #1f2937 !important; }
        table { font-size: 13px; border-collapse: collapse; width: 100%; margin-top: 2rem; }
        th, td { 
            border: 1px solid #e5e7eb; 
            padding: 1rem 0.875rem; 
            color: #1f2937 !important;
        }
        th { 
            background: linear-gradient(135deg, #f8fafc, #f1f5f9); 
            font-weight: 700; 
            color: #374151 !important;
            font-size: 12px;
        }
        .badge { 
            padding: 0.4rem 0.875rem; 
            border-radius: 20px; 
            font-weight: 700; 
            font-size: 11px;
        }
        .badge-success { background: #d1fae5 !important; color: #065f46 !important; }
        .badge-warning { background: #fef3c7 !important; color: #92400e !important; }
        .badge-danger { background: #fee2e2 !important; color: #991b1b !important; }
        .days-left { font-weight: 600; }
        .days-positive { color: #059669 !important; }
        .days-negative { color: #dc2626 !important; }
        @media print {
            .topbar, .no-print { display: none !important; }
            body { background: white !important; }
            .summary { display: table !important; }
            th { background: #f8fafc !important; -webkit-print-color-adjust: exact !important; }
        }
        @media (max-width: 992px) {
            .summary {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        @media (max-width: 576px) {
            .summary {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>
<body>
    <!-- Topbar - Gradient persis index -->
    <div class="topbar no-print">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('documents.index') }}" class="btn btn-soft">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-soft">
                <i class="bi bi-printer"></i> Cetak
            </button>
        </div>
    </div>

    <div class="main-content">
        <div class="card p-4 p-lg-5">
            <div class="pdf-content">
                <div class="text-center mb-4">
                    <h1 class="title">Laporan Rekap DoCExpire</h1>
                    <p class="subtitle">Tanggal cetak: {{ $generatedAt->format('d M Y H:i') }}</p>
                </div>

                <!-- Summary HORIZONTAL -->
                <div class="summary">
                    <div class="summary-cell">
                        <div>Total Dokumen</div>
                        <div class="summary-value">{{ $totalDocs }}</div>
                    </div>
                    <div class="summary-cell">
                        <div>Aktif</div>
                        <div class="summary-value">{{ $activeCount }}</div>
                    </div>
                    <div class="summary-cell">
                        <div>Akan Habis</div>
                        <div class="summary-value">{{ $expiringCount }}</div>
                    </div>
                    <div class="summary-cell">
                        <div>Kadaluarsa</div>
                        <div class="summary-value">{{ $expiredCount }}</div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th>Nomor</th>
                            <th>Kadaluarsa</th>
                            <th>Status</th>
                            <th>Sisa Hari</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            @php
                                $badgeClass = $doc->status_label === 'Aktif' ? 'badge-success' : 
                                            ($doc->status_label === 'Akan Habis' ? 'badge-warning' : 
                                            ($doc->status_label === 'Kadaluarsa' ? 'badge-danger' : ''));
                            @endphp
                            <tr>
                                <td><strong>{{ str_replace('_', ' ', $doc->nama_dokumen) }}</strong></td>
                                <td>{{ $doc->nomor_dokumen ?: '-' }}</td>
                                <td>{{ $doc->tanggal_kadaluarsa ?: '-' }}</td>
                                <td>
                                    @if($badgeClass)
                                        <span class="badge {{ $badgeClass }}">{{ $doc->status_label }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="days-left {{ $doc->days_left < 0 ? 'days-negative' : 'days-positive' }}">
                                    @if(is_null($doc->days_left))
                                        -
                                    @elseif ($doc->days_left < 0)
                                        {{ abs($doc->days_left) }} hari lewat
                                    @else
                                        {{ $doc->days_left }} hari
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4" style="color: #6b7280; font-style: italic;">
                                    Belum ada dokumen
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

