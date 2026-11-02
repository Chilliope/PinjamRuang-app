<?php

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\Staff\BookingController as StaffBookingController;
use App\Http\Controllers\Staff\RoomController as StaffRoomController;
use App\Http\Controllers\Staff\ScheduleChangeController as StaffScheduleChangeController;
use App\Http\Controllers\Staff\RoomScheduleController;
use App\Http\Controllers\ClassRepresentativeDashboardController;
use App\Http\Controllers\ClassRepresentative\BookingController;
use App\Http\Controllers\ClassRepresentative\ScheduleChangeController;
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
        Route::resource('/classes', ClassController::class)->except(['show']);
    });

    Route::middleware('role:staff')->prefix('/staff')->name('staff.')->group(function () {
        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');

        Route::get('/bookings', [StaffBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [StaffBookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/approve', [StaffBookingController::class, 'approve'])->name('bookings.approve');
        Route::patch('/bookings/{booking}/reject', [StaffBookingController::class, 'reject'])->name('bookings.reject');

        Route::resource('/rooms', StaffRoomController::class)->except(['show']);
        Route::resource('/schedules', RoomScheduleController::class)->except(['show']);

        // Pengajuan perubahan jadwal
        Route::get('/schedule-changes', [StaffScheduleChangeController::class, 'index'])
            ->name('schedule-changes.index');

        Route::patch('/schedule-changes/{scheduleChange}/approve', [StaffScheduleChangeController::class, 'approve'])
            ->name('schedule-changes.approve');

        Route::patch('/schedule-changes/{scheduleChange}/reject', [StaffScheduleChangeController::class, 'reject'])
            ->name('schedule-changes.reject');

        // Perubahan jadwal langsung oleh Staff
        Route::get('/schedule-changes/direct/create', [StaffScheduleChangeController::class, 'directCreate'])
            ->name('schedule-changes.direct.create');

        Route::post('/schedule-changes/direct', [StaffScheduleChangeController::class, 'directStore'])
            ->name('schedule-changes.direct.store');
    });


    Route::middleware('role:class_representative')->prefix('/class-representative')->name('class-representative.')->group(function () {
        Route::get('/', [ClassRepresentativeDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);

        Route::get('/schedule-changes', [ScheduleChangeController::class, 'index',])->name('schedule-changes.index');
        Route::get('/schedule-changes/{schedule}/create', [ScheduleChangeController::class, 'create',])->name('schedule-changes.create');
        Route::post('/schedule-changes/{schedule}', [ScheduleChangeController::class, 'store',])->name('schedule-changes.store');
    });
});

Route::get('/', function () {
    return view('welcome');
});
