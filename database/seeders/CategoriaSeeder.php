<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            [
               'nombre' => 'TACTIL',
            ],
           /* [
                'nombre' => 'LCD',
             ],
             [
                'nombre' => 'TACTIL+LCD',
             ],
             [
                'nombre' => 'TAPA',
             ],
             [
                'nombre' => 'GLASS',
             ],
             [
                'nombre' => 'SOCALOS',
             ],
             [
                'nombre' => 'FLEX DE CARGA',
             ],
             [
                'nombre' => 'OCA',
             ],
             [
                'nombre' => 'BATERIAS',
             ],
             [
                'nombre' => 'DESTORNILLADOR',
             ],
             [
                'nombre' => 'REMOV DE ESTAÑO',
             ],
             [
                'nombre' => 'BISEL',
             ],
             [
                'nombre' => 'CAUTIL',
             ],
             [
               'nombre' => 'MICRO',
            ],
            [
               'nombre' => 'DIRECCIONALES',
            ],
            [
               'nombre' => 'PINSA',
            ],
            [
               'nombre' => 'CINTA',
            ],
            [
               'nombre' => 'HILO',
            ],
            [
               'nombre' => 'PEGAMENTO',
            ],*/

            ];

             foreach ($categorias as $categoria){
                Categoria::create($categoria);
             }
    }
}
