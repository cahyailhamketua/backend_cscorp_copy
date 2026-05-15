<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SpamDetectionService
{
    public function isDuplicate(string $email, string $message): bool
    {
        $key = md5($email . $message);

        if (Cache::has($key)) {
            return true;
        }

        Cache::put($key, true, now()->addMinutes(2));

        return false;
    }
}