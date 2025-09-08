<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/student/dashboard', function () {
//    return view('student.dashboard');
//})->middleware(['auth', 'role:student'])->name('student.dashboard');

//Route::get('/teacher/dashboard', function () {
//    return view('teacher.dashboard');
//})->middleware(['auth', 'role:teacher'])->name('teacher.dashboard');

//Route::get('/admin/dashboard', function () {
//    return view('admin.dashboard');
//})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
