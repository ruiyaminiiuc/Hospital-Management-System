<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;

// ─── Welcome / Landing ──────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Auth Routes ────────────────────────────────────────────────────────────
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// ─── Protected Routes ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    
    // ─── Admin Routes ───────────────────────────────────────────────────────────
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard',      [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/admin/add-department', [AdminController::class, 'storeDepartment'])->name('admin.dept.store');
        Route::get('/admin/register',       [AdminController::class, 'showRegister'])->name('admin.register');
        Route::post('/admin/register',      [AdminController::class, 'storeUser'])->name('admin.register.store');
    });

    // ─── Patient Routes (CRUD) ──────────────────────────────────────────────────
    Route::get('/patient/dashboard',   [PatientController::class, 'dashboard'])->name('patients.dashboard');
    Route::get('/patients',            [PatientController::class, 'index'])->name('patients.index');
    Route::get('/my/patients',         [PatientController::class, 'myPatients'])->name('doctor.patients');
    Route::get('/patients/create',     [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients',           [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}',  [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // ─── Appointment Routes ─────────────────────────────────────────────────────
    Route::get('/appointments',        [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/book',   [AppointmentController::class, 'book'])->name('appointments.book');
    Route::post('/appointments',       [AppointmentController::class, 'store'])->name('appointments.store');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

    // ─── Doctor Dashboard ───────────────────────────────────────────────────────
    Route::get('/doctor/dashboard', function () {
        return view('doctor.index');
    })->name('doctor.dashboard');
});