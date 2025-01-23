<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'first_name' => 'Administrador',
            'last_name' => 'Sistema',
            'email' => 'guevaracajusolmiguel@gmail.com',
            'password' => Hash::make('miguel123'), // Asegúrate de usar una contraseña segura
            'rol_id' => 1, // Suponiendo que '1' es el rol de administrador
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
