<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Services\GoogleCalendarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GoogleApiController extends Controller
{
    public function __construct(
        protected GoogleCalendarService $googleCalendarService
    ) {}

    public function create(Request $request): RedirectResponse
    {
        $eventData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
        ];

        $event = $this->googleCalendarService->createEvent($eventData);
        $event = Calendar::create([
            'google_event_id' => $event->id,
            'title' => $event->summary,
            'description' => $event->description,
            'start_time' => $event->start['dateTime'],
            'end_time' => $event->end['dateTime'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!$event) {
            throw new \Exception('Could not create event');
        }
        return redirect()->route('user');

    }

    public function events(): View
    {
        $events = Calendar::all();

        return view('events', compact('events'));
    }

    public function edit(int $id): View
    {
        $event = Calendar::findOrFail($id);

        return view('edit', compact('event'));
    }

    public function update($eventId, Request $request): RedirectResponse
    {
        $googleEventId = Calendar::where('id', $eventId)->value('google_event_id');

        $eventData = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
        ];

        $event = Calendar::where('id', $eventId)->update([
            'title' => $eventData['title'],
            'description' => $eventData['description'],
            'start_time' => $eventData['start_time'],
            'end_time' => $eventData['end_time'],
            'updated_at' => now(),
        ]);

       $this->googleCalendarService->updateEvent($googleEventId, $eventData);

       if (!$event) {
           throw new \Exception('Could not update event');
       }

       return redirect()->route('get.events');
    }

    public function delete($eventId): RedirectResponse
    {
        $googleEventId = Calendar::where('id', $eventId)->value('google_event_id');
        $this->googleCalendarService->deleteEvent($googleEventId);

        Calendar::where('id', $eventId)->delete();

        return redirect()->route('get.events');
    }

}
