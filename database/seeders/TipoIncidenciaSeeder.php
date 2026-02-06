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
                'afecta_pago' => true, // Suma al salario
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Horas Extras Nocturnas',
                'afecta_pago' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Inasistencia Injustificada',
                'afecta_pago' => true, // Resta del pago (deducción)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reposo Médico (Validado)',
                'afecta_pago' => false, // Solo informativo para el expediente
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Permiso Especial Remunerado',
                'afecta_pago' => false, // No afecta el cálculo porque se paga normal
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Bono de Productividad Puntual',
                'afecta_pago' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tipos_incidencia')->insert($tipos);
    }
}
