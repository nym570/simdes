<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Auth\AdminVerifyEmailController;
use App\Http\Controllers\Admin\Auth\AdminPasswordResetController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\PasswordRequestController;
use App\Http\Controllers\Admin\Auth\AdminPasswordRequestController;
use App\Http\Controllers\Admin\Auth\AdminEmailVerificationController;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/login', [LoginController::class, 'create'])->name('login')->middleware('guest:web');
Route::post('/login', [LoginController::class, 'store'])->middleware('guest:web');


Route::get('/register', [RegisterController::class, 'create'])->name('register')->middleware('guest:web');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest:web');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth:web')
    ->name('logout');

Route::get('/forgot-password', [PasswordRequestController::class, 'create'])
    ->middleware('guest:web')
    ->name('password.request');

Route::post('/forgot-password', [PasswordRequestController::class, 'store'])
    ->middleware('guest:web')
    ->name('password.email');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'create'])
    ->middleware(['guest:web'])
    ->name('password.reset');
Route::get('admin/reset-password/{token}', [AdminPasswordResetController::class, 'create'])
    ->middleware(['guest:admin'])
    ->name('admin.password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'store'])
    ->middleware(['guest:web'])
    ->name('password.update');
    Route::post('admin/reset-password', [AdminPasswordResetController::class, 'store'])
    ->middleware(['guest:admin'])
    ->name('admin.password.update');

Route::get('/verify-email', [EmailVerificationController::class, 'create'])
    ->middleware(['auth:web'])
    ->name('verification.notice');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'store'])
    ->middleware(['auth:web', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware([ 'auth:web','signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('/admin/verify-email/{id}/{hash}', [AdminVerifyEmailController::class, '__invoke'])
    ->middleware([ 'auth:admin','signed', 'throttle:6,1'])
    ->name('admin.verification.verify');

Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login')->middleware('guest:admin');
Route::post('/admin/login', [AdminLoginController::class, 'store'])->name('admin.login')->middleware('guest:admin');

Route::get('/admin/forgot-password', [AdminPasswordRequestController::class, 'create'])
    ->middleware('guest:admin')
    ->name('admin.password.request');

Route::post('/admin/forgot-password', [AdminPasswordRequestController::class, 'store'])
    ->middleware('guest:admin')
    ->name('admin.password.email');

Route::post('/admin/logout', [AdminLoginController::class, 'logout'])
    ->middleware(['admin.auth'])
    ->name('admin.logout');
Route::get('/admin/logout', [AdminLoginController::class, 'logout'])
    ->middleware(['admin.auth'])
    ->name('admin.logout');
 Route::get('/admin/verify-email', [AdminEmailVerificationController::class, 'create'])
    ->middleware(['admin.auth'])
    ->name('admin.verification.notice');

Route::post('/admin/email/verification-notification', [AdminEmailVerificationController::class, 'store'])
    ->middleware(['admin.auth', 'throttle:6,1'])
    ->name('admin.verification.send');

    