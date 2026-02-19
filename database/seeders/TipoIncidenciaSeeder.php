<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoIncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Horas Extras Diurnas',
                'afecta_pago' => true,
                'tipo_ajuste' => 'Suma',
                'factor' => 1.50, // 50% recargo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Horas Extras Nocturnas',
                'afecta_pago' => true,
                'tipo_ajuste' => 'Suma',
                'factor' => 1.95, // (1 + 0.30 nocturno) * 1.50 extra = 1.95
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Inasistencia Injustificada',
                'afecta_pago' => true,
                'tipo_ajuste' => 'Resta',
                'factor' => 1.00, // Descuento del día simple
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reposo Médico (Validado)',
                'afecta_pago' => false,
                'tipo_ajuste' => 'Informativo',
                'factor' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Permiso Especial Remunerado',
                'afecta_pago' => false,
                'tipo_ajuste' => 'Informativo',
                'factor' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Bono de Productividad Puntual',
                'afecta_pago' => true,
                'tipo_ajuste' => 'Suma',
                'factor' => 1.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tipos_incidencia')->truncate();
        DB::table('tipos_incidencia')->insert($tipos);
    }
}
