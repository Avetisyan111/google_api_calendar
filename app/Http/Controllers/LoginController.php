<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(): View
    {
        return view('login');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar', 'profile', 'email'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            $accessToken = $googleUser->token;
            $refreshToken = $googleUser->refreshToken;

            session(['google_access_token' => $accessToken]);
            session(['google_refresh_token' => $refreshToken]);

            if (!$existingUser) {
                $nameParts = explode(' ', $googleUser->getName());
                $password = Hash::make(Str::random(16));

                $newUser = User::create([
                    'firstName' => $nameParts[0],
                    'lastName' => $nameParts[1] ?? '',
                    'email' => $googleUser->getEmail(),
                    'password' => $password,
                    'google_id' => $googleUser->getId(),
                ]);

                Auth::login($newUser);
            } else {
                Auth::login($existingUser);
            }

            return redirect('/user');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

    }


    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            throw new Exception("The login or Password is invalid");
        }

        return redirect()->intended('/user');
    }

}
