<?php

namespace App\Http\Controllers;

use App\Models\EjecucionNomina;
use App\Models\Empleado;
use App\Models\ItemNomina;
use App\Services\NominaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    // Listado de nóminas ejecutadas
    public function index()
    {
        $ejecuciones = EjecucionNomina::orderBy('id', 'desc')->paginate(10);
        return view('nomina.index', compact('ejecuciones'));
    }

    // Vista para configurar una nueva nómina
    public function create()
    {
        return view('nomina.create');
    }

    // Proceso masivo de generación
    public function procesar(Request $request, NominaService $service)
    {
        // 1. Ajustamos la regla para permitir procesar un solo día si es necesario
        $request->validate([
            'periodo_inicio' => 'required|date',
            'periodo_fin'    => 'required|date|after_or_equal:periodo_inicio',
        ], [
            'periodo_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la de inicio.'
        ]);

        try {
            DB::beginTransaction();

            // 2. Obtener empleados primero para no crear la cabecera en vano
            $empleados = Empleado::where('estado', 'Activo')
                ->whereHas('contratos', function ($q) {
                    $q->where('estado', 'Vigente');
                })->get();

            if ($empleados->isEmpty()) {
                throw new \Exception('No se encontraron empleados activos con contratos vigentes para este periodo.');
            }

            // 3. Crear cabecera (Asegúrate de que la tabla tenga 'total_pagado' si el servicio no lo llena)
            $ejecucion = EjecucionNomina::create([
                'periodo_inicio'  => $request->periodo_inicio,
                'periodo_fin'     => $request->periodo_fin,
                'fecha_ejecucion' => now(),
                'total_pagado'    => 0, // Lo actualizaremos después del bucle
                'estado'          => 'Procesada'
            ]);

            $totalNomina = 0;

            // 4. Procesar cada empleado
            foreach ($empleados as $empleado) {
                // El servicio debe retornar el monto neto calculado para sumarizar
                $item = $service->procesarEmpleado($ejecucion->id, $empleado->id);
                $totalNomina += $item->salario_neto;
            }

            // 5. Actualizar el total general de la nómina
            $ejecucion->update(['total_pagado' => $totalNomina]);

            DB::commit();

            return redirect()->route('nomina.index') // O show
                ->with('success', 'Nómina procesada correctamente. Total: $' . number_format($totalNomina, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            // Logueamos el error para debug interno
            \Log::error("Error procesando nómina: " . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Ver detalle de una nómina específica
    public function show($id)
    {
        $ejecucion = EjecucionNomina::with(['items.empleado'])->findOrFail($id);
        return view('nomina.show', compact('ejecucion'));
    }

    public function verRecibo($itemId)
    {
        $item = ItemNomina::with(['empleado.contratos.cargo', 'ejecucion', 'detallesDeducciones.deduccion', 'detallesBeneficios.beneficio'])
            ->findOrFail($itemId);

        return view('nomina.recibo_detalle', compact('item'));
    }
}
