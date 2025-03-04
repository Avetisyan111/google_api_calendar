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
        <p class="text-h1" style="margin-top: 20px;">All Events</p>

        <table class="table-style" style="margin-top: 10px;">
            <tr style="border: 1px solid black; padding: 10px;">
                <th style="border: 1px solid black; padding: 10px;">Title</th>
                <th style="border: 1px solid black; padding: 10px;">Description</th>
                <th style="border: 1px solid black; padding: 10px;">Start Time</th>
                <th style="border: 1px solid black; padding: 10px;">End Time</th>
                <th style="border: 1px solid black; padding: 10px; background-color: blue; color: white;">Edit Event</th>
                <th style="border: 1px solid black; padding: 10px; background-color: red; color: white;">Delete Event</th>
            </tr>
            @foreach ($events as $event)
            <tr style="border: 1px solid black; padding: 10px;">
                <td style="border: 1px solid black; padding: 10px;">{{ $event->title }}</td>
                <td style="border: 1px solid black; padding: 10px;">{{ $event->description }}</td>
                <td style="border: 1px solid black; padding: 10px;">{{ $event->start_time }}</td>
                <td style="border: 1px solid black; padding: 10px;">{{ $event->end_time }}</td>
                <td style="border: 1px solid black; padding: 10px; background-color: blue; color: white;" class="td-edit">
                    <form action="{{ route('calendar.edit', ['eventId' => $event->id ]) }}" method="GET">
                        <button type="submit" class="btn-edit">Edit Event</button>
                    </form>
                </td>
                <td style="border: 10px; background-color: red; color: white;" class="td-delete">
                    <form action="{{ route('calendar.delete', ['eventId' => $event->id]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn-delete">Delete Event</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>

        <div style="margin-top: 20px;">
            <form action="{{ route('user') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary">
                    Back To User Page
                </button>
            </form>
        </div>
    </div>
</body>
</html>
