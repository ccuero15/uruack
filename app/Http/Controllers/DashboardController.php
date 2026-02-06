<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\EjecucionNomina;
use App\Models\ItemNomina;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'total_empleados' => Empleado::where('estado', 'Activo')->count(),
            'ultima_nomina' => EjecucionNomina::latest()->first(),
            'gasto_total_mes' => ItemNomina::whereHas('ejecucion', function($q) {
                $q->whereMonth('fecha_ejecucion', now()->month);
            })->sum('salario_neto'),
            'proximos_vencimientos' => DB::table('contratos')
                ->join('empleados', 'contratos.empleado_id', '=', 'empleados.id')
                ->where('contratos.estado', 'Vigente')
                ->whereNotNull('fecha_fin')
                ->where('fecha_fin', '<=', now()->addDays(30))
                ->select('empleados.nombre', 'empleados.apellido', 'contratos.fecha_fin')
                ->get(),
        ];

        return view('dashboard', compact('stats'));
    }
}
