<?php

namespace App\Http\Controllers;

use App\Models\EjecucionNomina;
use App\Models\Empleado;
use App\Services\NominaService;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    public function procesar(Request $request, NominaService $service)
    {
        // 1. Crear la cabecera de la ejecución
        $ejecucion = EjecucionNomina::create([
            'periodo_inicio' => $request->fecha_inicio,
            'periodo_fin'    => $request->fecha_fin,
            'estado'         => 'Procesada'
        ]);

        // 2. Obtener empleados activos
        $empleados = Empleado::where('estado', 'Activo')->get();

        foreach ($empleados as $empleado) {
            $service->procesarEmpleado($ejecucion->id, $empleado->id);
        }

        return response()->json(['message' => 'Nómina procesada exitosamente']);
    }
}
