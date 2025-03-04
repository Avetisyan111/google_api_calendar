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
        <p class="text-h1" style="margin-top: 15px;">Sign up Page</p>
        <form action="{{ route('signup') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <p style="margin-top: 10px;" class="text-h3">First Name</p>
            <div style="margin-top: 5px;">
                <input type="text" name="firstName" placeholder="First name" class="input" required><br>
            </div>
            <p style="margin-top: 10px;" class="text-h3">Last Name</p>
            <div style="margin-top: 5px;">
                <input type="text" name="lastName" placeholder="Last name" class="input" required><br>
            </div>
            <p style="margin-top: 10px;" class="text-h3">Email</p>
            <div style="margin-top: 5px;">
                <input type="email" name="email" placeholder="Email" class="input" required><br>
            </div>
            <p style="margin-top: 10px;" class="text-h3">Password</p>
            <div style="margin-top: 5px;">
                <input type="password" name="password" placeholder="Password" class="input" required><br>
            </div>
            <div style="margin-top: 20px;">
                <button type="submit" class="btn-primary">Sign up</button>
            </div>
        </form>
        <div style="margin-top: 20px;">
            <form action="{{ route('login') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary">
                    Back To Login Page
                </button>
            </form>
        </div>
    </div>
</body>
</html>
