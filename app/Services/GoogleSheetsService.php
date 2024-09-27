<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets API Integration');
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));

        $this->client->setAccessType('offline');
        
        if (file_exists(storage_path('token.json'))) {
            $accessToken = json_decode(file_get_contents(storage_path('token.json')), true);
            $this->client->setAccessToken($accessToken);
        }

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                file_put_contents(storage_path('token.json'), json_encode($this->client->getAccessToken()));
            }
        }

        $this->service = new Google_Service_Sheets($this->client);
    }

    public function updateSheet($spreadsheetId, $range, $values)
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        
        $params = [
            'valueInputOption' => 'RAW'
        ];

        $this->service->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}