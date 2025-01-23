<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Permission_rol;
use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeUserAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $validPermissions=[1,2,3,4,5];
        $role= Rol::create(['name' => 'Administrador']);

        foreach ($validPermissions as $permission_id) {
            $permission= Permission::find($permission_id);
            Permission_rol::Create(
                [
                    'name_permission' => $permission->name,
                    'name_rol' => $role->name,
                    'type' => $role->type,
                    'rol_id' => $role->id,
                    'permission_id' => $permission->id,
                ]
            );
        }
        $role= Rol::create(['name' => 'Apostador']);
        $validPermissions=[1,4,5];
        foreach ($validPermissions as $permission_id) {
            $permission= Permission::find($permission_id);
            Permission_rol::Create(
                [
                    'name_permission' => $permission->name,
                    'name_rol' => $role->name,
                    'type' => $role->type,
                    'rol_id' => $role->id,
                    'permission_id' => $permission->id,
                ]
            );
        }
    }
}
