<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Filament helper: accept month selection from admin UI
Route::post('/admin/visitor-month', [\App\Http\Controllers\VisitorAnalyticsController::class, 'setMonth'])
    ->name('filament.visitor_month.set');

Route::get('/admin/visitor-month/check', [\App\Http\Controllers\VisitorAnalyticsController::class, 'check'])
    ->name('filament.visitor_month.check');
