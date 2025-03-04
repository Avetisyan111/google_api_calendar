<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div align="center">
        <p class="text-h1" style="margin-top: 15px;">Login Page</p>
        <div style="margin-top: 20px;">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <p class="text-h3">Email</p>
                <div style="margin-top: 5px;" class="mb-3">
                    <input type="email" name="email" placeholder="Email" class="input" required><br>
                </div>
                <p class="text-h3">Password</p>
                <div style="margin-top: 5px;">
                    <input type="password" name="password" placeholder="Password" class="input" required><br>
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn-primary font-medium">Login</button>
                </div>
            </form>
        </div>

        <div style="margin-top: 20px;">
            <form action="{{ route('auth.google') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary font-medium">
                    Login with google
                </button>
            </form>
        </div>

        <div style="margin-top: 20px;">
            <form action="{{ route('signup') }}" method="GET">
                @csrf
                <button type="submit" class="btn-primary font-medium">
                    Signup Page
                </button>
            </form>
        </div>
    </div>

</body>
</html>
