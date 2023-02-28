<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController
{
    public function show(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'group_name' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'min:6', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role' => UserRole::STUDENT,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
