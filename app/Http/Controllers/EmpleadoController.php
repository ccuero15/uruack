<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('id', 'desc')->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cedula' => 'required|string|max:20|unique:empleados,cedula',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|max:150|unique:empleados,email',
            'direccion' => 'nullable|string',
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        try {
            Empleado::create($data);
            return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el empleado: ' . $e->getMessage());
        }
    }

    public function edit(Empleado $empleado)
    {
        $cargos = \App\Models\Cargo::all();
        $contratoVigente = $empleado->contratos()->where('estado', 'Vigente')->first();
        return view('empleados.edit', compact('empleado', 'cargos', 'contratoVigente'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'cedula' => "required|string|max:20|unique:empleados,cedula,{$empleado->id}",
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => "nullable|email|max:150|unique:empleados,email,{$empleado->id}",
            'fecha_ingreso' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
            // Campos opcionales del contrato
            'salario_base' => 'nullable|numeric|min:0',
            'cargo_id' => 'nullable|exists:cargos,id',
        ]);

        try {
            DB::transaction(function () use ($empleado, $data) {
                $empleado->update($data);

                // Si se enviaron datos de contrato y existe un contrato vigente, actualizarlo
                if (isset($data['salario_base']) || isset($data['cargo_id'])) {
                    $contrato = $empleado->contratos()->where('estado', 'Vigente')->first();
                    if ($contrato) {
                        $contrato->update(array_filter([
                            'salario_base' => $data['salario_base'] ?? null,
                            'cargo_id' => $data['cargo_id'] ?? null,
                        ]));
                    }
                }
            });

            return redirect()->route('empleados.index')->with('success', 'Datos del empleado y contrato actualizados.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            if ($empleado->itemsNomina()->count() > 0) {
                return redirect()->back()->with('error', 'No se puede eliminar físicamente: el empleado tiene historial de nómina. Considere desactivarlo.');
            }

            $empleado->delete();
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado (Soft Delete).');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }

    public function desactivar($id)
    {
        $empleado = Empleado::findOrFail($id);

        DB::beginTransaction();
        try {
            $empleado->update(['estado' => 'Inactivo']);

            // Anular contratos vigentes
            $empleado->contratos()->where('estado', 'Vigente')->update([
                'estado' => 'Anulado',
                'fecha_fin' => now()
            ]);

            DB::commit();
            return redirect()->route('empleados.index')->with('success', 'Empleado desactivado y contrato vigente anulado.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al desactivar: ' . $e->getMessage());
        }
    }
}
