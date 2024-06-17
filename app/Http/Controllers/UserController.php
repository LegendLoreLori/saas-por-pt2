<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): View
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): View
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): View
    {
        //
    }

    /**
     * Displays all soft destroyed resources.
     */

}
