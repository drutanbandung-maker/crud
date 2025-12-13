<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('Test email dari Laravel 8', function ($message) {
        $message->to('drutanbandung@gmail.com')  // ganti email tujuan
                ->subject('test');
    });

    return 'Email test sudah dikirim (cek inbox atau spam)';
});


// Authentication routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('forgot-password', [ForgotPasswordController::class, 'show'])->name('password.forgot');
Route::post('forgot-password', [ForgotPasswordController::class, 'send'])->name('password.forgot.send');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset.show');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

// protect product routes with auth
Route::middleware('auth')->group(function(){
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('profile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::get('wallet', [\App\Http\Controllers\WalletController::class, 'show'])->name('wallet.show');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});
