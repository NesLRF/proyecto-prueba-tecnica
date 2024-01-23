<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/cita', [App\Http\Controllers\AppointmentController::class, 'validateAppointment'])->name('appointment_get');
Route::get('/cita/{curp}', [App\Http\Controllers\AppointmentController::class, 'curpData'])->name('appointment_register');
Route::post('/crear', [App\Http\Controllers\AppointmentController::class, 'appointmentCreate'])->name('appointment_create');
Route::post('/cita/delete', [App\Http\Controllers\AppointmentController::class, 'appointmentDelete'])->name('appointment_delete')->middleware('curp');