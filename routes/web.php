<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ManagementDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DailyActivityController;
use App\Http\Controllers\ListFindingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    // Common authenticated routes (accessible to all roles)
    Route::resource('daily-activities', DailyActivityController::class);
    Route::resource('list-findings', ListFindingController::class);
    Route::resource('reports', ReportController::class);

    // Role-specific dashboard routes
    Route::middleware('role:student')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard.student');
    });

    Route::middleware('role:management')->group(function () {
        Route::get('/dashboard/management', [ManagementDashboardController::class, 'index'])->name('dashboard.management');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    });
});
