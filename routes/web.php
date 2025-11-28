<?php

use App\Http\Controllers\Admin\Admin_UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//========================= Admin Router =========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //====== Admin User Router Managerment
    Route::prefix('/users')->name('users.')->group(function() {
        //list users
        Route::get('/', [Admin_UserController::class, 'index'])->name('list');
        //Add User
        Route::post('store', [Admin_UserController::class, 'store'])->name('store');

        //Update user
        Route::get('/edit/{id}', [Admin_UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_UserController::class, 'update'])->name('update');

        //Delete User
        Route::delete('/destroy/{id}', [Admin_UserController::class, 'destroy'])->name('destroy');

    });

});

require __DIR__.'/auth.php';
