<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\ProfileManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Laravel Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Profile Management Routes
    Route::resource('profiles', ProfileManagementController::class)
        ->middleware('tenant')
        ->except(['update'])
        ->names([
            'index' => 'profile.index',
            'create' => 'profile.create',
            'store' => 'profile.store',
            'show' => 'profile.show',
            'edit' => 'profile.management.edit',
            'destroy' => 'profile.management.destroy',
        ]);

    Route::put('profiles/{profile}', [ProfileManagementController::class, 'update'])
        ->middleware('tenant')
        ->name('profile.management.update');
});

require __DIR__.'/auth.php';
