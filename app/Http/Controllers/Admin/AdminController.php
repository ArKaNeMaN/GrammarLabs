<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Inertia\Response;

class AdminController
{
    public function __invoke(): Response
    {
        return Inertia::render('Admin/Main');
    }
}
