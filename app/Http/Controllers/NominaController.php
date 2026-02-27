<?php

namespace App\Http\Controllers;

use App\Models\EjecucionNomina;
use App\Models\Empleado;
use App\Models\ItemNomina;
use App\Services\NominaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    // Guardar el borrador inicial
    public function store(Request $request)
    {
        $request->validate([
            'periodo_inicio' => 'required|date|before_or_equal:now',
            'periodo_fin'    => 'required|date|after_or_equal:periodo_inicio|before_or_equal:now',
            'comentario'     => 'nullable|string'
        ], [
            'periodo_inicio.before_or_equal' => 'La fecha de inicio no puede ser mayor al día actual.',
            'periodo_fin.before_or_equal'    => 'La fecha de fin no puede ser mayor al día actual.',
        ]);

        try {
            EjecucionNomina::create([
                'periodo_inicio'  => $request->periodo_inicio,
                'periodo_fin'     => $request->periodo_fin,
                'fecha_ejecucion' => now(),
                'total_pagado'    => 0,
                'estado'          => 'Borrador',
                'comentario'      => $request->comentario ?? 'Borrador creado manualmente'
            ]);

            return redirect()->route('nomina.index')
                ->with('success', 'Borrador de nómina creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al crear la nómina: ' . $e->getMessage());
        }
    }

    // Proceso masivo de generación
    public function procesar($id, NominaService $service)
    {
        $ejecucion = EjecucionNomina::findOrFail($id);

        if ($ejecucion->estado == 'Procesada') {
            return redirect()->route('nomina.index')->with('error', 'Esta nómina ya ha sido procesada.');
        }

        try {
            DB::beginTransaction();

            $ejecucion->update([
                'estado' => 'Procesando...',
                'comentario' => 'Cálculo en progreso...'
            ]);

            // 2. Obtener empleados activos con contratos vigentes
            $empleados = Empleado::where('estado', 'Activo')
                ->whereHas('contratos', function ($q) {
                    $q->where('estado', 'Vigente');
                })->get();

            if ($empleados->isEmpty()) {
                throw new \Exception('No se encontraron empleados activos con contratos vigentes para este periodo.');
            }

            $totalNomina = 0;

            // 3. Procesar cada empleado
            foreach ($empleados as $empleado) {
                $item = $service->procesarEmpleado($ejecucion->id, $empleado->id);
                if ($item) {
                    $totalNomina += $item->salario_neto;
                }
            }

            // 4. Actualizar el registro con éxito
            $ejecucion->update([
                'total_pagado' => $totalNomina,
                'estado'       => 'Procesada',
                'comentario'   => 'Nómina procesada exitosamente para ' . $empleados->count() . ' empleados el ' . now()->format('d/m/Y H:i')
            ]);

            DB::commit();

            return redirect()->route('nomina.index')
                ->with('success', 'Nómina procesada correctamente. Total: $' . number_format($totalNomina, 2));
        } catch (Exception $e) {
            DB::rollBack();

            // 5. Registrar el error en el comentario de la ejecución
            $ejecucion->update([
                'estado'     => 'No Procesada',
                'comentario' => 'Error al procesar: ' . $e->getMessage()
            ]);

            Log::error("Error procesando nómina ID {$ejecucion->id}: " . $e->getMessage());

            return redirect()->route('nomina.index')
                ->with('error', 'Error al procesar: ' . $e->getMessage());
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

    public function anular(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|min:10|max:255'
        ]);

        try {
            $ejecucion = EjecucionNomina::findOrFail($id);

            if ($ejecucion->estado === 'Procesando...') {
                return redirect()->back()->with('error', 'No se puede anular una nómina en proceso.');
            }

            $ejecucion->update([
                'estado'     => 'Anulada',
                'comentario' => 'ANULADA: ' . $request->motivo . ' (Por ' . Auth::user()->name . ' el ' . now()->format('d/m/Y H:i') . ')'
            ]);

            return redirect()->route('nomina.index')->with('success', 'Nómina anulada correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al anular la nómina: ' . $e->getMessage());
        }
    }
}
