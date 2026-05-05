<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected Sheets $service;

    public function __construct()
    {
        $client = new Client;

        $client->setApplicationName('Laravel Contact Form');

        // ✅ DI SINI LETAKNYA
        $client->setAuthConfig(
            storage_path('app/google/service-account.json')
        );

        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
    }

    public function append(array $data): void
    {
        $spreadsheetId = env('GOOGLE_SHEET_ID');
        $range = env('GOOGLE_SHEET_RANGE', 'Sheet1!A:E');

        $values = [[
            now()->format('Y-m-d H:i:s'),
            $data['fullName'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['message'] ?? '',
        ]];

        $body = new Sheets\ValueRange([
            'values' => $values,
        ]);

        $params = [
            'valueInputOption' => 'RAW',
        ];

        $this->service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}
