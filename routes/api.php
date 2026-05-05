<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProductionController;
use App\Http\Controllers\Api\SosmedController;
use App\Http\Controllers\Api\StructuralController;
use App\Http\Controllers\Api\VisionController;
use App\Http\Controllers\VisitorTrackingController;
use Illuminate\Support\Facades\Route;

// clients API
Route::get('/clients', [ClientController::class, 'index']);

// contacts API
Route::get('/contacs', [ContactController::class, 'index']);

Route::post('/send-message', [ContactController::class, 'sendMessage']);

// locations API
Route::get('/locations', [LocationController::class, 'index']);

// sosmed API
Route::get('/sosmeds', [SosmedController::class, 'index']);

// visions API
Route::get('/visions', [VisionController::class, 'index']);

// events API
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);

// productions API
Route::get('/productions', [ProductionController::class, 'index']);
Route::get('/productions/{id}', [ProductionController::class, 'show']);

// structurals API
Route::get('/structurals', [StructuralController::class, 'index']);
Route::get('/structurals/{id}', [StructuralController::class, 'show']);

// Endpoint tracking khusus untuk kasus homepage mengalami cache/304.
// Dipanggil dari halaman utama dengan query `url`.
Route::get('/__visitor/track', [VisitorTrackingController::class, 'track'])
    ->name('visitor.track');

// Jawab preflight agar `fetch(..., { credentials: 'include' })` tidak ditolak CORS.
Route::options('/__visitor/track', function (\Illuminate\Http\Request $request) {
    $origin = $request->headers->get('origin');
    $allowedOrigins = config('visitor_tracking.allowed_cors_origins', [
        'https://cscorp.co.id',
        'https://www.cscorp.co.id',
    ]);

    $corsOk = is_string($origin) && in_array($origin, $allowedOrigins, true);

    $response = response()->noContent(204);

    if ($corsOk) {
        $response->headers->set('Access-Control-Allow-Origin', $origin);
        $response->headers->set('Access-Control-Allow-Credentials', 'true');
        $response->headers->set('Vary', 'Origin');
    }

    // Untuk preflight
    $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
    $requestedHeaders = $request->headers->get('access-control-request-headers');
    if (is_string($requestedHeaders) && $requestedHeaders !== '') {
        $response->headers->set('Access-Control-Allow-Headers', $requestedHeaders);
    }

    $response->headers->set('Access-Control-Max-Age', '86400');

    return $response;
});
