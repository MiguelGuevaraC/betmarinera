<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Pre Infante', 'Infante', 'Infantil', 'Junior',
            'Juvenil', 'Adulto', 'Senior', 'Master',
            'Oro', 'Unidad', 'Campeon de Campeones'
        ];
        
        // Lista de nombres posibles
        $randomNames = ['Miguel', 'Julia', 'Carlos', 'Ana', 'Luis', 'Sofía', 'Juan', 'Marta', 'Pedro', 'Lucía'];
        
        foreach ($categories as $categoryName) {
            // Insertar la categoría y obtener su ID
            $categoryId = DB::table('categories')->insertGetId([
                'name' => $categoryName,
                'contest_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        
            // Seleccionar nombres aleatorios para los participantes
            $selectedNames = array_rand(array_flip($randomNames), 2);
        
            // Insertar los participantes
            DB::table('contestants')->insert([
                ['contest_id'=>1,'names' => 'Otros', 'description' => 'Participante por defecto', 'category_id' => $categoryId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['contest_id'=>1,'names' => $selectedNames[0], 'description' => 'Participante asignado aleatoriamente', 'category_id' => $categoryId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['contest_id'=>1,'names' => $selectedNames[1], 'description' => 'Participante asignado aleatoriamente', 'category_id' => $categoryId, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ]);
        }
    }
}
