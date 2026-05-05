<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VisitorAnalyticsController
{
    /**
     * Set the visitor_month in session (format YYYY-MM) or clear it.
     */
    public function setMonth(Request $request)
    {
        $value = $request->input('visitor_month');
        if ($value === null || trim($value) === '') {
            $request->session()->forget('visitor_month');
        } else {
            // basic validation: YYYY-MM
            if (preg_match('/^\d{4}-\d{2}$/', $value)) {
                $request->session()->put('visitor_month', $value);
            }
        }

        // Debug log so we can inspect server-side behaviour.
        Log::info('VisitorAnalyticsController::setMonth', [
            'input' => $value,
            'session' => $request->session()->get('visitor_month'),
            'is_ajax' => $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest',
        ]);

        // Prepare response: set a persistent cookie `visitor_month` so widgets can read it reliably.
        $minutes = 60 * 24 * 365; // 1 year
        if ($value === null || trim($value) === '') {
            $cookie = cookie('visitor_month', '', -2628000); // expire in past to delete
        } else {
            $cookie = cookie('visitor_month', $value, $minutes, '/', null, true, false, false, 'Lax');
        }

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'visitor_month' => $request->session()->get('visitor_month') ?? null,
            ])->cookie($cookie);
        }

        return redirect()->back()->cookie($cookie);
    }

    /**
     * Diagnostic endpoint: return current session visitor_month value.
     */
    public function check(Request $request)
    {
        return response()->json([
            'visitor_month' => $request->session()->get('visitor_month') ?? null,
        ]);
    }
}
