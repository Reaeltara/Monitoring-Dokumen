<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Document;
use App\Services\WablasService;
use Carbon\CarbonImmutable;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('documents:send-reminders', function () {
    $offsets = [30, 7, 3, 1];
    $today = CarbonImmutable::now()->startOfDay();
    $maxDay = $today->addDays(max($offsets));

    $documents = Document::query()
        ->with('user')
        ->whereNotNull('tanggal_kadaluarsa')
        ->whereDate('tanggal_kadaluarsa', '>=', $today)
        ->whereDate('tanggal_kadaluarsa', '<=', $maxDay)
        ->get();

    /** @var WablasService $wablas */
    $wablas = app(WablasService::class);

    $sentCount = 0;
    $skippedCount = 0;
    $failedCount = 0;

    foreach ($documents as $document) {
        $expiry = CarbonImmutable::parse($document->tanggal_kadaluarsa)->startOfDay();
        $daysLeft = (int) $today->diffInDays($expiry, false);

        if (! in_array($daysLeft, $offsets, true)) {
            continue;
        }

        $user = $document->user;
        $phone = $user?->phone ? preg_replace('/\D+/', '', $user->phone) : null;

        if (! $user || ! $phone) {
            $skippedCount++;
            continue;
        }

        if (Str::startsWith($phone, '0')) {
            $phone = '62'.ltrim($phone, '0');
        }

        $isTestMode = (bool) config('services.reminder.test');
        $alreadySent = DB::table('document_reminder_logs')
            ->where('document_id', $document->id)
            ->where('offset_days', $daysLeft)
            ->whereDate('sent_date', $today)
            ->exists();

        if ($alreadySent && ! $isTestMode) {
            $skippedCount++;
            continue;
        }

        $message = sprintf(
            'Pengingat: Dokumen %s akan kadaluarsa pada %s, tersisa %d Hari lagi dari mulai hari ini.',
            str_replace('_', ' ', $document->nama_dokumen),
            $expiry->format('d M Y'),
            $daysLeft
        );

        try {
            $response = $wablas->sendText($phone, $message, ['flag' => 'instant']);

            DB::table('document_reminder_logs')->insert([
                'document_id' => $document->id,
                'user_id' => $user->id,
                'offset_days' => $daysLeft,
                'sent_date' => $today->toDateString(),
                'status' => 'sent',
                'response' => json_encode($response),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sentCount++;
        } catch (\Throwable $e) {
            DB::table('document_reminder_logs')->insert([
                'document_id' => $document->id,
                'user_id' => $user->id,
                'offset_days' => $daysLeft,
                'sent_date' => $today->toDateString(),
                'status' => 'failed',
                'response' => json_encode(['error' => $e->getMessage()]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $failedCount++;
        }
    }

    $this->info("Reminder selesai. Sent: {$sentCount}, Skipped: {$skippedCount}, Failed: {$failedCount}");
})->purpose('Kirim reminder dokumen yang hampir kadaluarsa');
