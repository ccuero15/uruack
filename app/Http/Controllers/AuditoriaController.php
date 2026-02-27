<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empleado;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Contrato::with(['empleado', 'cargo'])
            ->orderBy('id', 'desc');

        if ($request->filled('empleado_id')) {
            $query->where('empleado_id', $request->empleado_id);
        }

        $contratos = $query->paginate(15);
        $empleados = Empleado::orderBy('nombre')->get();

        return view('auditoria.index', compact('contratos', 'empleados'));
    }
}
