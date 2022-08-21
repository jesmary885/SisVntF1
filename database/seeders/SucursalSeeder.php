<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use Illuminate\Database\Seeder;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursales = [
            [
               'nombre' => 'Principal',
               'direccion' => 'avenida x',
               'telefono' => '555555',
               'estado_id' => '1',
               'ciudad_id' => '1',
               'saldo' => '0',
               'status' => '1',
            ],
            [
                'nombre' => 'Tienda 1',
               'direccion' => 'avenida x',
               'telefono' => '555555',
               'estado_id' => '1',
               'ciudad_id' => '1',
               'saldo' => '0',
               'status' => '1',
             ],
             [
                'nombre' => 'Tienda 2',
               'direccion' => 'avenida x',
               'telefono' => '555555',
               'estado_id' => '1',
               'ciudad_id' => '1',
               'saldo' => '0',
               'status' => '1',
             ],
            ];

             foreach ($sucursales as $sucursal){
                Sucursal::create($sucursal);
             }
    }
}
