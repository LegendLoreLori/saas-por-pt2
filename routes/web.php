<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPages;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StaticPages::class, 'welcome'])->name('home');
Route::get('welcome', [StaticPages::class, 'welcome'])->name('welcome');
Route::get('about', [StaticPages::class, 'about'])->name('about');
Route::get('contact-us', [StaticPages::class, 'contact_us'])->name('contact-us');
Route::get('pricing', [StaticPages::class, 'pricing'])->name('pricing');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

require __DIR__.'/auth.php';
