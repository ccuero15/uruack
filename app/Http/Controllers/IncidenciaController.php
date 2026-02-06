<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Empleado;
use App\Models\TipoIncidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index() {
        $incidencias = Incidencia::with(['empleado', 'tipoIncidencia'])
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(15);
        return view('incidencias.index', compact('incidencias'));
    }

    public function create() {
        $empleados = Empleado::where('estado', 'Activo')->get();
        $tipos = TipoIncidencia::all();
        return view('incidencias.create', compact('empleados', 'tipos'));
    }

    public function edit(Incidencia $incidencia) {
        $empleados = Empleado::all();
        $tipos = TipoIncidencia::all();
        return view('incidencias.edit', compact('incidencia', 'empleados', 'tipos'));
    }

    public function update(Request $request, Incidencia $incidencia) {
        $data = $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'tipo_incidencia_id' => 'required|exists:tipos_incidencia,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'horas_extras' => 'nullable|numeric|min:0',
            'observacion' => 'nullable|string',
        ]);

        $incidencia->update($data);
        return redirect()->route('incidencias.index')->with('success', 'Incidencia actualizada.');
    }

    public function destroy(Incidencia $incidencia) {
        $incidencia->delete();
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada.');
    }
}
