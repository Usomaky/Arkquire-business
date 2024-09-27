<?php

use App\Http\Controllers\HomePageController;
use Inertia\Inertia;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FaqController;
use App\Models\Business;

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

Route::get('/', [HomePageController::class, 'index'])->name('home');

Route::get('/error', function () {
    return Inertia::render('Err404');
})->name('error404');

Route::get('/forgotpassword', function () {
    return Inertia::render('Forgotpassword');
})->name('forgotpassword');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/contact-us', function () {
    return Inertia::render('Contact-us');
})->name('contact-us');
// Route::get('/faq', function () {
//     return Inertia::render('Faq');
// })->name('faq');

Route::get('/faq', [FaqController::class, 'index']);

Route::get('/businesses', [BusinessController::class, 'index']);
Route::get('/businesses/search', [BusinessController::class, 'search'])->name('businesses.search');

Route::get('/auctions', function () {
    return Inertia::render('Auctions');
});

Route::post('/sendotp', [AuthController::class, 'emailOTP']);
Route::post('/password/otp', [AuthController::class, 'passwordOTP']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');


Route::get('/business/{id}', [BusinessController::class, 'business']);
Route::get('/category/{id}', [CategoryController::class, 'category']);

Route::middleware('auth')->group(function () {
    Route::get('/postbusiness', [BusinessController::class, 'show']);
    Route::post('/postbusiness', [BusinessController::class, 'store']);

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store']);
    Route::delete('/bookmarks/{business}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::delete('/bookmarks', [BookmarkController::class, 'destroyAll'])->name('bookmarks.destroyAll');


    Route::get('/inquiry', [InquiryController::class, 'index'])->name('inquiry.index');
    Route::post('/inquiry', [InquiryController::class, 'store']);
    Route::delete('/inquiry/{business}', [InquiryController::class, 'destroy'])->name('inquiry.destroy');
    Route::delete('/inquiry', [InquiryController::class, 'destroyAll'])->name('inquiry.destroyAll');

    // Routes for place bid
    Route::get('/bid', [InquiryController::class, 'index'])->name('bid.index');
    Route::post('/bid', [InquiryController::class, 'store']);
    Route::delete('/bid/{business}', [InquiryController::class, 'destroy'])->name('bid.destroy');
    Route::delete('/bid', [InquiryController::class, 'destroyAll'])->name('bid.destroyAll');


    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', function () {
        return Inertia::render('Profile');
    })->name('profile');
    Route::get('/clientdashboard', function () {
        return Inertia::render('Clientdashboard');
    })->name('clientdashboard');

    Route::put('/profile/update', [ProfileController::class, 'updateProfile']);
});

Route::prefix('super_admin')->group(__DIR__ . '/super_admin.php');
Route::prefix('admin')->group(__DIR__ . '/admin.php');
