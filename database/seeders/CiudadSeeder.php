<?php

namespace Database\Seeders;

use App\Models\Ciudad;
use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $ciudades = [
            [
                'nombre' => 'Lima',
                'estado_id' => '8',
            ],
            [
                'nombre' => 'Barranca',
                'estado_id' => '1',
            ],
            [
                'nombre' => 'BSupe',
                'estado_id' => '1',
            ],
            [
                'nombre' => 'Paramonga',
                'estado_id' => '1',
            ],
            [
                'nombre' => 'Pativilca',
                'estado_id' => '1',
            ],
            [
                'nombre' => 'Supe Puerto',
                'estado_id' => '1',
            ],
            [
                'nombre' => 'Arahuay',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'Canta',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'Lachaqui',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'San Buenaventura',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'Mala',
                'estado_id' => '3',
            ],
            [
                'nombre' => 'Imperial',
                'estado_id' => '3',
            ],
            [
                'nombre' => 'Nuevo Imperial',
                'estado_id' => '3',
            ],
            
        ];

        foreach ($ciudades as $ciudad) {
            Ciudad::create($ciudad);
        }
    }
}
