<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = \App\Models\Contact::all();

        return response()->json($contacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    public function sendMessage(
        Request $request,
        \App\Services\GoogleSheetService $sheet,
        \App\Services\ContactMailService $mail
    ) {
        // 1) Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // 2) Siapkan data email
        $emailData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'content' => $request->message,
        ];

        // 3) Ambil email tujuan dari contact_settings atau fallback dari .env
        $receiver = ContactSetting::first()?->email_receiver
            ?? env('MAIL_FROM_ADDRESS', 'default@company.com');

        try {
            // Kirim email (gunakan view emails.contact)
            Mail::send('emails.contact', $emailData, function ($mailMessage) use ($emailData, $receiver) {
                $mailMessage->to($receiver)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->replyTo($emailData['email'], $emailData['name'])
                    ->subject('Pesan Baru dari Website CS Corp');
            });

            // 4) Simpan ke Google Sheet (jika dikonfigurasi)
            if (env('GOOGLE_SHEET_ID')) {
                try {
                    $sheet->append([
                        'fullName' => $emailData['name'],
                        'email' => $emailData['email'],
                        'phone' => $emailData['phone'],
                        'message' => $emailData['content'],
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Google Sheet append failed: '.$e->getMessage());
                }
            }

            // 5) Response sukses
            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim.',
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Send message failed: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan. Silakan coba lagi.',
            ], 500);
        }
    }
}
