<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

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
            'cedula' => 'required|unique:empleados,cedula',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'nullable|email|unique:empleados,email',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        Empleado::create($data);
        return redirect()->route('empleados.index')->with('success', 'Empleado registrado.');
    }

    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado)
    {
        $data = $request->validate([
            'cedula' => "required|unique:empleados,cedula,{$empleado->id}",
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => "nullable|email|unique:empleados,email,{$empleado->id}",
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo,Suspendido',
        ]);

        $empleado->update($data);
        return redirect()->route('empleados.index')->with('success', 'Datos actualizados.');
    }

    public function destroy(Empleado $empleado)
    {
        // Validación: Si tiene nóminas procesadas, quizás prefieras no borrarlo sino inactivarlo
        if ($empleado->itemsNomina()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar: el empleado tiene historial de nómina.');
        }

        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
    }
}
