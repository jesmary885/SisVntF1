<?php

namespace Database\Seeders;

use App\Models\Metodo_pago;
use Illuminate\Database\Seeder;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $metodos = [
            [
               'nombre' => 'Tarjeta de Debito',
            ],
            [
               'nombre' => 'Tarjeta de Credito',
            ],
            [
               'nombre' => 'Efectivo Bolivares',
            ],
            [
               'nombre' => 'Efectivo Dólares',
            ],
            [
               'nombre' => 'Transferencia',
            ],
            [
                'nombre' => 'Pago movil',
             ],
             [
                'nombre' => 'Binance',
             ],
             [
                'nombre' => 'Zelle',
             ],
             [
                'nombre' => 'PayPal',
             ],
             [
                'nombre' => 'Otros',
             ],
        ];

        foreach ($metodos as $metodo){
            Metodo_pago::create($metodo);
        }
    }
}
