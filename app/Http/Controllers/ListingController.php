<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\View\View;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $listings = Listing::query()->orderByDesc('created_at')->paginate(6);
        return view('listings.index', compact(['listings']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return (view('listings.create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
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
        return view('listings.show', compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
