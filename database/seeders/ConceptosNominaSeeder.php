<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptosNominaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deducciones
        \App\Models\Deduccion::create(['nombre' => 'Seguro Social', 'tasa' => 4.00, 'tipo' => 'Porcentaje']);
        \App\Models\Deduccion::create(['nombre' => 'Impuesto sobre la Renta', 'tasa' => 10.00, 'tipo' => 'Porcentaje']);
        \App\Models\Deduccion::create(['nombre' => 'Fondo de Pensiones', 'tasa' => 2.00, 'tipo' => 'Porcentaje']);

        // Beneficios
        \App\Models\Beneficio::create(['nombre' => 'Bono Alimenticio', 'tasa' => 50.00, 'tipo' => 'Fijo']);
        \App\Models\Beneficio::create(['nombre' => 'Bono Transporte', 'tasa' => 20.00, 'tipo' => 'Fijo']);
        \App\Models\Beneficio::create(['nombre' => 'Antigüedad', 'tasa' => 1.50, 'tipo' => 'Porcentaje']);
    }
}
