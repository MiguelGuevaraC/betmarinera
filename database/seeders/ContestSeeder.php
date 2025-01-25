<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('contests')->insert([
            'name'       => 'Concurso Nacional de Marinera',
            'start_date' => Carbon::today()->startOfDay(), // Hoy a las 00:00:00
            'end_date'   => Carbon::today()->endOfDay(),   // Hoy a las 23:59:59
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
