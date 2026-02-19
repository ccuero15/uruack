<?php

namespace App\Services;

use App\Models\EjecucionNomina;
use App\Models\Empleado;
use App\Models\Deduccion;
use App\Models\Beneficio;
use App\Models\Incidencia;
use App\Models\ItemNomina;
use App\Models\ItemNominaDeduccion;
use App\Models\ItemNominaBeneficio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NominaService
{
    public function procesarEmpleado($ejecucionId, $empleadoId)
    {
        return DB::transaction(function () use ($ejecucionId, $empleadoId) {
            $empleado = Empleado::findOrFail($empleadoId);
            $contrato = $empleado->contratos()->where('estado', 'Vigente')->first();

            if (!$contrato) return null;

            $salarioBruto = $contrato->salario_base;
            $totalDeducciones = 0;
            $totalBeneficios = 0;

            // 1. Crear el Item de Nómina base
            $itemNomina = ItemNomina::create([
                'ejecucion_id' => $ejecucionId,
                'empleado_id'  => $empleadoId,
                'salario_bruto' => $salarioBruto,
                'total_deducciones' => 0,
                'total_beneficios' => 0,
                'salario_neto' => 0,
            ]);

            // 2. Calcular y registrar Deducciones
            $deducciones = Deduccion::all();
            foreach ($deducciones as $ded) {
                $monto = ($ded->tipo === 'Porcentaje')
                    ? $salarioBruto * ($ded->tasa / 100)
                    : $ded->tasa;

                ItemNominaDeduccion::create([
                    'item_nomina_id' => $itemNomina->id,
                    'deduccion_id'   => $ded->id,
                    'monto'          => $monto
                ]);
                $totalDeducciones += $monto;
            }

            // 3. Calcular y registrar Beneficios
            $beneficios = Beneficio::all();
            foreach ($beneficios as $ben) {
                $monto = ($ben->tipo === 'Porcentaje')
                    ? $salarioBruto * ($ben->tasa / 100)
                    : $ben->tasa;

                ItemNominaBeneficio::create([
                    'item_nomina_id' => $itemNomina->id,
                    'beneficio_id'   => $ben->id,
                    'monto'          => $monto
                ]);
                $totalBeneficios += $monto;
            }

            // 4. Procesar Incidencias (LOTTT)
            $ejecucion = EjecucionNomina::findOrFail($ejecucionId);
            $incidencias = Incidencia::with('tipoIncidencia')
                ->where('empleado_id', $empleadoId)
                ->where('fecha_inicio', '>=', $ejecucion->periodo_inicio)
                ->where('fecha_inicio', '<=', $ejecucion->periodo_fin)
                ->get();

            foreach ($incidencias as $inc) {
                $tipo = $inc->tipoIncidencia;
                if ($tipo->tipo_ajuste === 'Informativo') continue;

                $monto = 0;
                $sd = $salarioBruto / 30;
                $sh = $sd / 8;

                // Lógica de "Injustificado": Descontar el día completo
                $esInjustificado = str_contains(strtolower($tipo->nombre), 'injustificada');

                if ($esInjustificado) {
                    $monto = $sd; // Día completo sin importar horas o rango.
                    // Si el usuario registró un rango de días, multiplicamos.
                    if ($inc->fecha_fin) {
                        $start = Carbon::parse($inc->fecha_inicio);
                        $end = Carbon::parse($inc->fecha_fin);
                        $dias = $start->diffInDays($end) + 1;
                        $monto = $sd * $dias;
                    }
                } elseif ($inc->horas_extras > 0) {
                    $monto = $sh * $tipo->factor * $inc->horas_extras;
                } else {
                    $start = Carbon::parse($inc->fecha_inicio);
                    $end = $inc->fecha_fin ? Carbon::parse($inc->fecha_fin) : $start;
                    $dias = $start->diffInDays($end) + 1;
                    $monto = $sd * $tipo->factor * $dias;
                }

                if ($tipo->tipo_ajuste === 'Suma') {
                    ItemNominaBeneficio::create([
                        'item_nomina_id' => $itemNomina->id,
                        'beneficio_id'   => null,
                        'monto'          => $monto,
                        'descripcion'    => $tipo->nombre . ($inc->horas_extras > 0 ? " ({$inc->horas_extras}h)" : "")
                    ]);
                    $totalBeneficios += $monto;
                } elseif ($tipo->tipo_ajuste === 'Resta') {
                    ItemNominaDeduccion::create([
                        'item_nomina_id' => $itemNomina->id,
                        'deduccion_id'   => null,
                        'monto'          => $monto,
                        'descripcion'    => $tipo->nombre . ($esInjustificado ? " (Día Completo)" : "")
                    ]);
                    $totalDeducciones += $monto;
                }
            }

            // 4. Actualizar totales finales
            $salarioNeto = ($salarioBruto + $totalBeneficios) - $totalDeducciones;

            $itemNomina->update([
                'total_deducciones' => $totalDeducciones,
                'total_beneficios'  => $totalBeneficios,
                'salario_neto'      => $salarioNeto
            ]);

            return $itemNomina;
        });
    }
}
