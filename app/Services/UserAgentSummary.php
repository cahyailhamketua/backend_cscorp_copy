<?php

namespace App\Services;

/**
 * Parsing User-Agent sederhana tanpa paket tambahan (browser + tipe perangkat).
 */
final class UserAgentSummary
{
    /**
     * @return array{browser: string|null, device_type: string|null}
     */
    public static function summarize(?string $userAgent): array
    {
        if ($userAgent === null || $userAgent === '') {
            return ['browser' => null, 'device_type' => null];
        }

        $ua = strtolower($userAgent);

        return [
            'browser' => self::detectBrowser($ua),
            'device_type' => self::detectDevice($ua),
        ];
    }

    private static function detectBrowser(string $ua): ?string
    {
        // Urutan penting: Edge (Chromium) sebelum Chrome, Safari setelah Chrome tidak dipakai
        if (str_contains($ua, 'edg/') || str_contains($ua, 'edgios/') || str_contains($ua, 'edga/')) {
            return 'Edge';
        }
        if (str_contains($ua, 'opr/') || str_contains($ua, 'opera')) {
            return 'Opera';
        }
        if (str_contains($ua, 'firefox/')) {
            return 'Firefox';
        }
        if (str_contains($ua, 'chrome/') || str_contains($ua, 'crios/')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'safari/') && ! str_contains($ua, 'chrome')) {
            return 'Safari';
        }
        if (str_contains($ua, 'msie') || str_contains($ua, 'trident/')) {
            return 'Internet Explorer';
        }

        return null;
    }

    private static function detectDevice(string $ua): ?string
    {
        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablet';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'mobile';
        }

        return 'desktop';
    }
}
