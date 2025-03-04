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
        <div style="position: absolute; top: 20px; right: 20px; z-index: 10;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-danger">
                    Log out
                </button>
            </form>
        </div>

        <p class="text-h1" style="margin-top: 15px;">Create Google Calendar Events</p>

        <form action="{{ route('calendar.create') }}" method="POST">
            @csrf
            <p style="margin-top: 20px;" class="text-h3">Event Title</p>
            <div style="margin-top: 10px;">
                <input type="text" name="title" placeholder="Event Title" class="input" required>
            </div>
            <p style="margin-top: 10px;" class="text-h3">Event Description</p>
            <div style="margin-top: 10px;">
                <textarea name="description" placeholder="Event Description" class="input-textarea"></textarea>
            </div>
            <p style="margin-top: 10px;" class="text-h3">Start Time</p>
            <div style="margin-top: 10px;">
                <input type="datetime-local" name="start_time" class="input-datetime" required>
            </div>
            <p style="margin-top: 10px;" class="text-h3">End Time</p>
            <div style="margin-top: 10px;">
                <input type="datetime-local" name="end_time" class="input-datetime" required>
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" class="btn-primary">Create Event</button>
            </div>
        </form>

        <div style="margin-top: 20px;">
            <form action="{{ route('get.events') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary">
                    Get Events
                </button>
            </form>
        </div>
    </div>

</body>
</html>
