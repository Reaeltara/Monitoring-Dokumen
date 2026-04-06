<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = trim((string) $request->query('status', ''));
        $userId = $this->currentUserId();
        $today = now()->startOfDay();

        $baseQuery = Document::query()
            ->ownedBy($userId)
            ->search($search);

        $documentsQuery = (clone $baseQuery)->oldest();

        if ($status === 'active') {
            $documentsQuery->whereDate('tanggal_kadaluarsa', '>', $today->copy()->addDays(60));
        } elseif ($status === 'expiring') {
            $documentsQuery->whereDate('tanggal_kadaluarsa', '>=', $today)
                ->whereDate('tanggal_kadaluarsa', '<=', $today->copy()->addDays(60));
        } elseif ($status === 'expired') {
            $documentsQuery->whereDate('tanggal_kadaluarsa', '<', $today);
        }

        $documents = $documentsQuery->paginate(5)->withQueryString();
        $allDocuments = $baseQuery->get();

        return view('documents.index', compact('documents', 'allDocuments', 'search', 'status'));
    }

    public function create(): View
    {
        return view('documents.create');
    }

    public function show(int $id): View
    {
        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);

        return view('documents.show', compact('document'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateDocument($request);

        $document = Document::create(array_merge(
            $validated,
            ['user_id' => $this->currentUserId()]
        ));

        $this->storePdf($request, $document);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil ditambahkan');
    }

    public function edit(int $id): View
    {
        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);

        return view('documents.edit', compact('document'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $this->validateDocument($request);

        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);
        $document->update($validated);
        $this->storePdf($request, $document);

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil diperbarui');
    }

    public function preview(int $id): BinaryFileResponse
    {
        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');
        abort_unless($document->pdf_path && $disk->exists($document->pdf_path), 404);

        return response()->file(
            $disk->path($document->pdf_path),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$document->pdf_name.'"',
            ]
        );
    }

    public function download(int $id): StreamedResponse
    {
        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');
        abort_unless($document->pdf_path && $disk->exists($document->pdf_path), 404);

        return $disk->download(
            $document->pdf_path,
            $document->pdf_name ?? basename($document->pdf_path)
        );
    }

    public function destroy(int $id): RedirectResponse
    {
        $document = Document::ownedBy($this->currentUserId())->findOrFail($id);

        if ($document->pdf_path && Storage::disk('local')->exists($document->pdf_path)) {
            Storage::disk('local')->delete($document->pdf_path);
        }

        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus');
    }

    private function validateDocument(Request $request): array
    {
        $validated = $request->validate([
            'nama_dokumen' => 'required',
            'nomor_dokumen' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        unset($validated['file_pdf']);

        return $validated;
    }

    private function storePdf(Request $request, Document $document): void
    {
        if (! $request->hasFile('file_pdf')) {
            return;
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('local');

        if ($document->pdf_path && $disk->exists($document->pdf_path)) {
            $disk->delete($document->pdf_path);
        }

        $file = $request->file('file_pdf');
        $path = $file->store('documents', 'local');

        $document->update([
            'pdf_path' => $path,
            'pdf_name' => $file->getClientOriginalName(),
        ]);
    }

    private function currentUserId(): int
    {
        $userId = Auth::id();

        abort_unless($userId !== null, 403);

        return (int) $userId;
    }
}
