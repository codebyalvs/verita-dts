<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

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
    return redirect('login');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('dashboard');
Route::post('/increment', [HomeController::class, 'increment'])->middleware('auth')->name('increment');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware('guest')
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->middleware('guest')
                ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware('guest')
                ->name('password.email');

Route::get('/reset-password', [NewPasswordController::class, 'create'])
                ->middleware('guest')
                ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware('guest')
                ->name('password.update');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');

// Email Verification Routes
Route::get('/verify-email', [RegisteredUserController::class, 'showVerificationForm'])
    ->middleware('guest')
    ->name('verification.notice');

Route::post('/verify-email', [RegisteredUserController::class, 'verify'])
    ->middleware('guest')
    ->name('verification.verify');

Route::post('/verify-email/resend', [RegisteredUserController::class, 'resend'])
    ->middleware('guest')
    ->name('verification.resend');

Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Password Reset Code Routes
Route::get('/password/code', [PasswordResetLinkController::class, 'showCodeForm'])
    ->middleware('guest')
    ->name('password.code');

Route::post('/password/code', [PasswordResetLinkController::class, 'verifyCode'])
    ->middleware('guest')
    ->name('password.verify.code');

Route::post('/password/resend', [PasswordResetLinkController::class, 'resendCode'])
    ->middleware('guest')
    ->name('password.resend.code');
