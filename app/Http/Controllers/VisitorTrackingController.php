<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Services\UserAgentSummary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VisitorTrackingController
{
    private const MAX_UA_LENGTH = 2000;

    private const MAX_URL_LENGTH = 2048;

    public function track(Request $request): Response
    {
        $origin = $request->headers->get('origin');
        $allowedOrigins = Config::array('visitor_tracking.allowed_cors_origins', [
            'https://cscorp.co.id',
            'https://www.cscorp.co.id',
        ]);

        // Header CORS khusus endpoint tracking agar kompatibel dengan `credentials: include`.
        // Dengan `credentials: include`, `Access-Control-Allow-Origin` tidak boleh `*`.
        $corsOk = is_string($origin) && in_array($origin, $allowedOrigins, true);

        $cookieName = Config::string('visitor_tracking.cookie_name');

        $visitorIdFromCookie = $request->cookie($cookieName);
        $hasValidCookie = is_string($visitorIdFromCookie) && Str::isUuid($visitorIdFromCookie);
        $visitorId = $hasValidCookie ? $visitorIdFromCookie : (string) Str::uuid();

        $url = (string) $request->query('url', '');
        if ($url === '') {
            // Fallback: simpan referer atau fullUrl endpoint (tidak ideal, tapi lebih baik daripada kosong).
            $url = $request->headers->get('referer') ?? $request->fullUrl();
        }

        $userAgent = $request->userAgent();
        $parsed = UserAgentSummary::summarize($userAgent);
        $referer = $request->headers->get('referer');

        $response = response()->noContent(204);

        // Cookie untuk unique visitor_id.
        $secure = Config::get('visitor_tracking.cookie_secure');
        if ($secure === null) {
            $secure = (bool) $request->secure();
        }

        $response->headers->setCookie(cookie(
            name: $cookieName,
            value: $visitorId,
            minutes: Config::integer('visitor_tracking.cookie_minutes'),
            path: '/',
            domain: null,
            secure: (bool) $secure,
            httpOnly: true,
            raw: false,
            sameSite: 'lax',
        ));

        // Hindari cache untuk endpoint ini.
        $response->headers->set('Cache-Control', 'no-store, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');

        if ($corsOk) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Vary', 'Origin');
        }

        // Hitung unik 1x per hari per IP (menghindari spam refresh/tab/navigasi).
        // Catatan: ini akan menggabungkan beberapa user di NAT/office menjadi 1 visitor per hari.
        $today = Carbon::today();
        $ip = $request->ip();
        if (! is_string($ip) || $ip === '') {
            return $response;
        }

        $alreadyCountedToday = Visitor::query()
            ->where('ip_address', $ip)
            ->where('visited_at', '>=', $today)
            ->exists();

        if (! $alreadyCountedToday) {
            // Insert langsung: efisien, tanpa model events.
            Visitor::query()->insert([
                'visitor_id' => $visitorId,
                'ip_address' => $ip,
                'user_agent' => $userAgent !== null ? Str::limit($userAgent, self::MAX_UA_LENGTH, '') : null,
                'browser' => $parsed['browser'],
                'device_type' => $parsed['device_type'],
                'url' => Str::limit($url, self::MAX_URL_LENGTH, ''),
                'method' => $request->method(),
                'referer' => $referer !== null ? Str::limit($referer, self::MAX_URL_LENGTH, '') : null,
                'visited_at' => now(),
            ]);
        }

        return $response;
    }
}

