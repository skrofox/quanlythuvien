<?php

use App\Http\Controllers\Admin\Admin_BookController;
use App\Http\Controllers\Admin\Admin_CategoryController;
use App\Http\Controllers\Admin\Admin_PaymentController;
use App\Http\Controllers\Admin\Admin_RentalController;
use App\Http\Controllers\Admin\Admin_RentalPricingController;
use App\Http\Controllers\Admin\Admin_ReviewController;
use App\Http\Controllers\Admin\Admin_UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FEnd\HeaderController;
use App\Http\Controllers\FEnd\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReadBookController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\VNPayController;
use Illuminate\Support\Facades\Route;

//============UnAuth router management================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book-detail/{slug}', [HomeController::class, 'book_detail'])->name('book.detail');;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //======= Frontend Auth Router Management ===============
    Route::get('/account', [HeaderController::class, 'account'])->name('account');
    Route::get('/borrow-book/{slug}', [RentalController::class, 'index'])->name('book.rental.create');

    Route::get('/read-book/{slug}', [ReadBookController::class, 'read'])->name('book.read');

    //VNPay
    Route::post('/vnpay-payment/', [VNPayController::class, 'vnpay_payment'])->name('vnpay.payment.store');
    Route::get('/vnpay-return', [VNPayController::class, 'vnpay_return'])->name('vnpay.return');

});

//========= API Qoutes ============
Route::get('/quotes', [HomeController::class, 'quotes'])->name('quotes');


//========================= Admin Router =========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    //======= Admin Settings Router Management ===============
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings/update/{id}', [AdminController::class, 'updateSettings'])->name('settings.update');

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
        Route::get('/create', [Admin_RentalController::class, 'create'])->name('create');
        Route::post('/store', [Admin_RentalController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [Admin_RentalController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_RentalController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [Admin_RentalController::class, 'destroy'])->name('destroy');
    });

    //======= Admin Rental Pricing Router Management ===============
    Route::prefix('/rental-pricings')->name('rental-pricings.')->group(function () {
        Route::get('/', [Admin_RentalPricingController::class, 'index'])->name('list');
        Route::post('/store', [Admin_RentalPricingController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [Admin_RentalPricingController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_RentalPricingController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [Admin_RentalPricingController::class, 'destroy'])->name('destroy');
    });

    //======= Admin Payment Router Management ===============
    Route::prefix('/payments')->name('payments.')->group(function () {
        Route::get('/', [Admin_PaymentController::class, 'index'])->name('list');
        Route::get('/create', [Admin_PaymentController::class, 'create'])->name('create');
        Route::post('/store', [Admin_PaymentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [Admin_PaymentController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_PaymentController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [Admin_PaymentController::class, 'destroy'])->name('destroy');
    });

    //======= Admin Review Router Management ===============
    Route::prefix('/reviews')->name('reviews.')->group(function () {
        Route::get('/', [Admin_ReviewController::class, 'index'])->name('list');
        Route::get('/create', [Admin_ReviewController::class, 'create'])->name('create');
        Route::post('/store', [Admin_ReviewController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [Admin_ReviewController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [Admin_ReviewController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [Admin_ReviewController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__ . '/auth.php';
