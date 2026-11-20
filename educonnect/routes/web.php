<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/registrasi', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registrasi', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/akses-ditolak', [AuthController::class, 'accessDenied'])->name('access.denied');

Route::middleware(['auth', 'role:pelajar,relawan,pengelola,admin'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('dashboard.admin');
});

Route::middleware(['auth', 'role:pengelola,admin'])->group(function (): void {
    Route::get('/dashboard/pengelola', [DashboardController::class, 'index'])->name('dashboard.pengelola');
});

Route::middleware(['auth', 'role:relawan,admin'])->group(function (): void {
    Route::get('/dashboard/relawan', [DashboardController::class, 'index'])->name('dashboard.relawan');
});

Route::middleware(['auth', 'role:pelajar,admin'])->group(function (): void {
    Route::get('/dashboard/pelajar', [DashboardController::class, 'index'])->name('dashboard.pelajar');
});
