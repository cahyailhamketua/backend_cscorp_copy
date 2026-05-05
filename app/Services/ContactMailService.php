<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class ContactMailService
{
    public function send(string $to, array $data): void
    {
        Mail::raw(
            "New Contact Message\n\n".
            "Name: {$data['fullName']}\n".
            "Email: {$data['email']}\n".
            "Phone: {$data['phone']}\n\n".
            "Message:\n{$data['message']}",
            function ($mail) use ($to) {
                $mail->to($to)
                    ->subject('New Contact Message');
            }
        );
    }
}
