<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\ClassRepresentativeDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role:admin')->prefix('/admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index']);
    });

    Route::middleware('role:staff')->prefix('/staff')->group(function () {
        Route::get('/', [StaffDashboardController::class, 'index']);
    });

    Route::middleware('role:class_representative')->prefix('/class-representative')->group(function () {
        Route::get('/', [ClassRepresentativeDashboardController::class, 'index']);
    });
});

Route::get('/', function () {
    return view('welcome');
});
