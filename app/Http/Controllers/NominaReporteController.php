<?php

namespace App\Http\Controllers;

use App\Models\EjecucionNomina;
use Illuminate\Http\Request;

class NominaReporteController extends Controller
{
    public function general($id)
    {
        // Cargamos la ejecución con todos sus ítems, empleados y cargos
        $nomina = EjecucionNomina::with([
            'items.empleado.contratos.cargo'
        ])->findOrFail($id);

        return view('nomina.reporte_general', compact('nomina'));
    }
}
