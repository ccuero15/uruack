<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            ['titulo' => 'Gerente de IT', 'departamento' => 'Sistemas', 'salario_referencial' => 3500.00],
            ['titulo' => 'Analista Contable', 'departamento' => 'Finanzas', 'salario_referencial' => 1800.00],
            ['titulo' => 'Desarrollador Junior', 'departamento' => 'Sistemas', 'salario_referencial' => 1200.00],
        ];

        foreach ($cargos as $cargo) {
            \App\Models\Cargo::create($cargo);
        }
    }
}
