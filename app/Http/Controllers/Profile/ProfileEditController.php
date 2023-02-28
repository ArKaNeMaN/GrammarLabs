<?php

namespace App\Http\Controllers\Profile;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProfileEditController
{
    public function show(): Response
    {
        return Inertia::render('Profile/ProfileEdit');
    }

    /**
     * @throws Throwable
     */
    public function save(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->name = $data['name'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->saveOrFail();

        return redirect()->back();
    }
}
