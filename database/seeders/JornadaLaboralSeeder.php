<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JornadaLaboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jornadas = [
            ['nombre' => 'Tiempo Completo', 'horas_semanales' => 40],
            ['nombre' => 'Media Jornada', 'horas_semanales' => 20],
            ['nombre' => 'Jornada Especial', 'horas_semanales' => 45],
        ];

        foreach ($jornadas as $jornada) {
            \App\Models\JornadaLaboral::create($jornada);
        }
    }
}
