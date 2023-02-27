<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GrammarRequest;
use App\Models\Grammar;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GrammarController
{
    public function show(Grammar $grammar): Response
    {
        return Inertia::render('Admin/Grammars/GrammarEdit', [
            'grammar' => $grammar->exists ? $grammar : null,
        ]);
    }

    public function save(GrammarRequest $request, Grammar $grammar): RedirectResponse
    {
        $grammar->fill($request->validated())->save();

        return redirect()->route('admin.grammars.edit', $grammar);
    }
}
