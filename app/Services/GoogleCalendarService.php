<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;
use Exception;

class GoogleCalendarService
{
    protected Client $client;
    protected Calendar $calendar;
    protected string $tokenPath;

    public function __construct()
    {
        // Initialize Google Client
        $this->client = new Client();
        $this->client->setApplicationName(config('app.name') . ' - Calendar');
        $this->client->setAuthConfig(storage_path('app/google/credentials.json'));
        $this->client->setScopes([Calendar::CALENDAR]); // full access
        $this->client->setAccessType('offline'); // to get refresh token
        $this->client->setPrompt('consent');

        $this->tokenPath = storage_path('app/google/token.json');

        // Load saved token if exists
        if (file_exists($this->tokenPath)) {
            $accessToken = json_decode(file_get_contents($this->tokenPath), true);
            $this->client->setAccessToken($accessToken);

            if ($this->client->isAccessTokenExpired()) {
                if ($this->client->getRefreshToken()) {
                    $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                    file_put_contents($this->tokenPath, json_encode($this->client->getAccessToken()));
                } else {
                    throw new Exception('Access token expired. Re-authorize at /oauth2/authorize');
                }
            }
        }

        $this->calendar = new Calendar($this->client);
    }

    /**
     * Get the Google OAuth URL for one-time authorization
     */
    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    /**
     * Save the authorization code from Google
     */
    public function saveAuthCode(string $code): bool
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);

        if (isset($accessToken['error'])) {
            throw new Exception('Error fetching access token: ' . json_encode($accessToken));
        }

        file_put_contents($this->tokenPath, json_encode($accessToken));
        $this->client->setAccessToken($accessToken);

        return true;
    }

    /**
     * Create a Google Calendar event with Meet link
     *
     * @param string $summary Event title
     * @param string $startRfc3339 Start datetime in RFC3339 format
     * @param string $endRfc3339 End datetime in RFC3339 format
     * @param array $attendees Array of emails ['doctor@example.com','patient@example.com']
     * @return string|null Google Meet URL
     */
    public function createMeetEvent(string $summary, string $startRfc3339, string $endRfc3339, array $attendees = []): ?string
    {
        $attendeeObjects = array_map(fn($email) => ['email' => $email], $attendees);

        $event = new \Google\Service\Calendar\Event([
            'summary' => $summary,
            'start' => ['dateTime' => $startRfc3339, 'timeZone' => 'Asia/Kolkata'],
            'end' => ['dateTime' => $endRfc3339, 'timeZone' => 'Asia/Kolkata'],
            'attendees' => $attendeeObjects,
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid('meet_', true),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ],
        ]);

        $created = $this->calendar->events->insert('primary', $event, [
            'conferenceDataVersion' => 1
        ]);

        return $created->getHangoutLink() ?? null;
    }
}
