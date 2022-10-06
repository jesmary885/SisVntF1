<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Producto_sucursal;
use Illuminate\Database\Seeder;

class ProductoSucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = Producto::all();

             foreach ($productos as $producto){
                $producto->sucursals()->attach([
                    1 => [
                        'cantidad' => 20,
                        'lote'     => 1,
                    ],
                    2 => [
                        'cantidad' => 5,
                        'lote'     => 1,
                    ],
                    3 => [
                        'cantidad' => 0,
                        'lote'     => 0,
                    ],
                ]);
             }

             foreach ($productos as $producto){
                $producto->sucursals()->attach([
                    1 => [
                        'cantidad' => 20,
                        'lote'     => 2,
                    ],
                    2 => [
                        'cantidad' => 5,
                        'lote'     => 2,
                    ],
                ]);
             }

    }
}
