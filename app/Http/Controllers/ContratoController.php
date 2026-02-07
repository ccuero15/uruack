<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\Cargo;
use App\Models\JornadaLaboral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::with(['empleado', 'cargo'])->paginate(10);
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        $empleados = Empleado::where('estado', 'Activo')->get();
        $cargos = Cargo::all();
        $jornadas = JornadaLaboral::all();
        return view('contratos.create', compact('empleados', 'cargos', 'jornadas'));
    }

    public function store(Request $request)
    {
        try {
            // 1. Validación estricta
            $data = $request->validate([
                'empleado_id'   => 'required|exists:empleados,id',
                'cargo_id'      => 'required|exists:cargos,id',
                'jornada_id'    => 'required|exists:jornadas_laborales,id',
                'fecha_inicio'  => 'required|date',
                'fecha_fin'     => 'nullable|date|after_or_equal:fecha_inicio',
                'salario_base'  => 'required|numeric|min:0',
                'tipo_contrato' => 'required|string|max:100',
                'estado'        => 'required|in:Vigente,Vencido,Finalizado',
            ]);

            // 2. Transacción para asegurar integridad
            DB::transaction(function () use ($data, $request) {
                // Desactivar contratos previos para este empleado
                Contrato::where('empleado_id', $request->empleado_id)
                    ->where('estado', 'Vigente')
                    ->update(['estado' => 'Finalizado']);

                // Crear el nuevo contrato
                Contrato::create($data);
            });

            return redirect()->route('contratos.index')
                ->with('success', 'Contrato vinculado exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Laravel maneja esto y vuelve a la vista con $errors
            throw $e;
        } catch (\Exception $e) {
            // Error de base de datos o lógica (ej: el error de null que tenías)
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al procesar el contrato: ' . $e->getMessage());
        }
    }
}
