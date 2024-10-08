<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\call;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('index', User::class);

        $users = User::with('roles')->paginate(10);
        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = Role::all()->pluck('name');

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Validate
        $rules = [
            'name' => ['string', 'required', 'min:3', 'max:128'],
            'email' => ['required', 'email:rfc', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(4)->letters(),],
            'roles' => ['sometimes', Rule::in(Role::all()->pluck('name'))]
        ];
        $validated = $request->validate($rules);

        if ($request->user()->cannot('create', [User::class, $request])) {
            abort(403);
        }

        // Store
        $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        $user->syncRoles($validated['roles'] ?? 'client') ;

        return redirect(route('users.index'))
            ->withSuccess("Added '$user->name'.");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        Gate::authorize('view', $user);

        return view('users.show', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        Gate::authorize('edit', $user);

        $roles = Role::all()->pluck('name');

        return view('users.edit', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('update', $user);

        if (empty($request['password'])) {
            unset($request['password']);
            unset($request['password_confirmation']);
        }

        // Validate
        $rules = [
            'name' => [
                'string',
                'required',
                'min:3',
                'max:128'
            ],
            'email' => [
                'required',
                'email:rfc',
                Rule::unique('users')->ignore($user),
            ],
            'password' => [
                'sometimes',
                'confirmed',
                Password::min(4)->letters(),
            ],
            'password_confirmation' => [
                'required_unless:password,null',
            ],
            'roles' => [
                'sometimes',
                Rule::in(Role::all()->pluck('name')),
            ]
        ];

        $validated = $request->validate($rules);
        $roles = $validated['roles'];
        unset($validated['roles']);

        $user->update($validated);
        $user->syncRoles($roles);

        return redirect(route('users.show', $user))
            ->withSuccess("Updated $user->name.");
    }

    /**
     * Show form to confirm deletion of user resource from storage.
     */
    public function delete(User $user): View
    {
        Gate::authorize('delete', $user);

        return view('users.delete', compact(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('delete', $user);

        $user->delete();
        return redirect(route('users.index'))
            ->withSuccess("User: $user->name deleted.");
    }

    /**
     * Displays all soft destroyed resources.
     */
    public function trash(): View
    {
        $users = User::onlyTrashed()->orderBy('deleted_at')->paginate(5);
        return view('users.trash', compact(['users']));
    }

    /**
     * Restores a specific user from trash
     */
    public function restore(string $id): RedirectResponse
    {
        Gate::authorize('restore', User::class);

        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()
            ->back()
            ->withSuccess("Restored $user->name.");

    }

    /**
     * Remove a user from trash, permanently deleting it
     */
    public function remove(string $id): RedirectResponse
    {
        $user = User::onlyTrashed()->find($id);
        Gate::authorize('remove', $user);

        $oldUser = $user;
        $user->forceDelete();
        return redirect()
            ->back()
            ->withSuccess("Permanently removed $oldUser->name.");
    }

    /**
     * Restore all users in the trash to system
     */
    public function recoverAll(): RedirectResponse
    {
        Gate::authorize('recoverAll', User::class);

        $users = User::onlyTrashed()->get();
        $trashCount = $users->count();

        foreach ($users as $user) {
            $user->restore();
        }
        return redirect(route('users.trash'))
            ->withSuccess("Successfully recovered $trashCount users.");
    }

    /**
     * Empties the trash, permanently deleting all trashed users
     */
    public function empty(): RedirectResponse
    {
        Gate::authorize('empty', User::class);

        $users = User::onlyTrashed()->get();
        $trashCount = $users->count();

        foreach ($users as $user) {
            $user->forceDelete();
        }
        return redirect(route('users.trash'))
            ->withSuccess("Permanently deleted $trashCount users.");
    }
}
