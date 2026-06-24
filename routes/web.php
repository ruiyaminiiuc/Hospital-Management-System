<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/appointments',
    [AppointmentController::class,'index']
);

Route::post(
    '/appointments',
    [AppointmentController::class,'store']
);

Route::put(
    '/appointments/{id}/approve',
    [AppointmentController::class,'approve']
);

Route::put(
    '/appointments/{id}/cancel',
    [AppointmentController::class,'cancel']
);