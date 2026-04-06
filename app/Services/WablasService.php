<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class WablasService
{
    public function sendText(string $phone, string $message, array $options = []): array
    {
        $request = $this->client();

        $payload = array_merge([
            'phone' => $phone,
            'message' => $message,
        ], $options);

        $response = $request
            ->asForm()
            ->post($this->baseUrl().'/api/send-message', $payload);

        return $response->json() ?? [];
    }

    private function client(): PendingRequest
    {
        $token = config('services.wablas.token');
        $secret = config('services.wablas.secret');

        if (! $token || ! $secret) {
            throw new RuntimeException('Wablas token/secret belum diisi di .env');
        }

        return Http::withHeaders([
            'Authorization' => $token.'.'.$secret,
        ])->acceptJson();
    }

    private function baseUrl(): string
    {
        $host = config('services.wablas.host') ?: 'https://wablas.com';

        return rtrim($host, '/');
    }
}
