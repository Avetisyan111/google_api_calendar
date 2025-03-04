<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div align="center">
        <p class="text-h1" style="margin-top: 15px;">All Events</p>

        <div>
            <form action="{{ route('calendar.update', ['eventId' => $event->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <p style="margin-top: 20px;" class="text-h3">Event Title</p>
                <div style="margin-top: 10px;">
                    <input type="text" name="title" placeholder="Event Title" class="input" value="{{ $event->title }}">
                </div>
                <p style="margin-top: 10px;" class="text-h3">Event Description</p>
                <div style="margin-top: 10px;">
                    <textarea name="description" placeholder="Event Description" class="input-textarea">{{ $event->description }}</textarea>
                </div>
                <p style="margin-top: 10px;" class="text-h3">Start Time</p>
                <div style="margin-top: 10px;">
                    <input type="datetime-local" name="start_time" class="input-datetime" value="{{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i') }}">
                </div>
                <p style="margin-top: 10px;" class="text-h3">End Time</p>
                <div style="margin-top: 10px;">
                    <input type="datetime-local" name="end_time" class="input-datetime" value="{{ \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i') }}">
                </div>
                <div style="margin-top: 10px;">
                    <button type="submit" class="btn-primary">Update Event</button>
                </div>
            </form>
        </div>

        <div style="margin-top: 20px;">
            <form action="{{ route('get.events') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary">
                    Back To Events
                </button>
            </form>
        </div>

    </div>
</body>
</html>
