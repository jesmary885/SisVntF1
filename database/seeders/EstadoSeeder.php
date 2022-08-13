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
                'nombre' => 'Barranca',
            ],
            [
                'nombre' => 'Cajatambo',
            ],
            [
                'nombre' => 'Canta',
            ],
            [
                'nombre' => 'Cañete',
            ],
            [
                'nombre' => 'Huaral',
            ],
            [
                'nombre' => 'Huarochirí',
            ],
            [
                'nombre' => 'Huaura',
            ],
            [
                'nombre' => 'Lima',
            ],
            
        ];

        foreach ($estados as $estado) {
            Estado::create($estado);
        }
    }
}
