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
        $request->validate([
            'periodo_inicio' => 'required|date',
            'periodo_fin' => 'required|date|after:periodo_inicio',
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear cabecera
            $ejecucion = EjecucionNomina::create([
                'periodo_inicio' => $request->periodo_inicio,
                'periodo_fin'    => $request->periodo_fin,
                'fecha_ejecucion' => now(),
                'estado'         => 'Procesada'
            ]);

            // 2. Obtener empleados con contrato vigente
            $empleados = Empleado::where('estado', 'Activo')
                ->whereHas('contratos', function ($q) {
                    $q->where('estado', 'Vigente');
                })->get();

            if ($empleados->isEmpty()) {
                throw new \Exception('No hay empleados activos con contratos vigentes.');
            }

            // 3. Procesar cada empleado usando el Servicio
            foreach ($empleados as $empleado) {
                $service->procesarEmpleado($ejecucion->id, $empleado->id);
            }

            DB::commit();
            return redirect()->route('nomina.show', $ejecucion->id)->with('success', 'Nómina procesada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
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
