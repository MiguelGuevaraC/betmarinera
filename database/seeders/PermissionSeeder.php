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
        Permission::create(['name' => 'Inicio', 'icon' => 'fa fa-home', 'route' => 'home', 'type' => 'Vistas']);
        Permission::create(['name' => 'Apostadores', 'icon' => 'fa fa-users', 'route' => 'users', 'type' => 'Vistas']);
        Permission::create(['name' => 'Concursos', 'icon' => 'fa fa-trophy', 'route' => 'concursos-list', 'type' => 'Vistas']);
        Permission::create(['name' => 'Apuestas', 'icon' => 'fa fa-calendar-check', 'route' => 'concursos-active', 'type' => 'Vistas']);
        Permission::create(['name' => 'Perfil', 'icon' => 'fa fa-pencil-alt', 'route' => 'profile', 'type' => 'Vistas']);
    }
}
