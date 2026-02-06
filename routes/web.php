<?php

use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeduccionController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoIncidenciaController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, '__invoke'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {


    // Recursos Maestros
    Route::resource('empleados', EmpleadoController::class);
    // Route::resource('contratos', ContratoController::class);
    // Route::resource('cargos', CargoController::class);

    // Configuración de Nómina
    Route::resource('deducciones', DeduccionController::class)->except(['show', 'create', 'edit']);
    Route::resource('beneficios', BeneficioController::class)->except(['show', 'create', 'edit']);


    Route::resource('empleados', EmpleadoController::class);
    Route::resource('cargos', CargoController::class);
    Route::resource('contratos', ContratoController::class);
    Route::resource('deducciones', DeduccionController::class);
    Route::resource('beneficios', BeneficioController::class);
    Route::resource('incidencias', IncidenciaController::class);
    Route::resource('tipos-incidencia', TipoIncidenciaController::class);

    Route::resource('tipos-incidencia', TipoIncidenciaController::class)->only(['index', 'store']);
    Route::resource('incidencias', IncidenciaController::class);
    Route::prefix('nomina')->group(function () {
        Route::get('/', [NominaController::class, 'index'])->name('nomina.index');
        Route::get('/crear', [NominaController::class, 'create'])->name('nomina.create'); // <--- ESTA ES LA QUE FALTA
        Route::post('/procesar', [NominaController::class, 'procesar'])->name('nomina.procesar');
        Route::get('/detalle/{id}', [NominaController::class, 'show'])->name('nomina.show');
        Route::get('/recibo/{id}', [NominaController::class, 'verRecibo'])->name('nomina.recibo');
    });
});

require __DIR__ . '/auth.php';
