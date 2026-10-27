<?php

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\Staff\BookingController as StaffBookingController;
use App\Http\Controllers\ClassRepresentativeDashboardController;
use App\Http\Controllers\ClassRepresentative\BookingController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:admin')->prefix('/admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.index');
        Route::resource('/majors', MajorController::class);
        Route::resource('/buildings', BuildingController::class);
        Route::resource('/users', UserController::class);
        Route::resource('/rooms', RoomController::class);
    });

    Route::middleware('role:staff')->prefix('/staff')->name('staff.')->group(function () {
        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');

        Route::get('/bookings', [StaffBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [StaffBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/approve', [StaffBookingController::class, 'approve'])->name('bookings.approve');
        Route::patch('/bookings/{booking}/reject', [StaffBookingController::class, 'reject'])->name('bookings.reject');
    });


    Route::middleware('role:class_representative')->prefix('/class-representative')->name('class-representative.')->group(function () {
        Route::get('/', [ClassRepresentativeDashboardController::class, 'index'])->name('dashboard');

        Route::resource('/bookings', BookingController::class)
            ->only(['index', 'create', 'store', 'show']);
    });
});

Route::get('/', function () {
    return view('welcome');
});
