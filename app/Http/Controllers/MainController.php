<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class MainController
{
    public function __invoke(): RedirectResponse
    {
        return redirect()->route('dashboard');
    }
}
