<?php

namespace Database\Seeders;

use App\Models\Modelo;
use Illuminate\Database\Seeder;

class ModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modelos = [
            [
               'nombre' => 'Modelo 1',
               'marca_id' => '1',
            ],
            [
                'nombre' => 'Modelo 2',
                'marca_id' => '1',
             ],
             [
                'nombre' => 'Modelo 3',
                'marca_id' => '2',
             ],
             [
                'nombre' => 'Modelo 4',
                'marca_id' => '2',
             ],
             [
                'nombre' => 'Modelo 5',
                'marca_id' => '3',
             ],
             [
                'nombre' => 'Modelo 6',
                'marca_id' => '5',
             ],
             [
                'nombre' => 'Modelo 7',
                'marca_id' => '4',
             ],
             [
                'nombre' => 'Modelo 8',
                'marca_id' => '5',
             ],
             [
                'nombre' => 'Modelo 9',
                'marca_id' => '5',
             ],
          

            ];

             foreach ($modelos as $modelo){
                Modelo::create($modelo);
             }
    }
}
