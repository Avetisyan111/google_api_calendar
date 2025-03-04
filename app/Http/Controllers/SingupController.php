<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Mockery\Exception;

class SingupController extends Controller
{
    public function index(): View
    {
        return view('signup');
    }

    public function signup(Request $request): RedirectResponse
    {$request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (User::where('email', $request->email)->exists()){
            throw new \Exception('The email address already taken');
        }

        $user = User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'created_at' => now(),
        'updated_at' => now(),
        ]);

        if (!$user) {
            throw new Exception('Faild to ad the user');
        }

        return redirect('/login')->with('success', 'You are now registered.');

    }

}
