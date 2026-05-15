<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-mail', function () {

    Mail::raw('Ini email test', function ($message) {
        $message->to('EMAILTUJUAN@gmail.com')
                ->subject('Test Email');
    });

    return 'Email sent!';
});

// Filament helper: accept month selection from admin UI
Route::post('/admin/visitor-month', [\App\Http\Controllers\VisitorAnalyticsController::class, 'setMonth'])
    ->name('filament.visitor_month.set');

Route::get('/admin/visitor-month/check', [\App\Http\Controllers\VisitorAnalyticsController::class, 'check'])
    ->name('filament.visitor_month.check');
