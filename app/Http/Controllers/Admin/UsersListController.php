<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class UsersListController
{
    public function show(): Response
    {
        return Inertia::render('Admin/Users/UsersList');
    }

    public function __invoke(Request $request): Paginator
    {
        return User::query()
            ->latest()
            ->select(['name', 'login', 'created_at', 'role', 'id'])
            ->when(
                !$request->isNotFilled('search'),
                static fn(Builder $q) => $q->where(static fn(Builder $q) => $q
                    ->orWhere('login', 'LIKE', '%'.$request->input('search').'%')
                    ->orWhere('name', 'LIKE', '%'.$request->input('search').'%'))
            )
            ->paginate(
                perPage: $request->input('perPage', 10),
                page: $request->input('page', 1),
            );
    }

    /**
     * @throws Throwable
     */
    public function removeUser(User $user): array
    {
        $user->deleteOrFail();

        return ['result' => true];
    }

    /**
     * @throws Throwable
     */
    public function changeUserName(Request $request, User $user): array
    {
        $user->updateOrFail(['name' => $request->input('name')]);

        return ['result' => true];
    }

    /**
     * @throws Throwable
     */
    public function changeUserPass(Request $request, User $user): array
    {
        $user->updateOrFail(['password' => Hash::make($request->input('password'))]);

        return ['result' => true];
    }
}
