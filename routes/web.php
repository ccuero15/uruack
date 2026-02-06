<?php


use App\Http\Controllers\NominaController;
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

    Route::prefix('nomina')->group(function () {
        Route::post('/procesar', [NominaController::class, 'procesar'])->name('nomina.procesar');
        Route::get('/ejecuciones', [NominaController::class, 'index']); // Listado de nóminas
        Route::get('/recibo/{id}', [NominaController::class, 'verRecibo']); // Ver PDF
    });
});

require __DIR__ . '/auth.php';
