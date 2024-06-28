<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPages;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StaticPages::class, 'welcome'])->name('home');
Route::get('welcome', [StaticPages::class, 'welcome'])->name('welcome');
Route::get('about', [StaticPages::class, 'about'])->name('about');
Route::get('contact-us', [StaticPages::class, 'contact_us'])->name('contact-us');
Route::get('pricing', [StaticPages::class, 'pricing'])->name('pricing');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Users
Route::middleware(['auth'])->group(function() {
    // Trashed users
    Route::get('users/trash', [UserController::class, 'trash'])
        ->name('users.trash');
    // Individual user restore/remove
    Route::get('users/{user}/trash/restore', [UserController::class, 'restore'])
        ->name('users.trash-restore');
    Route::delete('users/{user}/trash/remove', [UserController::class, 'remove'])
        ->name('users.trash-remove');
    // All trashed users restore/remove
    Route::post('users/trash/recover', [UserController::class, 'recoverAll'])
        ->name('users.trash-recover');
    Route::delete('users/trash/empty', [UserController::class, 'empty'])
        ->name('users.trash-empty');

    // Delete user
    Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

    Route::resource('users', UserController::class);
});

/* I really don't understand how our middleware is working, it appears to be a
middleware group, but I can't actually see any middleware controllers defined?
Is it even middleware? or just some funny auth? */

// Listings
Route::middleware(['auth'])->group(function() {
    // Trashed listings
    Route::get('listings/trash', [ListingController::class, 'trash'])
        ->name('listings.trash');
    // Individual listing restore/remove
    Route::get('listings/{listing}/trash/restore', [ListingController::class, 'restore'])
        ->name('listings.trash-restore');
    Route::delete('listings/{listing}/trash/remove', [ListingController::class, 'remove'])
        ->name('listings.trash-remove');
    // All trashed listing restore/remove
    Route::post('listings/trash/recover', [ListingController::class, 'recoverAll'])
        ->name('listings.trash-recover');
    Route::delete('listings/trash/empty', [ListingController::class, 'empty'])
        ->name('listings.trash-empty');

    // Delete listing
    Route::get('listings/{listing}/delete', [ListingController::class, 'delete'])->name('listings.delete');


    Route::resource('listings', ListingController::class);
});

// Email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

require __DIR__.'/auth.php';
