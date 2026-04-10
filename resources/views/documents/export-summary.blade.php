<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Dokumen - DoCExpire</title>
    <style>
        :root {
            color-scheme: light;
        }
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }
        .header {
            margin-bottom: 16px;
        }
        .title {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 4px;
        }
        .subtitle {
            color: #6b7280;
            margin: 0;
        }
        .summary {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0 20px;
        }
        .summary-cell {
            display: table-cell;
            padding: 10px 12px;
            border: 1px solid #e5e7eb;
            text-align: center;
        }
        .summary-label {
            color: #6b7280;
            margin-bottom: 4px;
        }
        .summary-value {
            font-size: 16px;
            font-weight: 700;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #f3f4f6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 999px;
            font-size: 10px;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-secondary { background: #e5e7eb; color: #374151; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">Laporan Rekap DoCExpire</p>
        <p class="subtitle">Tanggal cetak: {{ $generatedAt->format('d M Y H:i') }}</p>
    </div>

    <div class="summary">
        <div class="summary-cell">
            <div class="summary-label">Total Dokumen</div>
            <div class="summary-value">{{ $totalDocs }}</div>
        </div>
        <div class="summary-cell">
            <div class="summary-label">Aktif</div>
            <div class="summary-value">{{ $activeCount }}</div>
        </div>
        <div class="summary-cell">
            <div class="summary-label">Akan Habis</div>
            <div class="summary-value">{{ $expiringCount }}</div>
        </div>
        <div class="summary-cell">
            <div class="summary-label">Kadaluarsa</div>
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
                    $badgeClass = 'badge-secondary';
                    if ($doc->status_label === 'Aktif') {
                        $badgeClass = 'badge-success';
                    } elseif ($doc->status_label === 'Akan Habis') {
                        $badgeClass = 'badge-warning';
                    } elseif ($doc->status_label === 'Kadaluarsa') {
                        $badgeClass = 'badge-danger';
                    }
                @endphp
                <tr>
                    <td>{{ str_replace('_', ' ', $doc->nama_dokumen) }}</td>
                    <td>{{ $doc->nomor_dokumen ?: '-' }}</td>
                    <td>{{ $doc->tanggal_kadaluarsa ?: '-' }}</td>
                    <td><span class="badge {{ $badgeClass }}">{{ $doc->status_label }}</span></td>
                    <td>
                        @if (is_null($doc->days_left))
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
                    <td colspan="5">Belum ada dokumen.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
