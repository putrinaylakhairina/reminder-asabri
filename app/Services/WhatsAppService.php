<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected string $token;
    protected string $endpoint = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token', env('FONNTE_TOKEN', ''));
    }

    public function sendMessage(string $target, string $message): array
    {
        if (empty($this->token)) {
            return [
                'status' => false,
                'reason' => 'Fonnte token is not set.',
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->post($this->endpoint, [
            'target' => $target,
            'message' => $message,
        ]);

        return $response->json();
    }
}
