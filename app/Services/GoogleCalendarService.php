<?php

declare(strict_types=1);

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class GoogleCalendarService
{
    protected Google_Client $client;
    protected Google_Service_Calendar $calendarService;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Your Application Name');
        $this->client->setAuthConfig(storage_path('app/google/client_secret_773288139697-du55jbqhcn7dc3oe6gs0a5mukrcfkmps.apps.googleusercontent.com.json'));
        $this->client->addScope(Google_Service_Calendar::CALENDAR);

        $this->checkTokenExpiration();

        $this->calendarService = new Google_Service_Calendar($this->client);
    }

    private function checkTokenExpiration(): Void
    {
        $accessToken = session('google_access_token');
        $refreshToken = session('google_refresh_token');

        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $newToken = $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
            session(['google_access_token' => $newToken]);
            session(['google_refresh_token' => $this->client->getRefreshToken()]);
        }

    }

    public function createEvent($eventData): Google_Service_Calendar_Event
    {
        $startTime = new \DateTime($eventData['start_time']);
        $endTime = new \DateTime($eventData['end_time']);

        $event = new Google_Service_Calendar_Event([
            'summary' => $eventData['title'],
            'description' => $eventData['description'],
            'start' => [
                'dateTime' => $startTime->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Asia/Yerevan',
            ],
            'end' => [
                'dateTime' => $endTime->format('Y-m-d\TH:i:s'),
                'timeZone' => 'Asia/Yerevan',
            ],
        ]);

        $eventCreated = $this->calendarService->events->insert('primary', $event);

        return $eventCreated;
    }

    public function updateEvent($eventId, $eventData): Google_Service_Calendar_Event
    {
        $event = $this->calendarService->events->get('primary', $eventId);

        $updatedStartTime = new \DateTime($eventData['start_time']);
        $updatedEndTime = new \DateTime($eventData['end_time']);

        $event->setSummary($eventData['title']);
        $event->setDescription($eventData['description']);

        $event->setStart(new \Google_Service_Calendar_EventDateTime([
            'dateTime' => $updatedStartTime->format('Y-m-d\TH:i:s'),
            'timeZone' => 'Asia/Yerevan',
        ]));
        $event->setEnd(new \Google_Service_Calendar_EventDateTime([
            'dateTime' => $updatedEndTime->format('Y-m-d\TH:i:s'),
            'timeZone' => 'Asia/Yerevan',
        ]));

        $updatedEvent = $this->calendarService->events->update('primary', $eventId, $event);

        return $updatedEvent;
    }

    public function deleteEvent($googleEventId): void
    {
        $this->calendarService->events->delete('primary', $googleEventId);
    }

}
