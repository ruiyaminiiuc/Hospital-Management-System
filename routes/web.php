<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard Routes
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/add-department', [AdminController::class, 'storeDepartment'])->name('admin.dept.store');
