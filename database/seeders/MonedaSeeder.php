<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Seeder;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monedas = [
            [
                'nombre' => 'Bolivar',
                'simbolo' => 'Bs',
            ],
            [
                'nombre' => 'Dolar',
                'simbolo' => '$',
            ],
            [
                'nombre' => 'Euro',
                'simbolo' => '€',
            ],
            [
                'nombre' => 'Yuan',
                'simbolo' => '¥',
            ]
        ];

        foreach ($monedas as $moneda) {
            Moneda::create($moneda);
        }

    }
}
