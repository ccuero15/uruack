<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Acceso total al sistema'],
            ['nombre' => 'Recursos Humanos', 'descripcion' => 'Gestión de personal y nómina'],
            ['nombre' => 'Empleado', 'descripcion' => 'Acceso limitado a sus propios recibos'],
        ];

        foreach ($roles as $rol) {
            \App\Models\Role::create($rol);
        }
    }
}
