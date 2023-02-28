<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grammar;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class GrammarsListController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Grammars/GrammarsList', [
            'grammars' => Grammar::query()->latest()->get(),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function removeGrammar(Grammar $grammar): RedirectResponse
    {
        $grammar->deleteOrFail();

        return redirect()->route('admin.grammars.list.show');
    }
}