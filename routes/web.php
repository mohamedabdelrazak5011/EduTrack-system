<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResultController;

Route::get('/', function () {
    return redirect('/dashboard');
});

// Students (clean)
Route::resource('students', StudentController::class);

// Extra student routes
Route::get('/students/{student}/qr', [StudentController::class, 'qr'])->name('students.qr');

Route::resource('students', StudentController::class);
Route::get('/students/{student}/records', [AttendanceController::class, 'studentRecords'])->name('students.records');

// Attendance
Route::get('/scan', [AttendanceController::class, 'scan'])->name('scan');
Route::post('/scan', [AttendanceController::class, 'store'])->name('scan.store');
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');
Route::get('/attendance/by-date', [AttendanceController::class, 'byDate'])->name('attendance.byDate');
// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// =========================
// RESULTS (Clean)
// =========================

Route::get('/results', [ResultController::class, 'index'])->name('results.index');

Route::get('/results/create/{student}', [ResultController::class, 'create'])
    ->name('results.create');

Route::post('/results/store', [ResultController::class, 'store'])
    ->name('results.store');

Route::delete('/results/{id}', [ResultController::class, 'destroy'])
    ->name('results.destroy');
Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
