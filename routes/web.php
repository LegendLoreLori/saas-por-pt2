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
    Route::resource('users', UserController::class);
    Route::get('users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');
});

require __DIR__.'/auth.php';
