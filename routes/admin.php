<?php

use App\Http\Controllers\Admin\Web\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Web\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Web\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Web\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Web\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Web\Auth\PasswordController;
use App\Http\Controllers\Admin\Web\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Web\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Web\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\Web\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Model\Admin;

Route::middleware('guest:admin')->prefix('admin')->name('admin.')->group(function () {

	Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

	Route::post('register', [RegisteredUserController::class, 'store']);

	Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

	Route::post('login', [AuthenticatedSessionController::class, 'store']);

	Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');

	Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');

	Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

	Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store'); 
});

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

	Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');

	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

	Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');

	Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

	Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

	Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');

	Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

	Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});
