<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('concepts', ConceptController::class);
    Route::resource('nominations', NominationController::class);
    Route::post('nominations/{nomination}/process', [NominationController::class, 'process'])->name('nominations.process');
    Route::post('nominations/{nomination}/approve', [NominationController::class, 'approve'])->name('nominations.approve');
    Route::post('nominations/{nomination}/reject', [NominationController::class, 'reject'])->name('nominations.reject');
});

require __DIR__.'/auth.php';
