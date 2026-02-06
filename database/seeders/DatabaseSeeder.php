<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    /*  public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PositionSeeder::class);
    } */


    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            TipoContratoSeeder::class,
            JornadaLaboralSeeder::class,
            CargoSeeder::class,
            ConceptosNominaSeeder::class,
            UserSeeder::class,
        ]);

        // Crear un usuario administrador de prueba relacionado con el Rol 1
        \App\Models\User::factory()->create([
            'name' => 'Admin Sistema',
            'email' => 'admin@empresa.com',
            'password' => bcrypt('password'),
            'rol_id' => 1,
            'activo' => true,
        ]);
    }
}
