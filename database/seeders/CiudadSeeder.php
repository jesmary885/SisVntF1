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
                'nombre' => 'Ciudad Bolívar',
                'estado_id' => '6',
            ],
            [
                'nombre' => 'Caracas',
                'estado_id' => '10',
            ],
            [
                'nombre' => 'Maracaibo',
                'estado_id' => '25',
            ],
            [
                'nombre' => 'Valencia',
                'estado_id' => '7',
            ],
            [
                'nombre' => 'Maracay',
                'estado_id' => '4',
            ],
            [
                'nombre' => 'San Cristobal',
                'estado_id' => '22',
            ],
            [
                'nombre' => 'Barcelona',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'El Tigre',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'El Tigrito',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'Anaco',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'San Tomé',
                'estado_id' => '2',
            ],
            [
                'nombre' => 'Maturín',
                'estado_id' => '17',
            ],
            [
                'nombre' => 'Guanare',
                'estado_id' => '20',
            ],
            [
                'nombre' => 'San Fernando de Apure',
                'estado_id' => '3',
            ],
            [
                'nombre' => 'Barquisimeto',
                'estado_id' => '14',
            ],
            [
                'nombre' => 'Los Teques',
                'estado_id' => '16',
            ],
            [
                'nombre' => 'San Juan de los Morros',
                'estado_id' => '12',
            ],
            [
                'nombre' => 'La Asunción',
                'estado_id' => '19',
            ],
            [
                'nombre' => 'San Felipe',
                'estado_id' => '24',
            ],
            [
                'nombre' => 'Puerto Ayacucho',
                'estado_id' => '1',
            ],
        ];
        foreach ($ciudades as $ciudad) {
            Ciudad::create($ciudad);
        }
    }
}
