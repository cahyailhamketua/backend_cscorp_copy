<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ToxicDetectionService
{
    public function check(string $message): array
    {
        $response = Http::post(
            'http://127.0.0.1:5000/check-toxic',
            [
                'message' => $message
            ]
        );

        return $response->json();
    }
}