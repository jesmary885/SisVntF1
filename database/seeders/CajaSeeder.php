<?php

namespace Database\Seeders;

use App\Models\Caja;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cajas = [
            [
               'nombre' => 'Principal_Caja1',
               'sucursal_id' => '1',
               'saldo_bolivares' => '0',
               'saldo_dolares' => '0',
               'status' => 'Habilitada',
            ],
           /* [
                'nombre' => 'Principal_Caja2',
                'sucursal_id' => '1',
                'saldo_bolivares' => '0',
               'saldo_dolares' => '0',
                'status' => 'Habilitada',
             ],
             [
                'nombre' => 'Tienda1_Caja1',
                'sucursal_id' => '2',
                'saldo_bolivares' => '0',
               'saldo_dolares' => '0',
                'status' => 'Habilitada',
             ],
             [
                'nombre' => 'Tienda1_Caja2',
                'sucursal_id' => '2',
                'saldo_bolivares' => '0',
               'saldo_dolares' => '0',
                'status' => 'Habilitada',
             ],
             [
                'nombre' => 'Tienda2_Caja1',
                'sucursal_id' => '3',
                'saldo_bolivares' => '0',
               'saldo_dolares' => '0',
                'status' => 'Habilitada',
             ],*/
            ];

             foreach ($cajas as $caja){
                Caja::create($caja);
             }
    }
}
