<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoCExpire - Edit Dokumen</title>
    <link rel="icon" href="/asset/Logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f7f4ff; }

        .page-shell {
            background: radial-gradient(circle at top right, #f2eaff 0%, #ffffff 48%, #f6f1ff 100%);
            min-height: 100vh;
            padding: 3.5rem 0 4rem;
        }

        .form-card {
            background: #ffffff;
            border-radius: 22px;
            padding: 2rem 2.5rem;
            box-shadow: 0 20px 60px rgba(76, 29, 149, 0.12);
        }

        .form-label {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: 14px;
            padding: 0.7rem 1rem;
        }

        .btn-pill {
            border-radius: 999px;
            padding: 0.65rem 1.5rem;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
        }

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
<body>
<div class="page-shell">
    <div class="container">
        <div class="form-card">
            <div class="mb-4">
                <h1 class="section-title">Edit Dokumen</h1>
                <p class="text-secondary mb-0">Perbarui data agar informasi tetap akurat.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    $documentOptions = [
                        ['label' => 'SIM', 'value' => 'SIM', 'allow_issue_date' => false, 'require_issue_date' => false, 'require_number' => true],
                        ['label' => 'STNK', 'value' => 'STNK', 'allow_issue_date' => false, 'require_issue_date' => false, 'require_number' => true],
                        ['label' => 'Paspor', 'value' => 'PASPOR', 'allow_issue_date' => true, 'require_issue_date' => true, 'require_number' => true],
                        ['label' => 'Asuransi Kendaraan', 'value' => 'ASURANSI_KENDARAAN', 'allow_issue_date' => true, 'require_issue_date' => true, 'require_number' => true],
                        ['label' => 'Kontrak Kerja', 'value' => 'KONTRAK_KERJA', 'allow_issue_date' => true, 'require_issue_date' => false, 'require_number' => false],
                        ['label' => 'Kontrak Sewa', 'value' => 'KONTRAK_SEWA', 'allow_issue_date' => true, 'require_issue_date' => false, 'require_number' => false],
                        ['label' => 'Garansi Produk', 'value' => 'GARANSI_PRODUK', 'allow_issue_date' => true, 'require_issue_date' => false, 'require_number' => false],
                    ];
                    $selectedDocument = old('nama_dokumen', $document->nama_dokumen);
                    $manualDocumentName = old('nama_dokumen_manual');
                    $manualOptionValue = '__OTHER__';
                    $optionValues = array_map(fn ($option) => $option['value'], $documentOptions);
                    $hasCustomDocument = $selectedDocument && ! in_array($selectedDocument, $optionValues, true);
                @endphp

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Dokumen</label>
                        <select name="nama_dokumen" id="nama_dokumen" class="form-select">
                            <option value="">Pilih dokumen</option>
                            @foreach ($documentOptions as $option)
                                <option value="{{ $option['value'] }}"
                                    data-allow-issue-date="{{ $option['allow_issue_date'] ? '1' : '0' }}"
                                    data-require-issue-date="{{ $option['require_issue_date'] ? '1' : '0' }}"
                                    data-require-number="{{ $option['require_number'] ? '1' : '0' }}"
                                    @selected($selectedDocument === $option['value'])
                                >
                                    {{ $option['label'] }}
                                </option>
                            @endforeach
                            <option value="{{ $manualOptionValue }}"
                                data-allow-issue-date="1"
                                data-require-issue-date="0"
                                data-require-number="0"
                                @selected($selectedDocument === $manualOptionValue || $hasCustomDocument)
                            >
                                Dokumen lainnya (isi manual)
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 d-none" id="manual_dokumen_group">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen_manual" id="nama_dokumen_manual" class="form-control"
                        value="{{ $manualDocumentName ?: ($hasCustomDocument ? $selectedDocument : '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Dokumen</label>
                        <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control"
                        value="{{ old('nomor_dokumen', $document->nomor_dokumen) }}">
                        <div class="form-text" id="nomor_dokumen_help"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control"
                        value="{{ old('tanggal_terbit', $document->tanggal_terbit) }}">
                        <div class="form-text" id="tanggal_terbit_help"></div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kadaluarsa</label>
                        <input type="date" name="tanggal_kadaluarsa" class="form-control"
                        value="{{ old('tanggal_kadaluarsa', $document->tanggal_kadaluarsa) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Upload Dokumen PDF</label>
                        <input type="file" name="file_pdf" class="form-control" accept="application/pdf">
                        <div class="form-text">
                            {{ $document->pdf_name ? 'File saat ini: '.$document->pdf_name.'. Upload file baru untuk mengganti file lama.' : 'Belum ada file PDF. Format file harus PDF, maksimal 10 MB.' }}
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-pill">Update</button>
                    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-pill">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const docSelect = document.getElementById('nama_dokumen');
        const manualGroup = document.getElementById('manual_dokumen_group');
        const manualInput = document.getElementById('nama_dokumen_manual');
        const docNumberInput = document.getElementById('nomor_dokumen');
        const docNumberHelp = document.getElementById('nomor_dokumen_help');
        const issueDateInput = document.getElementById('tanggal_terbit');
        const issueDateHelp = document.getElementById('tanggal_terbit_help');
        const manualOptionValue = '{{ $manualOptionValue }}';

        const updateIssueDateState = () => {
            const selected = docSelect.options[docSelect.selectedIndex];
            const allowIssueDate = selected?.dataset?.allowIssueDate !== '0';
            const requireIssueDate = selected?.dataset?.requireIssueDate === '1';
            const requireNumber = selected?.dataset?.requireNumber === '1';
            const isManual = docSelect.value === manualOptionValue;

            if (isManual) {
                manualGroup.classList.remove('d-none');
                manualInput.required = true;
            } else {
                manualGroup.classList.add('d-none');
                manualInput.required = false;
                manualInput.value = '';
            }

            if (requireNumber) {
                docNumberInput.required = true;
                docNumberHelp.textContent = 'Nomor dokumen wajib diisi.';
            } else {
                docNumberInput.required = false;
                docNumberHelp.textContent = 'Nomor dokumen boleh dikosongkan.';
            }

            if (allowIssueDate) {
                issueDateInput.readOnly = false;
                issueDateInput.classList.remove('bg-light');
                issueDateInput.required = requireIssueDate;
                issueDateHelp.textContent = requireIssueDate
                    ? 'Tanggal terbit wajib diisi.'
                    : 'Tanggal terbit boleh dikosongkan.';
                return;
            }

            issueDateInput.value = '';
            issueDateInput.readOnly = true;
            issueDateInput.classList.add('bg-light');
            issueDateInput.required = false;
            issueDateHelp.textContent = 'Dokumen ini tidak memiliki tanggal terbit.';
        };

        docSelect.addEventListener('change', updateIssueDateState);
        updateIssueDateState();
    })();
</script>
</body>
</html>
