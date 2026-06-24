<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Appointment Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/appointments',
    [AppointmentController::class, 'index']
);

Route::post(
    '/appointments',
    [AppointmentController::class, 'store']
);

Route::put(
    '/appointments/{id}/approve',
    [AppointmentController::class, 'approve']
);

Route::put(
    '/appointments/{id}/cancel',
    [AppointmentController::class, 'cancel']
);

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/dashboard',
    [AdminController::class, 'index']
)->name('admin.dashboard');

Route::post(
    '/admin/add-department',
    [AdminController::class, 'storeDepartment']
)->name('admin.dept.store');

use App\Http\Controllers\DoctorController;

Route::prefix('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule');
    Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
});