<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::paginate(10);
        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
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
        ];
        $validated = $request->validate($rules);

        // Store
        $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        return redirect(route('users.index'))
            ->withSuccess("Added '{$user->name}'.");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
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
                Password::min(4)->letters(), // ->uncompromised(),
            ],
            'password_confirmation' => [
                'required',
                'required_unless:password,null',
            ],

        ];
        $validated = $request->validate($rules);

        $user->update($validated);

        return redirect(route('users.show', $user))
            ->withSuccess("Updated $user->name.");
    }

    /**
     * Show form to confirm deletion of user resource from storage.
     */
    public function delete(User $user): View
    {
        return view('users.delete', compact(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
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
        $oldUser = $user;
        $user->forceDelete();
        return redirect()
            ->back()
            ->withSuccess("Permanently Removed {$oldUser->name}.");
    }

    /**
     * Restore all users in the trash to system
     */
    public function recoverAll(): RedirectResponse
    {
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
        $users = User::onlyTrashed()->get();
        $trashCount = $users->count();

        foreach ($users as $user) {
            $user->forceDelete();
        }
        return redirect(route('users.trash'))
            ->withSuccess("Successfully emptied trash of $trashCount users.");
    }
}
