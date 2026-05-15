<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetService
{
    protected ?Sheets $service = null;
    protected bool $isConfigured = false;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/google/service-account.json');

        // Only initialize if service account file exists and Google Sheet ID is configured
        if (file_exists($serviceAccountPath) && env('GOOGLE_SHEET_ID')) {
            try {
                $client = new Client;
                $client->setApplicationName('Laravel Contact Form');
                $client->setAuthConfig($serviceAccountPath);
                $client->setScopes([Sheets::SPREADSHEETS]);
                $client->setAccessType('offline');

                $this->service = new Sheets($client);
                $this->isConfigured = true;
            } catch (\Exception $e) {
                \Log::warning('GoogleSheetService initialization failed: ' . $e->getMessage());
            }
        }
    }

    public function append(array $data): void
    {
        // Skip if Google Sheet service is not configured
        if (!$this->isConfigured || !$this->service) {
            \Log::warning('GoogleSheetService is not configured. Skipping append.');
            return;
        }

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
