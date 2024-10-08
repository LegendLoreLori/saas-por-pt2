<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Http\RedirectResponse;
// remove
use Illuminate\Support\Facades\Route;
// keep

use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('index', Listing::class);

        $deletedListing = session('deletedListing');
        $listings = Listing::query()->orderByDesc('created_at')->paginate(6);
        return view('listings.index', compact(['listings', 'deletedListing']));
    }

    public function manage(): View
    {
        Gate::authorize('manage', Listing::class);

        $listings = Listing::paginate(10);
        return view('listings.manage', compact(['listings']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Listing::class);

        return (view('listings.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        Gate::authorize('create', Listing::class);

        $request['user_id'] = auth()->user()->getAuthIdentifier();
        // Validate
        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salary' => 'nullable|string|max:45',
            'company' => 'nullable|string|max:45',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:45',
            'phone' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ];
        $validated = $request->validate($rules);

        // Store
        $listing = Listing::create([
                'user_id' => $validated['user_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'salary' => $validated['salary'],
                'company' => $validated['company'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'requirements' => $validated['requirements'],
                'benefits' => $validated['benefits'],
            ]
        );

        return redirect(route('listings.index'))
            ->withSuccess("Successfully created $listing->title.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing): View
    {
        Gate::authorize('show', $listing);

        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing): View
    {
        Gate::authorize('update', $listing);

        return view('listings.edit', compact(['listing']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        if ($request->user()->cannot('update', $listing)) {
            abort(403);
        }

        // Validate
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'salary' => 'nullable|string|max:45',
            'company' => 'nullable|string|max:45',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:45',
            'phone' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
        ];
        $validated = $request->validate($rules);

        // Store
        $listing->update($validated);

        return redirect(route('listings.show', $listing))
            ->withSuccess("Successfully updated $listing->title.");
    }

    /**
     * Show form to confirm deletion of listing resource from storage
     */
    public function delete(Listing $listing): View
    {
        Gate::authorize('delete', $listing);

        return view('listings.delete', compact(['listing']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        Gate::authorize('delete', $listing);

        $listing->delete();

        if(url()->previous() === route('listings.manage')) {
            return redirect(route('listings.manage'))
                ->withSuccess("Listing: $listing->title deleted.");
        }
        return redirect(route('listings.index'))
            ->withSuccess("Listing: $listing->title deleted.")
            ->with('deletedListing', $listing);
    }

    /**
     * Display all soft deleted resources
     */
    public function trash(): View
    {
        Gate::authorize('manage', Listing::class);

        $listings = Listing::onlyTrashed()->orderBy('deleted_at')->paginate(5);
        return view('listings.trash', compact(['listings']));
    }

    /**
     * Restores a specific listing from trash
     */
    public function restore(string $id): RedirectResponse
    {
        $listing = Listing::onlyTrashed()->find($id);
        Gate::authorize('restore', $listing);

        $listing->restore();
        return redirect()
            ->back()
            ->withSuccess("Restored $listing->title");
    }

    /**
     * Remove a listing from trash, permanently deleting it
     */
    public function remove(string $id): RedirectResponse
    {
        $listing = Listing::onlyTrashed()->find($id);
        Gate::authorize('remove', Listing::class);

        $oldListing = $listing;
        $listing->forceDelete();
        return redirect()
            ->back()
            ->withSuccess("Permanently removed $oldListing->title");
    }

    /**
     * Restore all listings in the trash to system
     */
    public function recoverAll(): RedirectResponse
    {
        Gate::authorize('recoverAll', Listing::class);

        $listings = Listing::onlyTrashed()->get();
        $trashCount = $listings->count();

        foreach ($listings as $listing) {
            $listing->restore();
        }
        return redirect(route('listings.trash'))
            ->withSuccess("Successfully recovered $trashCount listings.");
    }

    /**
     * Empties the trash, permanently deleting all trashed users
     */
    public function empty(): RedirectResponse
    {
        Gate::authorize('empty', Listing::class);

        $listings = Listing::onlyTrashed()->get();
        $trashCount = $listings->count();

        foreach ($listings as $listing) {
            $listing->forceDelete();
        }
        return redirect(route('listings.trash'))
            ->withSuccess("Permanently deleted $trashCount listings.");
    }
}
