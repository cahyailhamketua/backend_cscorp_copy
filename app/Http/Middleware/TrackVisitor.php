<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use App\Services\UserAgentSummary;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mencatat page view setelah response dikirim (method terminate) agar tidak memblokir TTFB.
 *
 * Pendaftaran: bootstrap/app.php → withMiddleware() → web(append: [self::class])
 * (Laravel 11+ tidak lagi memakai app/Http/Kernel.php secara default.)
 */
class TrackVisitor
{
    /** Kunci atribut request untuk UUID yang dipakai di terminate() */
    public const REQUEST_ATTR_VISITOR_ID = '_visitor_tracking_id';

    private const MAX_UA_LENGTH = 2000;

    private const MAX_URL_LENGTH = 2048;

    private const DEFAULT_SCHEME = 'https';

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldNotTrack($request)) {
            return $next($request);
        }

        $cookieName = Config::string('visitor_tracking.cookie_name');

        // Baca UUID dari cookie; jika tidak valid, generate baru.
        // Catatan: jika cookie belum ada, beberapa CDN bisa mengembalikan 304 dari cache
        // tanpa menyentuh origin. Agar cookie tidak "terlewat", kita set cache-control
        // yang lebih ketat saat cookie belum ada.
        $visitorIdFromCookie = $request->cookie($cookieName);
        $hasValidCookie = is_string($visitorIdFromCookie) && Str::isUuid($visitorIdFromCookie);

        $visitorId = $hasValidCookie ? $visitorIdFromCookie : (string) Str::uuid();

        $request->attributes->set(self::REQUEST_ATTR_VISITOR_ID, $visitorId);

        $response = $next($request);

        // Pastikan response untuk halaman yang dilacak tidak memicu 304
        // lewat ETag/Last-Modified (agar cookie bisa ikut terset).
        // Kalau 304 masih terjadi dan middleware tidak dieksekusi,
        // maka berarti response berasal dari cache layer (Nginx/CDN) sebelum Laravel.
        $response->headers->remove('ETag');
        $response->headers->remove('Last-Modified');
        $response->headers->set('Vary', 'Cookie');

        // Untuk response HTML/document, nonaktifkan caching agresif.
        // (Jika Anda ingin lebih ringan, bisa ubah jadi hanya saat !hasValidCookie.)
        if (! $request->hasHeader('purpose') || $request->header('purpose') !== 'prefetch') {
            $response->headers->set('Cache-Control', 'private, no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
        }

        if (Config::get('visitor_tracking.debug', false)) {
            $response->headers->set('X-Visitor-Tracking', '1');
            $response->headers->set('X-Visitor-Tracking-Host', $this->resolveHostInfo($request)['host'] ?? '');
        }

        // Set cookie 30 hari bila belum ada atau berubah (contoh migrasi dari cookie lama)
        $current = $request->cookie($cookieName);
        if (! is_string($current) || $current !== $visitorId) {
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
        }

        return $response;
    }

    /**
     * Dipanggil setelah response terkirim ke klien: insert ringan satu baris.
     */
    public function terminate(Request $request, Response $response): void
    {
        if ($this->shouldNotTrack($request)) {
            return;
        }

        $visitorId = $request->attributes->get(self::REQUEST_ATTR_VISITOR_ID);
        if (! is_string($visitorId) || $visitorId === '') {
            return;
        }

        $ip = $request->ip();
        if (! is_string($ip) || $ip === '') {
            return;
        }

        $today = Carbon::today();
        $alreadyCountedToday = Visitor::query()
            ->where('ip_address', $ip)
            ->where('visited_at', '>=', $today)
            ->exists();

        if ($alreadyCountedToday) {
            return;
        }

        $userAgent = $request->userAgent();
        $parsed = UserAgentSummary::summarize($userAgent);
        $referer = $request->headers->get('referer');

        // insert() langsung ke query builder: cepat, tanpa event model
        $urlInfo = $this->resolveUrlInfo($request);

        Visitor::query()->insert([
            'visitor_id' => $visitorId,
            'ip_address' => $ip,
            'user_agent' => $userAgent !== null ? Str::limit($userAgent, self::MAX_UA_LENGTH, '') : null,
            'browser' => $parsed['browser'],
            'device_type' => $parsed['device_type'],
            'url' => Str::limit($urlInfo['url'], self::MAX_URL_LENGTH, ''),
            'method' => $request->method(),
            'referer' => $referer !== null ? Str::limit($referer, self::MAX_URL_LENGTH, '') : null,
            'visited_at' => now(),
        ]);
    }

    /**
     * Lewati admin, API, livewire, healthcheck, dan aset statis.
     */
    private function shouldNotTrack(Request $request): bool
    {
        $hostInfo = $this->resolveHostInfo($request);
        $host = $hostInfo['host'];

        $path = $request->path();

        foreach (Config::array('visitor_tracking.excluded_path_prefixes') as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix.'/')) {
                return true;
            }
        }

        $ext = strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
        if ($ext !== '' && in_array($ext, Config::array('visitor_tracking.excluded_extensions'), true)) {
            return true;
        }

        // Host allow/deny filter (opsional).
        // Default disabled agar tidak skip tracking akibat perbedaan Host header dari proxy.
        $enableHostFilter = (bool) Config::get('visitor_tracking.enable_host_filter', false);
        if ($enableHostFilter) {
            $includedHosts = Config::array('visitor_tracking.included_hosts');
            if (! empty($includedHosts) && $host !== null && ! in_array($host, $includedHosts, true)) {
                return true;
            }

            $excludedHosts = Config::array('visitor_tracking.excluded_hosts');
            if (! empty($excludedHosts) && $host !== null && in_array($host, $excludedHosts, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolusi host dari request (mengutamakan X-Forwarded-Host jika ada).
     *
     * @return array{host: string|null}
     */
    private function resolveHostInfo(Request $request): array
    {
        $useForwarded = (bool) Config::get('visitor_tracking.use_forwarded_headers', true);
        $forwardedHost = $useForwarded ? $request->header('x-forwarded-host') : null;

        $host = null;
        if (is_string($forwardedHost) && $forwardedHost !== '') {
            // Bisa berbentuk "host1, host2" - ambil yang pertama
            $host = trim(explode(',', $forwardedHost)[0]);
        } else {
            $host = $request->getHost();
        }

        if (! is_string($host) || $host === '') {
            return ['host' => null];
        }

        // Hilangkan port & samakan case
        $host = Str::lower((string) $host);
        $host = Str::before($host, ':');

        return ['host' => $host];
    }

    /**
     * Rekonstruksi URL berdasarkan forwarded host/proto supaya tidak salah domain saat behind proxy.
     *
     * @return array{url: string}
     */
    private function resolveUrlInfo(Request $request): array
    {
        $useForwarded = (bool) Config::get('visitor_tracking.use_forwarded_headers', true);

        $proto = self::DEFAULT_SCHEME;
        if ($useForwarded) {
            $forwardedProto = $request->header('x-forwarded-proto');
            if (is_string($forwardedProto) && $forwardedProto !== '') {
                $proto = strtolower(trim(explode(',', $forwardedProto)[0]));
            }
        }

        if (! $useForwarded) {
            $proto = $request->secure() ? 'https' : 'http';
        }

        $hostInfo = $this->resolveHostInfo($request);
        $host = $hostInfo['host'] ?? $request->getHost();

        // getRequestUri => path + query (tanpa host), tidak tergantung APP_URL
        $uri = $request->getRequestUri();

        return ['url' => "{$proto}://{$host}{$uri}"];
    }
}
