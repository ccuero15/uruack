<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Indefinido', 'descripcion' => 'Contrato sin fecha de finalización'],
            ['nombre' => 'Temporal', 'descripcion' => 'Contrato por obra o tiempo determinado'],
            ['nombre' => 'Aprendizaje', 'descripcion' => 'Contrato de formación'],
        ];

        foreach ($tipos as $tipo) {
            \App\Models\TipoContrato::create($tipo);
        }
    }
}
