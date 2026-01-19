<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $list = [

            [
                "name" => "presidente",
                "description" => "Presidente de la empresa"
            ],
            [
                "name" => "secretaria",
                "description" => "Secretaria de la empresa"
            ],
            [
                "name" => "analista",
                "description" => "Analista de sistemas"
            ],
            [
                "name" => "empleado",
                "description" => "Empleado de la empresa (general)"
            ],
            [
                "name" => "especialista",
                "description" => "Especialista"
            ],

        ];

        // User::factory(10)->create();
        Position::insert($list);
    }
}
