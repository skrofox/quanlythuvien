<?php

use App\Http\Controllers\Admin\Admin_BookController;
use App\Http\Controllers\Admin\Admin_CategoryController;
use App\Http\Controllers\Admin\Admin_RentalController;
use App\Http\Controllers\Admin\Admin_UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//========================= Admin Router =========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //====== Admin User Router Management ===============
    Route::prefix('/users')->name('users.')->group(function () {
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

    //======= Admin Categories Router Management ===============
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('/', [Admin_CategoryController::class, 'index'])->name('list');
        //Add Category
        Route::post('store', [Admin_CategoryController::class, 'store'])->name('store');

        //Update Category
        Route::get('/edit/{id}', [Admin_CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_CategoryController::class, 'update'])->name('update');

        //Delete Category
        Route::delete('/destroy/{id}', [Admin_CategoryController::class, 'destroy'])->name('destroy');
    });

    //======= Admin Book Router Management ===============
    Route::prefix('/books')->name('books.')->group(function () {
        Route::get('/', [Admin_BookController::class, 'index'])->name('list');

        //add books
        Route::get('/create', [Admin_BookController::class, 'create'])->name('create');
        Route::post('/store', [Admin_BookController::class, 'store'])->name('store');

        //update book
        Route::get('/edit/{id}', [Admin_BookController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_BookController::class, 'update'])->name('update');

        //Delete book
        Route::delete('/destroy/{id}', [Admin_BookController::class, 'destroy'])->name('destroy');
    });

    //======= Admin Rental Router Management ===============
    Route::prefix('/rentals')->name('rentals.')->group(function () {
        Route::get('/', [Admin_RentalController::class, 'index'])->name('list');
    });
});

require __DIR__ . '/auth.php';
