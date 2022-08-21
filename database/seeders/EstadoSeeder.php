<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            [
                'nombre' => 'Amazonas',
            ],
            [
                'nombre' => 'Anzoátegui',
            ],
            [
                'nombre' => 'Apure',
            ],
            [
                'nombre' => 'Aragua',
            ],
            [
                'nombre' => 'Barinas',
            ],
            [
                'nombre' => 'Bolívar',
            ],
            [
                'nombre' => 'Carabobo',
            ],
            [
                'nombre' => 'Cojedes',
            ],
            [
                'nombre' => 'Delta Amacuro',
            ],
            [
                'nombre' => 'Distrito Capital',
            ],
            [
                'nombre' => 'Falcón',
            ],
            [
                'nombre' => 'Guárico',
            ],
            [
                'nombre' => 'La Guaira',
            ],
            [
                'nombre' => 'Lara',
            ],
            [
                'nombre' => 'Mérida',
            ],
            [
                'nombre' => 'Miranda',
            ],
            [
                'nombre' => 'Monagas',
            ],
            [
                'nombre' => 'Cojedes',
            ],
            [
                'nombre' => 'Nueva Esparta',
            ],
            [
                'nombre' => 'Portuguesa',
            ],
            [
                'nombre' => 'Sucre',
            ],
            [
                'nombre' => 'Táchira',
            ],
            [
                'nombre' => 'Trujillo',
            ],
            [
                'nombre' => 'Yaracuy',
            ],
            [
                'nombre' => 'Zulia',
            ],
            [
                'nombre' => 'Sucre',
            ],
        ];
        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
