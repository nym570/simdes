<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordRequestController;
use App\Http\Controllers\Admin\Auth\AdminPasswordRequestController;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest');


Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [PasswordRequestController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordRequestController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationController::class, 'create'])
    ->middleware('auth')
    ->name('verification.notice');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login')->middleware('guest');

Route::get('/admin/forgot-password', [AdminPasswordRequestController::class, 'create'])
    ->middleware('guest')
    ->name('admin.password.request');

Route::post('/admin/forgot-password', [AdminPasswordRequestController::class, 'store'])
    ->middleware('guest')
    ->name('admin.password.email');

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->middleware('admin.auth')
    ->name('admin.logout');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])
    ->middleware('admin.auth')
    ->name('admin.logout');
    