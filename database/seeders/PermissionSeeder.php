<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permisos para "Usuarios"
        Permission::create(['name' => 'home', 'type' => 'Vistas']);
        Permission::create(['name' => 'users', 'type' => 'Vistas']);
        Permission::create(['name' => 'concursos-list', 'type' => 'Vistas']);
        Permission::create(['name' => 'concursos-active', 'type' => 'Vistas']);
        Permission::create(['name' => 'profile', 'type' => 'Vistas']);
    }
}
