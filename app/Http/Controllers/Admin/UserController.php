<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('isAdmin', User::class);

        $query = User::query()->where('id', '!=', auth()->id());

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @throws AuthorizationException
     */
    public function show(User $user): View
    {
        $this->authorize('isAdmin', User::class);

        $roles = ['user', 'editor', 'moderator'];

        return view('admin.users.show', compact('user', 'roles'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('isAdmin', User::class);

        $validated = $request->validate([
            'role' => ['required', Rule::in(['user', 'editor', 'moderator', 'admin'])],
        ]);

        $user->role = $validated['role'];
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }
}
